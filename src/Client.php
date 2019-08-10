<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle;

use Psr\Log\LoggerInterface;
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
     *
     * @param $token
     * @param mixed $testMode
     */
    public function __construct($token, $testMode = false)
    {
        $this->token = $token;
        $this->setDefaultUrl($testMode);
    }

    /**
     * @param $paymentType
     * @param $body
     *
     * @throws ClientException
     *
     * @return Response|ResponseInterface
     */
    public function send($paymentType, $body)
    {
        switch ($paymentType) {
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
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return Client
     */
    public function setToken(string $token): self
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
    public function setDefaultUrl($testmode): self
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

    /**
     * @param string $data
     * @param mixed  $body
     *
     * @throws Http\Exception\ClientException
     *
     * @return Http\Response|Http\ResponseInterface
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
     * @param mixed  $body
     *
     * @throws Http\Exception\ClientException
     *
     * @return Http\Response|Http\ResponseInterface
     */
    protected function sendDebitPrepareCheckout($body)
    {
        $curl = new CurlClient();
        $response = $curl
            ->authorize($this->getToken())
            ->post($this->getDefaultUrl().self::PREPARECHECKOUT_ROUTE, $body);

        return $response;
    }
}
