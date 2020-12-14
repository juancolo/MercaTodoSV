<?php

namespace App\Http\Controllers\Ecomerce;

use Exception;
use App\Entities\User;
use App\Entities\Order;
use Illuminate\View\View;
use App\Services\PaymentData;
use App\Services\CartService;
use Illuminate\Routing\Redirector;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Log;
use App\Repository\OrderRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Payment\PaymentInfoRequest;
use Dnetix\Redirection\Exceptions\PlacetoPayException;


class PaymentController extends Controller
{
    /**
     * @var CartService
     * * @var OrderRepository
     */
    private CartService $cartService;
    protected OrderRepository $orderRepo;

    public function __construct(CartService $cartService, OrderRepository $orderRepo)
    {
        $this->cartService = $cartService;
        $this->orderRepo = $orderRepo;
    }

    /**
     * @param User $user
     * @return RedirectResponse|View
     */
    public function index(User $user): View
    {
        if ($this->cartService->getACartFromUser()->isEmpty()) {
            return redirect()->route('client.product');
        }
        return view('webcheckout.index', compact('user'));
    }

    /**
     * @param PlacetoPay $placetopay
     * @param PaymentInfoRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(PlacetoPay $placetopay, PaymentInfoRequest $request)
    {
        $order = $this->orderRepo->createOrder($request->all());

        try {
            $payment = new PaymentData($order);

            $response = $placetopay->request($payment->setPayment());

            if ($response->isSuccessful()) {
                $order->requestId = $response->requestId;
                $order->processUrl = $response->processUrl;
                $order->status = $response->status()->status();
                $order->save();

                return redirect($response->processUrl());
            } else {
                return redirect()->route('order.show');
            }
        } catch (Exception $e) {
            Log::error('payment', [
                'line' => $e->getLine(),
                'message' => $e->getMessage(),
                'file' => $e->getFile()
            ]);
        }
    }

    /**
     * @param PlacetoPay $placetopay
     * @param Order $order
     * @return Application|Factory|View
     */
    public function endTransaction(PlacetoPay $placetopay, Order $order)
    {
        $response = $placetopay->query($order->requestId);
        $order->status = $response->status()->status();
        $order->save();

        $this->cartService->getACartFromUser()->clear();

        return view('webcheckout.end_transaction', compact('order'))
            ->with('status', trans('e-comerce.end_transaction'));
    }

    /**
     * @param PlacetoPay $placetopay
     * @param Order $order
     * @return RedirectResponse
     * @throws PlacetoPayException
     */
    public function reDonePayment(PlacetoPay $placetopay, Order $order): RedirectResponse
    {
        $payment = new PaymentData($order);
        $response = $placetopay->request($payment->setPayment());

        $order->requestId = $response->requestId;
        $order->processUrl = $response->processUrl;
        $order->status = $response->status()->status();
        $order->save();

        return redirect($response->processUrl());
    }
}
