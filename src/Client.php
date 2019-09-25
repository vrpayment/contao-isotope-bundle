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

    /** @var string */
    protected $routePayments;

    /** @var string */
    protected $routeRegistrations;

    /** @var string */
    protected $routePreCheckout;

    /**
     * Client constructor.
     *
     * @param $token
     * @param mixed $testMode
     * @param mixed $routingOptions
     */
    public function __construct($token, $routingOptions)
    {
        $this->token = $token;
        $this->setRouting($routingOptions);
    }

    public function setRouting(array $options)
    {
        $this->setDefaultUrl($options['defaultUrl']);
        $this->setRoutePayments($options['routePayments']);
        $this->setRouteRegistrations($options['routeRegistrations']);
        $this->setRoutePreCheckout($options['routePreCheckout']);
    }

    /**
     * @return string
     */
    public function getRoutePayments(): string
    {
        return $this->routePayments;
    }

    /**
     * @param string $routePayments
     *
     * @return Client
     */
    public function setRoutePayments(string $routePayments): self
    {
        $this->routePayments = $routePayments;

        return $this;
    }

    /**
     * @return string
     */
    public function getRouteRegistrations(): string
    {
        return $this->routeRegistrations;
    }

    /**
     * @param string $routeRegistrations
     *
     * @return Client
     */
    public function setRouteRegistrations(string $routeRegistrations): self
    {
        $this->routeRegistrations = $routeRegistrations;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoutePreCheckout(): string
    {
        return $this->routePreCheckout;
    }

    /**
     * @param string $routePreCheckout
     *
     * @return Client
     */
    public function setRoutePreCheckout(string $routePreCheckout): self
    {
        $this->routePreCheckout = $routePreCheckout;

        return $this;
    }

    /**
     * @param $paymentType
     * @param $body
     *
     * @throws ClientException
     *
     * @return Response|ResponseInterface
     */
    public function send($paymentType, $body, $forceSendPrepareCheckout = false)
    {
        if($forceSendPrepareCheckout)
        {
            return $this->sendDebitPrepareCheckout($body);
        }
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
     * @param $ressourcePath
     * @param $entityId
     *
     * @return Response|ResponseInterface
     */
    public function getPaymentStatus($ressourcePath, $entityId)
    {
        $curl = new CurlClient();
        $response = $curl
            ->authorize($this->getToken())
            ->get($this->getDefaultUrl().$ressourcePath.'?entityId='.$entityId);

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
     * @param string $defaultUrl
     *
     * @return Client
     */
    public function setDefaultUrl(string $defaultUrl): self
    {
        $this->defaultUrl = $defaultUrl;

        return $this;
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
            ->post($this->getDefaultUrl().$this->getRoutePayments(), $body);

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
            ->post($this->getDefaultUrl().$this->getRoutePreCheckout(), $body);

        return $response;
    }
}
