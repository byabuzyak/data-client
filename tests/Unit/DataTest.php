<?php

namespace Tests\Unit;

use App\Services\JsonRpc\JsonRpcService;
use Illuminate\Support\Str;
use Tests\TestCase;
use GuzzleHttp\Psr7\Response;

class DataTest extends TestCase
{
    public function testCreate()
    {
        $this
            ->get('/create')
            ->assertSuccessful()
            ->assertStatus(200)
            ->assertSee('table')
            ->assertViewIs('create');
    }

    public function testStore()
    {
        $mock     = $this->mock(JsonRpcService::class);
        $response = new Response(
            $status = 200,
            $headers = [],
            $body = json_encode([
                'jsonrpc' => '2.0',
                'result'  => [
                    'id'       => $id = 1,
                    'page_uid' => $pageUid = Str::uuid()->toString(),
                    'name'     => $name = 'Test name',
                    'amount'   => $amount = '300',
                    'currency' => $currency = 'USD',
                    'created'  => date('Y-m-d H:i:s')
                ]
            ])
        );

        $mock
            ->shouldReceive('send')
            ->andReturn(json_decode($response->getBody()->getContents(), true));

        $response =
            $this
                ->post('/store', [
                    'name'     => $name,
                    'page_uid' => $pageUid,
                    'amount'   => $amount,
                    'currency' => $currency
                ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('show', ['uid' => $pageUid]));

        $this
            ->followRedirects($response)
            ->assertSee('table')
            ->assertViewIs('show');
    }
}
