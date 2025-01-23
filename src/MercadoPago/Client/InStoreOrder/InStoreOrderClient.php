<?php

namespace MercadoPago\Client\InStoreOrder;

use Exception;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\MercadoPagoClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Net\HttpMethod;
use MercadoPago\Net\MPHttpClient;
use MercadoPago\Net\MPResponse;
use MercadoPago\Resources\InStoreOrder;
use MercadoPago\Serialization\Serializer;

final class InStoreOrderClient extends MercadoPagoClient
{
    private const URL_CREATE = "/instore/qr/seller/collectors/%d/stores/%s/pos/%s/orders";

    private const URL = "/instore/qr/seller/collectors/%s/pos/%s/orders";

    /** Default constructor. Uses the default http client used by the SDK or custom http client provided. */
    public function __construct(?MPHttpClient $MPHttpClient = null)
    {
        parent::__construct($MPHttpClient ?: MercadoPagoConfig::getHttpClient());
    }

    /**
     * Method responsible for creating an InStoreOrder
     * @param string $user_id The User that's creating the order
     * @param string $external_store_id The External Store ID
     * @param string $external_pos_id The External Point of Sale ID
     * @param array $request The parameters for the InStoreOrder to be created
     * @param RequestOptions|null $request_options Additional request options
     * @return MPResponse the response returned by the HTTPClient
     * @throws Exception if the request fails
     */
    public function create(string $user_id, string $external_store_id, string $external_pos_id, array $request, ?RequestOptions $request_options = null): MPResponse
    {
        $formattedURL = sprintf(self::URL_CREATE, $user_id, $external_store_id, $external_pos_id);
        $response = parent::send($formattedURL,
            HttpMethod::PUT,
            json_encode($request),
            null,
            $request_options
        );

        if ($response->getStatusCode() !== 204) {
            throw new Exception("error al cargar QR");
        }

        return $response;
    }

    /**
     * Method responsible for cancelling an In Store Order
     * @param string $user_id The User that created the order
     * @param string $external_pos_id The External Store ID on which the order was created
     * @param RequestOptions|null $request_options additional request options
     * @return MPResponse the response returned by the HTTPClient
     * @throws Exception if the request fails
     */
    public function cancel(string $user_id, string $external_pos_id, ?RequestOptions $request_options = null): MPResponse
    {
        $formattedURL = sprintf(self::URL, $user_id, $external_pos_id);
        $response = parent::send($formattedURL, HttpMethod::DELETE, $request_options);

        if ($response->getStatusCode() !== 204) {
            throw new Exception("error al cancelar orden");
        }

        return $response;
    }

    /**
     * Method responsible for getting a InStoreOrder payment.
     * @param string $user_id The User that created the order
     * @param string $external_pos_id The External Store ID on which the order was created
     * @param RequestOptions|null $request_options additional request options
     * @return InStoreOrder the order itself
     * @throws Exception if the request fails
     */
    public function get(string $user_id, string $external_pos_id, ?RequestOptions $request_options = null): InStoreOrder
    {
        $formattedURL = sprintf(self::URL, $user_id, $external_pos_id);
        $response = parent::send($formattedURL,
            HttpMethod::GET,
            null,
            $request_options);

        $result = Serializer::deserializeFromJson(InStoreOrder::class, $response->getContent());
        $result->setResponse($response);

        return $result;
    }


}