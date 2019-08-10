<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Vrpayment\ContaoIsotopeBundle;


use Psr\Log\LoggerInterface;
use Vrpayment\ContaoIsotopeBundle\Brand\BrandInterface;
use Vrpayment\ContaoIsotopeBundle\Http\CurlClient;
use Vrpayment\ContaoIsotopeBundle\Http\Exception\ClientException;
use Vrpayment\ContaoIsotopeBundle\Http\Response;
use Vrpayment\ContaoIsotopeBundle\Http\ResponseInterface;

class Client
{
    const DEFAULT_VRPAYMENT_URL = 'https://vr-pay-ecommerce.de/v1/';

    const TEST_VRPAYMENT_URL = 'https://test.vr-pay-ecommerce.de/v1/';

    const PAYMENTS_ROUTE = 'payments';

    const REGISTRATIONS_ROUTE = 'registrations';

    const PREPARECHECKOUT_ROUTE = 'checkouts';

    /**
     * @var string
     */
    protected $token;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $defaultUrl;

    /**
     * Client constructor.
     * @param $token
     */
    public function __construct($token, $testMode = false)
    {
        $this->token = $token;
        $this->setDefaultUrl($testMode);
    }

    /**
     * @param $paymentType
     * @param $body
     * @return Response|ResponseInterface
     * @throws ClientException
     */
    public function send($paymentType, $body)
    {
        switch ($paymentType){

            case 'PA':
                return $this->sendPreAuthorization($body);

                break;

            case 'DB':
                return $this->sendDebitPrepareCheckout($body);

            default:
                return $this->sendDebitPrepareCheckout($body);
        }

    }

    /**
     * @param string $data
     * @return Http\Response|Http\ResponseInterface
     * @throws Http\Exception\ClientException
     */
    protected function sendPreAuthorization($body)
    {
        $curl = new CurlClient();
        $response = $curl
            ->authorize($this->getToken())
            ->post($this->getDefaultUrl().self::PAYMENTS_ROUTE, $body);

        return $response;
    }

    /**
     * @param string $data
     * @return Http\Response|Http\ResponseInterface
     * @throws Http\Exception\ClientException
     */
    protected function sendDebitPrepareCheckout($body)
    {
        $curl = new CurlClient();
        $response = $curl
            ->authorize($this->getToken())
            ->post($this->getDefaultUrl().self::PREPARECHECKOUT_ROUTE, $body);

        return $response;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Client
     */
    public function setToken(string $token): Client
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultUrl(): string
    {
        return $this->defaultUrl;
    }

    /**
     * @param bool $testmode
     *
     * @return Client
     */
    public function setDefaultUrl($testmode): Client
    {
        $this->defaultUrl = ($testmode) ? self::TEST_VRPAYMENT_URL : self::DEFAULT_VRPAYMENT_URL;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlPaymentWidgetJs(): string
    {
        return $this->urlPaymentWidgetJs;
    }
}
