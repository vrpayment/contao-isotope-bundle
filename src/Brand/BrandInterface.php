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

use Isotope\Interfaces\IsotopeOrderableCollection;
use Vrpayment\ContaoIsotopeBundle\Entity\PaymentStatus;
use Vrpayment\ContaoIsotopeBundle\Entity\PreAuthorization;
use Vrpayment\ContaoIsotopeBundle\Entity\PreCheckout;
use Vrpayment\ContaoIsotopeBundle\Http\ResponseInterface;
use Vrpayment\ContaoIsotopeBundle\Order;

interface BrandInterface
{
    /**
     * @param Order $order
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

}
