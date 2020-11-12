<?php

namespace App\Http\Controllers;

use Ramsey\Uuid\Uuid;
use App\Entities\User;
use App\Entities\Order;
use Illuminate\View\View;
use App\Services\PaymentData;
use App\Services\CartService;
use Illuminate\Routing\Redirector;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Payment\PaymentInfoRequest;


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
        if ($this->cartService->getAContentCartFormAUser()->count() == 0)
            return redirect()->route('client.product');
        else
            return view('webcheckout.index', compact('user'));
    }

    /**
     * @param PlacetoPay $placetopay
     * @param PaymentInfoRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|RedirectResponse|Redirector
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    public function store(PlacetoPay $placetopay, PaymentInfoRequest $request): RedirectResponse
    {
        //Create the order for the payment
        $order = Order::create($request->all());
        $order->reference = substr(Uuid::uuid4(), 0, 10);
        $order->user_id = $this->getUserId();
        $order->total = intval($this->cartService->getACartFromUser()->getTotal());

        foreach ($this->cartService->getAContentCartFormAUser() as $product)
            {
               $order->products()->attach($product['id']);
            }

         // Conection with PlaceToPay
        try {
            $payment = new PaymentData($order);

            //CreateRequest PlaceToPay
            $response = $placetopay->request($payment->setPayment());

            if ($response->isSuccessful()) {
                // Redirect the client to the processUrl or display it on the JS extension
                $response->processUrl();

                $order->requestId = $response->requestId;
                $order->processUrl = $response->processUrl;
                $order->status = $response->status()->status();
                $order->save();

                return redirect($response->processUrl());
            } else {
                // There was some error so check the message
                $response->status()->message();
            }
            var_dump($response);
        } catch (Exception $e) {
            var_dump($e->getMessage());

        //Update the Order information
        }
    }

    /**
     * @param PlacetoPay $placetopay
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function endTransaction (PlacetoPay $placetopay, Order $order)
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
     * @return \Illuminate\Contracts\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
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

    public function getUserId(){
        return $user = Auth::id();
    }


}
