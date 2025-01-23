<?php

namespace MercadoPago\Resources;

use MercadoPago\Net\MPResource;
use MercadoPago\Serialization\Mapper;

/** Order class*/
class InStoreOrder extends MPResource
{
    /** Class mapper */
    use Mapper;

    /** External reference. */
    public string $external_reference;

    /** Title. */
    public string $title;

    /** Description. */
    public string $description;

    /** Notification URL. */
    public ?string $notification_url;

    /** Total amount. */
    public int $total_amount;

    /** Items. */
    public array $items;

    /** Sponsor. */
    public ?string $sponsor;

    /** Cash out. */
    public ?string $cash_out;

    private $map = [
        "items" => "MercadoPago\Resource\InStoreOrder\Items",
    ];

    /**
     * Method responsible for getting map of entities.
     */
    public function getMap(): array
    {
        return $this->map;
    }

}