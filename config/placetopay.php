<?php
if (function_exists('random_bytes')) {
    $nonce = bin2hex(random_bytes(16));
} elseif (function_exists('openssl_random_pseudo_bytes')) {
    $nonce = bin2hex(openssl_random_pseudo_bytes(16));
} else {
    $nonce = mt_rand();
}

$nonceBase64 = base64_encode($nonce);

$seed = date('c');

return [
    'auth' => [
        'login' => env('PTP_APP_LOGIN'),
        'tranKey' => env('PTP_APP_TRAN_KEY'),
        'url' => env('PTP_URL'),
        'nonce' => $nonce,
        'additional' => []
    ],
];
