<?php
namespace Ups\Entity;

class ShipmentServiceOptions
{
    public $SaturdayPickup;
    public $SaturdayDelivery;
    public $CallTagARS;
    public $NegotiatedRatesIndicator;

    public  $notification;
    public  $invoiceNumber;
    public  $invoiceDate;

    public $currencyCode;
    public  $products;
    function __construct($response = null)
    {
        $this->CallTagARS = new CallTagARS();

        if (null != $response) {
            if (isset($response->SaturdayPickup)) {
                $this->SaturdayPickup = $response->SaturdayPickup;
            }
            if (isset($response->SaturdayDelivery)) {
                $this->SaturdayDelivery = $response->SaturdayDelivery;
            }
            if (isset($response->CallTagARS)) {
                $this->CallTagARS = new CallTagARS($response->CallTagARS);
            }
            if (isset($response->NegotiatedRatesIndicator)) {
                $this->NegotiatedRatesIndicator = $response->NegotiatedRatesIndicator;
            }
        }
    }

    /**
     * @param Notification $notification
     *
     * @return $this
     * @internal param Notification $notification
     */
            public function SetNotification(Notification $notification)
            {
                $this->notification = $notification;
                return $this;
            }


    /**
     * @param Product $product
     *
     * @return $this
     * @internal param Notification $notification
     */
      public function setProducts(array $product)
    {
        $this->products = $product;
        return $this;
    }


    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }


    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }




    public function setInvoiceDate($invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;
        return $this;
    }



}
