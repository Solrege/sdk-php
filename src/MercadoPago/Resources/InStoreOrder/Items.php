<?php

namespace MercadoPago\Resources\InStoreOrder;

/** Items class */
class Items
{
    /** SKU number. */
    public ?string $sku_number;

    /** Category. */
    public ?string $category;

    /** Title. */
    public string $title;

    /** Description. */
    public ?string $description;

    /** Unit price. */
    public int $unit_price;

    /** Quantity. */
    public int $quantity;

    /** Unit measure. */
    public string $unit_measure;

    /** Total amount. */
    public int $total_amount;

}