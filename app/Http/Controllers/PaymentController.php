<?php

namespace App\Http\Controllers;

use Exception;
use App\Entities\User;
use App\Entities\Order;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Services\PaymentData;
use App\Services\CartService;
use Illuminate\Routing\Redirector;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Payment\PaymentInfoRequest;
use Dnetix\Redirection\Exceptions\PlacetoPayException;


class PaymentController extends Controller
{
    /**
     * @var CartService
     */
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
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
    public function store(PlacetoPay $placetopay, PaymentInfoRequest $request): RedirectResponse
    {
        $orderData = array_merge($request->all(), [
            'reference' => substr(Str::uuid()->toString(), 0, 10),
            'user_id' => Auth::id(),
            'total' => $this->cartService->getACartFromUser()->getTotal()
        ]);

        $order = Order::create($orderData);

        foreach ($this->cartService->getAContentCartFromAUser() as $product) {
            $order->products()->attach($product['id']);
        }

        try {
            $payment = new PaymentData($order);

            $response = $placetopay->request($payment->setPayment());

            if ($response->isSuccessful()) {
                $response->processUrl();

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

        return view('webcheckout.endTransaction', compact('order'));
    }

    /**
     * @param PlacetoPay $placetopay
     * @param Order $order
     * @return Application|RedirectResponse|Redirector
     * @throws PlacetoPayException
     */
    public function reDonePayment(PlacetoPay $placetopay, Order $order)
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
