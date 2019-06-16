<?php

namespace Wending\Selly;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

/**
 * Selly 钱包接口
 */
class Wallet
{

    /**
     * API地址
     * @var string
     */
    public $url = 'https://selly.fakajun.com/';

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

        return Cache::remember('selly.token', 5, function () use ($_this) {
            $email    = config('services.selly.email');
            $password = config('services.selly.password');
            $res      = $_this->client->post($_this->url . 'oauth/token', [
                'query' => compact('email', 'password'),
            ])->getBody()->getContents();

            return json_decode($res);
        });
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
        $res = $this->client->post($this->url . 'oauth/token', [
            'query'   => compact('token'),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token()->access_token,
            ],
        ])->getBody()->getContents();

        return json_decode($res);
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
    public function balance($address, $token = 'omni_usdt')
    {
        $res = $this->client->post($this->url . 'api/wallet/balance', [
            'query'   => compact('address', 'token'),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token()->access_token,
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
     * @param     [type] $fee_address [description]
     * @param     string $token       [description]
     * @return    [type]              [description]
     */
    public function withdraw($to_address, $amount, $fee_address, $token = 'omni_usdt')
    {
        $res = $this->client->post($this->url . 'api/wallet/withdraw', [
            'query'   => compact('to_address', 'amount', 'fee_address', 'token'),
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token()->access_token,
            ],
        ])->getBody()->getContents();

        return json_decode($res);
    }

}
