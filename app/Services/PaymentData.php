<?php


namespace App\Services;


use App\Entities\Order;

class PaymentData
{

    /**
     * @var array
     * @var string
     */
    private $paymentInfo;

        public function __construct(Order $paymentInfo)
    {
        $this->paymentInfo = $paymentInfo;
    }

        public function setPayment()
        {

            $payment = [
                "buyer" => [
                    'name'          => $this->paymentInfo->first_name,
                    'surname'       => $this->paymentInfo->last_name,
                    'email'         => $this->paymentInfo->email,
                    'documentType'  => $this->paymentInfo->document_type,
                    'document'      => $this->paymentInfo->document_number,
                    'mobile'        => $this->paymentInfo->mobile,
                    'address'       => [
                        'street'    => $this->paymentInfo->address,
                    ]
                ],
                'payment' => [
                    'reference'     => $this->paymentInfo->reference,
                    'description'   => 'Payment of reference'.''.$this->paymentInfo->reference,
                    'amount'        => [
                        'currency' => 'USD',
                        'total' => $this->paymentInfo->total,
                    ],
                ],
                'expiration' => date('c', strtotime('+2 days')),
                'returnUrl' => route('payment.endTransaction', $this->paymentInfo->reference),
                'ipAddress' => \Request::ip(),
                'userAgent' => \Request::header('User-Agent')
            ];

            return $payment;
        }

        public function setRequestIdPayment()
        {

        }
}
