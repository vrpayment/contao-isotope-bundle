<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Vrpayment\ContaoIsotopeBundle\Payment;

use Isotope\Interfaces\IsotopeOrderableCollection;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Model\ProductCollection\Order;
use Vrpayment\ContaoIsotopeBundle\Entity\PaymentData;

class PaymentDataEnterpay implements PaymentDataInterface
{
    /** @var PaymentData */
    protected $paymentData;
    /**
     * @var Order
     */
    private $order;

    public function __construct(IsotopeOrderableCollection $order)
    {
        $this->order = $order;
    }

    /**
     * @return PaymentData
     */
    public function getPaymentData(): PaymentData
    {
        return $this->paymentData;
    }

    /**
     * @return PaymentData
     */
    public function setPaymentData(): PaymentDataEnterpay
    {
        /** @var PaymentData $paymentData */
        $paymentData = new PaymentData();
        $paymentData->setCustomParametersMerchantId()

        $this->paymentData = $paymentData;

        return $this;
    }




}
