<?php
namespace Ups;

use DOMDocument;
use SimpleXMLElement;
use Exception;
use stdClass;

abstract class Ups
{
    const PRODUCTION_BASE_URL = 'https://onlinetools.ups.com/ups.app/xml';
    const INTEGRATION_BASE_URL = 'https://wwwcie.ups.com/ups.app/xml';

    /**
     * @var string
     */
    protected $accessKey;

    /**
     * @var string
     */
    protected $userId;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     * @deprecated
     */
    protected $productionBaseUrl = 'https://www.ups.com/ups.app/xml';

    /**
     * @var string
     * @deprecated
     */
    protected $integrationBaseUrl = 'https://www.ups.com//ups.app/xml';

    /**
     * @var bool
     */
    protected $useIntegration = false;

    /**
     * @var string
     */
    protected $context;

    /**
     * @deprecated
     */
    public $response;

    /**
     * Constructor
     *
     * @param string|null $accessKey UPS License Access Key
     * @param string|null $userId UPS User ID
     * @param string|null $password UPS User Password
     * @param bool $useIntegration Determine if we should use production or CIE URLs.
     */
    public function __construct($accessKey = null, $userId = null, $password = null, $useIntegration = false)
    {
        $this->accessKey = $accessKey;
        $this->userId = $userId;
        $this->password = $password;
        $this->useIntegration = $useIntegration;
    }

    /**
     * Sets the transaction / context value
     *
     * @param string $context The transaction "guidlikesubstance" value
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * Format a Unix timestamp or a date time with a Y-m-d H:i:s format into a YYYYMMDDHHmmss format required by UPS.
     *
     * @param string
     * @return string
     */
    public function formatDateTime($timestamp)
    {
        if (!is_numeric($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        return date('YmdHis', $timestamp);
    }

    /**
     * Create the access request
     *
     * @return string
     */
    protected function createAccess()
    {
        $xml = new DOMDocument();
        $xml->formatOutput = true;

        // Create the AccessRequest element
        $accessRequest = $xml->appendChild($xml->createElement("AccessRequest"));
        $accessRequest->setAttribute('xml:lang', 'en-US');

        $accessRequest->appendChild($xml->createElement("AccessLicenseNumber", $this->accessKey));
        $accessRequest->appendChild($xml->createElement("UserId", $this->userId));
        $accessRequest->appendChild($xml->createElement("Password", $this->password));



        return $xml->saveXML();
    }

    /**
     * Creates the TransactionReference node for a request
     *
     * @return DomDocument
     */
    protected function createTransactionNode()
    {
        $xml = new DOMDocument;
        $xml->formatOutput = true;

        $trxRef = $xml->appendChild($xml->createElement('TransactionReference'));

        if (null !== $this->context) {
            $trxRef->appendChild($xml->createElement('CustomerContext', $this->context));
        }

        return $trxRef->cloneNode(true);
    }

    /**
     * Send request to UPS
     *
     * @param string $access The access request xml
     * @param string $request The request xml
     * @param string $endpointurl The UPS API Endpoint URL
     * @return SimpleXMLElement
     * @throws Exception
     * @deprecated Untestable
     */
    protected function request($access, $request, $endpointurl)
    {
        $requestInstance = new Request;
        $response = $requestInstance->request($access, $request, $endpointurl);
        if ($response->getResponse() instanceof SimpleXMLElement) {
            $this->response = $response->getResponse();
            return $response->getResponse();
        }

        throw new Exception("Failure: Response is invalid.");
    }

    /**
     * Convert XMLSimpleObject to stdClass object
     *
     * @param SimpleXMLElement $xmlObject
     * @return stdClass
     */
    protected function convertXmlObject(SimpleXMLElement $xmlObject)
    {
        return json_decode(json_encode($xmlObject));
    }

    /**
     * Compiles the final endpoint URL for the request.
     *
     * @param string $segment The URL segment to build in to the endpoint
     * @return string
     */
    protected function compileEndpointUrl($segment)
    {
        $base = ($this->useIntegration ? $this->integrationBaseUrl : $this->productionBaseUrl);

        return $base . $segment;
    }
}