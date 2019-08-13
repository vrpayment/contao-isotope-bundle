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

use Contao\FrontendTemplate;
use Vrpayment\ContaoIsotopeBundle\Entity\PreCheckout;
use Vrpayment\ContaoIsotopeBundle\Order;

class DirectDebitSepa extends AbstractBrand implements BrandInterface
{
    public function getPaymentData(Order $order)
    {
        $data = 'entityId='.$order->getPaymentEntityId().
            '&amount='.$order->getOrderAmount().
            '&currency='.$order->getOrderCurrency().
            '&paymentType='.$order->getPaymentType();

        return $data;
    }

    /**
     * @return bool
     */
    public function showPaymentForm()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function hasPaymentForm()
    {
        return true;
    }

    /**
     * @param PreCheckout $preCheckout
     *
     * @return string
     */
    public function getPaymentForm(PreCheckout $preCheckout)
    {
        $template = new FrontendTemplate('vrpayment_debit_checkoutform');
        $template->shopperResultUrl = $preCheckout->getShopperResultUrl();
        $template->brand = $preCheckout->getBrand();
        $template->uriWidgetJs = $preCheckout->getUriWidget();

        return $template->parse();
    }

    public function proceedPreAuthorization()
    {
        return false;
    }
}
