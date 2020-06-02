<?php

namespace App\Services\JsonRpc;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Str;

/**
 * Class JsonRpcClient
 * @package App\Services\JsonRpc
 */
class JsonRpcService
{
    const JSON_RPC_VERSION = '2.0';

    /**
     * @param string $method
     * @param array $params
     * @return array
     */
    public function send(string $method, array $params = []): array
    {
        $request =
            app(Client::class)
                ->post(config('data.base_uri'), [
                    RequestOptions::JSON => [
                        'jsonrpc' => self::JSON_RPC_VERSION,
                        'id'      => Str::uuid()->toString(),
                        'method'  => $method,
                        'params'  => $params
                    ]
                ]);

        return
            json_decode($request->getBody()->getContents(), true);
    }
}
