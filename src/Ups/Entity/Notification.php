<?php
namespace Ups\Entity;

use DOMDocument;
use DOMElement;
use Ups\NodeInterface;

class Notification implements NodeInterface
{

    /**
     * @var string
     */
    public $notificationCode;

    /**
     * @var string
     */
    public $notificationEmail;

    /**
     * @var string
     */
    public $notificationUndelirableEmail;


    public function __construct()
    {

    }

    /**
     * @param null|DOMDocument $document
     * @return DOMElement
     */
    public function toNode(DOMDocument $document = null)
    {
        if (null === $document) {
            $document = new DOMDocument();
        }

        $node = $document->createElement('EMailMessage');
        $node->appendChild($document->createElement('EMailAdress', $this->getNotificationEmail()));
        $node->appendChild($document->createElement('UndeliverableEMailAddress', $this->getUndelivEmail()));
        $node->appendChild($this->getUnitOfMeasurement()->toNode($document));
        return $node;
    }


    /**
     * @param UnitOfMeasurement $unitOfMeasurement
     * @return $this
     */
    public function setNotificationCode($code)
    {
        $this->notificationCode = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getNotificationCode()
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getNotificationEmail()
    {
        return $this->notificationEmail;
    }



    /**
     * @return string
     */
    public function getUndelivEmail()
    {
        return $this->notificationUndelirableEmail;
    }


    /**
     * @param string $emailAddress , $UndeliverableEMailAddress
     * @return $this
     */
    public function setEmailAddresses($emailAddress, $UndeliverableEMailAddress)
    {


        $this->notificationEmail = $emailAddress;
        $this->notificationUndelirableEmail = $UndeliverableEMailAddress;
        return $this;
    }
}