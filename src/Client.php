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

class Client
{
    const DEFAULT_VRPAYMENT_URL = 'https://test.vr-pay-ecommerce.de/v1/';

    const PAYMENTS_ROUTE = 'payments';

    const REGISTRATIONS_ROUTE = 'registrations';

    /**
     * @var string
     */
    protected $token;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @param string $data
     * @return Http\Response|Http\ResponseInterface
     * @throws Http\Exception\ClientException
     */
    public function send($body)
    {
        $curl = new CurlClient();
        $response = $curl
            ->authorize($this->getToken())
            ->post(self::DEFAULT_VRPAYMENT_URL.self::PAYMENTS_ROUTE, $body);

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
}
