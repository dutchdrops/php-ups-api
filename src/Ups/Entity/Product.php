<?php
namespace Ups\Entity;

use Backend\Entities\Shop\Order\OrderProduct;

class Product
{
    public $formType;
    public $description;
    public $Qty;
    public $UOMCode;
    public $UOMDescription;
    public $price;
    public $commodityCode;
    public $PartNumber;
    public $originCountry;


    function __construct($response = null)
    {

    }

    function setProduct(OrderProduct $product){
        $this->formType = 1;
        $this->description = 'XX';
        $this->Qty = $product->quantity;
    }

} 