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

class Enterpay extends AbstractBrand
{
    public function getPaymentData(Order $order)
    {
        $data = 'entityId='.$order->getPaymentEntityId().
            '&customParameters[merchantId]='.$order->getPaymentMerchantId().
            '&customParameters[buyerCompanyVat]='.$order->getOrderBillingAddress()->vat_no.
            '&amount='.$order->getOrderAmount().
            '&currency='.$order->getOrderCurrency().
            '&paymentBrand='.$order->getPaymentBrand().
            '&paymentType='.$order->getPaymentType().
            '&customer.givenName='.$order->getOrderBillingAddress()->firstname.
            '&customer.surname='.$order->getOrderBillingAddress()->lastname.
            '&customer.email='.$order->getOrderBillingAddress()->email.
            '&customer.companyName='.$order->getOrderBillingAddress()->company.
            '&billing.city='.$order->getOrderBillingAddress()->city.
            '&billing.postcode='.$order->getOrderBillingAddress()->postal.
            '&billing.street1='.$order->getOrderBillingAddress()->street_1.$order->getOrderCartItems(true).
            '&shipping.city='.$order->getOrderShippingAddress()->city.
            '&shipping.postcode='.$order->getOrderShippingAddress()->postal.
            '&shipping.street1='.$order->getOrderShippingAddress()->street_1.
            '&shopperResultUrl='.$order->getPaymentShopperResultUrl();

        return $data;
    }

    /**
     * @return bool
     */
    public function showPaymentForm()
    {
        return false;
    }

    public function getPaymentForm(PreCheckout $preCheckout)
    {
        return '';
    }

    public function proceedPreAuthorization()
    {
        return true;
    }
}
