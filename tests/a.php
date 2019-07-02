<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Wending\Selly\Wallet;
use GuzzleHttp\Exception\ClientException;

$wallet = new Wallet();
// $token  = $wallet->token('im@selly.cc', '123456');
// var_dump($token->data->access_token);

// $res = $wallet->create('erc20_usdt');
// var_dump($res);

// $res = $wallet->balance('0x5bf70C262751020496c8634E5aD14994af385ac3');
// var_dump($res);

try {
    $res = $wallet->withdraw('0x5bf70C262751020496c8634E5aD14994af385ac3', '0.001', '0x5bf70C262751020496c8634E5aD14994af385ac3', 'erc20_usdt');
    var_dump($res);
} catch (ClientException $e) {
    var_dump($e->getMessage());
}
