<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\PaymentInfoRequest;
use App\Order;
use App\User;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;
use Illuminate\View\View;
use League\Flysystem\Config;
use PhpParser\Node\Stmt\DeclareDeclare;
use Ramsey\Uuid\Uuid;

class PaymentController extends Controller
{

    /**
     * @param User $user
     * @return View
     */
    public function index(User $user): View
    {
        return view('webcheckout.index', compact('user'));
    }

    /**
     * @param PlacetoPay $placetopay
     * @param Request $paymentInfo
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Dnetix\Redirection\Exceptions\PlacetoPayException
     */
    public function store(PlacetoPay $placetopay, Request $paymentInfo)
    {
        dd($paymentInfo);

        Order::create($paymentInfo->validated->all());
        //User
        $user = auth()->id();
        //Cart total

        // Creating a random reference for the test
        $reference = substr(Uuid::uuid4(), 0, 10);
        //Create a order assigned to a user
        //$order = Order::created();
        // Request Information
        $request = [
            "buyer" => [
                'name'          => $paymentInfo->input('name'),
                'surname'       => $paymentInfo->input('surname'),
                'email'         => $paymentInfo->input('email'),
                'documentType'  => $paymentInfo->input('documentType'),
                'document'      => $paymentInfo->input('document'),
                'mobile'        => $paymentInfo->input('mobile'),
                'address'       => [
                    'street'    => $paymentInfo->input('street'),
                ]
            ],
            'payment' => [
                'reference'     => $reference,
                'description'   => 'Payment of',
                'amount'        => [
                                'currency' => 'USD',
                                'total' => 120,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://example.com/response?reference=' . $reference,
            'ipAddress' => '127.0.0.1',
            'requestId' => '00001',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];


        try {

            $response = $placetopay->request($request);

            if ($response->isSuccessful()) {
                // Redirect the client to the processUrl or display it on the JS extension
                return redirect()->away($response->processUrl());
            } else {
                // There was some error so check the message
                // $response->status()->message();
            }
            var_dump($response);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * @param PlacetoPay $placetopay
     */
    public function show(PlacetoPay $placetopay){


        $response = $placetopay->query(412548);

        dd($response->status[status]);

    }

    public function redone(PlacetoPay $placetopay){


        $response = $placetopay->request(412452);


    }

    public function storePrueba(PlacetoPay $placetopay)
    {
        // Creating a random reference for the test
        $reference = '00002';

        // Request Information
        $request = [
            'payment' => [
                'reference' => $reference,
                'description' => 'Testing payment',
                'amount' => [
                    'currency' => 'USD',
                    'total' => 120,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => route('welcome'),
            'ipAddress' => '127.0.0.1',
            'requestId' => '00001',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];


        try {

            $response = $placetopay->request($request);

            if ($response->isSuccessful()) {
                // Redirect the client to the processUrl or display it on the JS extension
                return redirect()->away($response->processUrl());
            } else {
                // There was some error so check the message
                // $response->status()->message();
            }
            var_dump($response);
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

}
