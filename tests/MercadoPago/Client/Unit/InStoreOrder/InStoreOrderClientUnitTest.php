<?php

namespace MercadoPago\Client\Unit\InStoreOrder;

use MercadoPago\Client\InStoreOrder\InStoreOrderClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Net\MPDefaultHttpClient;
use MercadoPago\Tests\Client\Unit\Base\BaseClient;

class InStoreOrderClientUnitTest extends BaseClient
{
    public function testCreate_Success(): void
    {
        $mock_http_request = $this->mockHttpRequest(null, 204);

        $http_client = new MPDefaultHttpClient($mock_http_request);
        MercadoPagoConfig::setHttpClient($http_client);

        $client = new InStoreOrderClient($http_client);
        $response = $client->create("userId", "storeId", "posId",$this->createRequest());
        $this->assertSame(204, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    private function createRequest(): array
    {
        return [
            "external_reference" => 'TESTID',
            "title" => "Product order",
            "description" => "Purchase description",
            "notification_url" => "http://www.yourserver.com/notification",
            "total_amount" => 1000,
            "items" => [
                [
                    "sku_number" => "A123K9191938",
                    "category" => "marketplace",
                    "title" => "Test",
                    "description" => "Test description",
                    "unit_price" => 1000,
                    "quantity" => 1,
                    "unit_measure" => "unit",
                    "total_amount" => 1000,
                ],
            ],
        ];
    }
}