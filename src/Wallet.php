<?php

namespace Wending\Selly;

use GuzzleHttp\Client;

/**
 * Selly 钱包接口
 */
class Wallet
{

    /**
     * API地址
     * @var string
     */
    // public $url = 'https://selly.fakajun.com/';
    public $url = 'http://127.0.0.1:5000/';

    /**
     * 网络请求
     * @var [type]
     */
    public $client;

    /**
     * 初始化
     *
     * @copyright 问鼎公司 版权所有
     * @author Wending <postmaster@g000.cn>
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * 获得 token
     *
     * @copyright 问鼎公司   版权所有
     * @author Wending <postmaster@g000.cn>
     * @return    [type]           [description]
     */
    public function token()
    {
        $_this = $this;

        // return Cache::remember('selly.token', 5, function () use ($_this) {
        // $email    = config('services.selly.email');
        // $password = config('services.selly.password');
        $email    = 'im@selly.cc';
        $password = '123456';
        $res      = $_this->client->post($_this->url . 'oauth/token', [
            'json' => compact('email', 'password'),
        ])->getBody()->getContents();

        return json_decode($res)->data->access_token;
        // });
    }

    /**
     * 创建钱包
     *
     * @copyright 问鼎公司   版权所有
     * @author Wending <postmaster@g000.cn>
     * @param     [type] $token [description]
     * @return    [type]             [description]
     */
    public function create($token)
    {
        $res = $this->client->post($this->url . 'api/wallet/create', [
            'json'    => compact('token'),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token(),
            ],
        ])->getBody()->getContents();

        return json_decode($res)->data->address;
    }

    /**
     * 获得余额
     *
     * @copyright 问鼎公司   版权所有
     * @author Wending <postmaster@g000.cn>
     * @param     [type] $address [description]
     * @param     string $token   [description]
     * @return    [type]          [description]
     */
    public function balance($address, $token = 'erc20_usdt')
    {
        $res = $this->client->post($this->url . 'api/wallet/balance', [
            'json'    => compact('address', 'token'),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token(),
            ],
        ])->getBody()->getContents();

        return json_decode($res);
    }

    /**
     * 钱包提现
     *
     * @copyright 问鼎公司   版权所有
     * @author Wending <postmaster@g000.cn>
     * @param     [type] $to_address  [description]
     * @param     [type] $amount      [description]
     * @param     [type] $from_address [description]
     * @param     string $token       [description]
     * @return    [type]              [description]
     */
    public function withdraw($to_address, $amount, $from_address, $token = 'omni_usdt')
    {
        $res = $this->client->post($this->url . 'api/wallet/withdraw', [
            'json'    => compact('to_address', 'amount', 'from_address', 'token'),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token(),
            ],
        ])->getBody()->getContents();

        return json_decode($res)->data;
    }

}
