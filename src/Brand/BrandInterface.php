<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle\Brand;

use Vrpayment\ContaoIsotopeBundle\Entity\PreCheckout;
use Vrpayment\ContaoIsotopeBundle\Order;

interface BrandInterface
{
    /**
     * @param Order $order
     *
     * @return string
     */
    public function getPaymentData(Order $order);

    /**
     * @return bool
     */
    public function showPaymentForm();

    /** string */
    public function getPaymentForm(PreCheckout $preCheckout);

    /**
     * @return bool
     */
    public function proceedPreAuthorization();

    /**
     * @return bool
     */
    public function forceSendPrepareCheckout();

}
