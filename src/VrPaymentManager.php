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


use Doctrine\DBAL\Connection;
use Isotope\Interfaces\IsotopeOrderableCollection;
use Psr\Log\LoggerInterface;
use Vrpayment\ContaoIsotopeBundle\Brand\BrandFactory;
use Vrpayment\ContaoIsotopeBundle\Brand\BrandInterface;
use Vrpayment\ContaoIsotopeBundle\Entity\PaymentStatus;
use Vrpayment\ContaoIsotopeBundle\Entity\PreAuthorization;
use Vrpayment\ContaoIsotopeBundle\Entity\PreCheckout;
use Vrpayment\ContaoIsotopeBundle\Http\Response;

class VrPaymentManager
{
    const DEFAULT_VRPAYMENT_URL = 'https://vr-pay-ecommerce.de';

    const TEST_VRPAYMENT_URL = 'https://test.vr-pay-ecommerce.de';

    const PAYMENTS_ROUTE = '/v1/payments';

    const REGISTRATIONS_ROUTE = '/v1/registrations';

    const PREPARECHECKOUT_ROUTE = '/v1/checkouts';

    const WIDGET_JS_ROUTE = '/v1/paymentWidgets.js';

    /** @var Connection */
    protected $connection;

    /** @var LoggerInterface */
    protected $logger;

    /** @var Order */
    protected $order;

    /** @var BrandInterface */
    protected $brand;

    /** @var Client */
    protected $client;

    /**
     * VrPaymentManager constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    public function setOrder(IsotopeOrderableCollection $order): VrPaymentManager
    {
        $this->order = new Order($order);
        return $this;
    }

    /**
     * @return BrandInterface
     */
    public function getBrand(): BrandInterface
    {
        return $this->brand;
    }

    public function setBrand(): VrPaymentManager
    {
        $this->brand = BrandFactory::getBrandByPaymentType($this->getOrder()->getPaymentBrand());
        return $this;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(): VrPaymentManager
    {
        if(null === $this->getOrder())
        {
            return null;
        }

        $this->client = new Client(
            $this->getOrder()->getPaymentAuthorizationToken(),
            [
                'defaultUrl' => ($this->getOrder()->getTestmode()) ? self::TEST_VRPAYMENT_URL : self::DEFAULT_VRPAYMENT_URL,
                'routePayments' => self::PAYMENTS_ROUTE,
                'routeRegistrations' => self::REGISTRATIONS_ROUTE,
                'routePreCheckout' => self::PREPARECHECKOUT_ROUTE
            ]);

        return $this;
    }

    /**
     * @return bool|PreCheckout
     * @throws Http\Exception\ClientException
     * @throws Http\Exception\ResponseException
     */
    public function getPrecheckout()
    {
        if(!$this->getBrand()->showPaymentForm())
        {
            return false;
        }

        /** @var Response $response */
        $response = $this->getClient()->send($this->getOrder()->getPaymentType(), $this->getBrand()->getPaymentData($this->getOrder()));

        if(StaticResponseResultValidator::isSuccessfullyPendingTransaction($response->json()))
        {
            // TODO Log

            /** @var PreCheckout $e */
            $preCheckout = new PreCheckout();
            $preCheckout->setUriWidget($this->getClient()->getDefaultUrl().'/v1/paymentWidgets.js?checkoutId='.json_decode($response->getBody(), true)['id']);
            $preCheckout->setShopperResultUrl(\Environment::get('uri'));
            $preCheckout->setBrand($this->getOrder()->getPaymentBrand());

            return $preCheckout;

        } else {

            // TODO Log

            /** @var PreCheckout $e */
            $preCheckout = new PreCheckout();
            $preCheckout->setHasError(true);
            $preCheckout->setErrorDescription('No Checkout prepared');

            return $preCheckout;
        }
    }

    /**
     * @return bool|PreAuthorization
     * @throws Http\Exception\ClientException
     * @throws Http\Exception\ResponseException
     */
    public function getPreAuthorization()
    {
        if($this->getBrand()->showPaymentForm())
        {
            return false;
        }

        return PreAuthorization::buildFromResultArray($this->getClient()->send($this->getOrder()->getPaymentType(), $this->getBrand()->getPaymentData($this->getOrder()))->json());
    }

    /**
     * @return bool|PaymentStatus
     * @throws Http\Exception\ResponseException
     */
    public function getPaymentStatus($ressourcePath)
    {
        return PaymentStatus::buildFromResultArray($this->getClient()->getPaymentStatus($ressourcePath, $this->getOrder()->getPaymentEntityId())->json());
    }
}
