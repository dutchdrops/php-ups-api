<?php

namespace Ups\Entity;


use DOMDocument;
use DOMNode;
use Ups\NodeInterface;

class ItemPaymentInformation  implements NodeInterface {

    public $ShipmentCharge;
    public $type;
    public $billShipper;
    public $accountNumber;
    function __construct($attributes = null)
    {



    }

    /**
     * @param null|DOMDocument $document
     *
     * @return DOMNode
     */
    public function toNode(DOMDocument $document = null)
    {
        // TODO: Implement toNode() method.
}}