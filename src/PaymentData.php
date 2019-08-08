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


use Isotope\Model\ProductCollection\Order;

class PaymentData
{
    /** @var Order */
    protected $order;

    protected $payment;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

}
