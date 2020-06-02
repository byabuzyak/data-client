<?php

namespace App\Services;

use App\Services\JsonRpc\JsonRpcService;

/**
 * Class DataService
 * @package App\Services
 */
class DataService
{
    /**
     * @var JsonRpcService
     */
    protected $client;

    /**
     * DataService constructor.
     * @param JsonRpcService $client
     */
    public function __construct(JsonRpcService $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $uid
     * @return array
     */
    public function getById(string $uid): array
    {
        return
            $this
                ->client
                ->send('getById', [
                    'page_uid' => $uid
                ]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data): array
    {
        return
            $this
                ->client
                ->send('store', $data);
    }
}
