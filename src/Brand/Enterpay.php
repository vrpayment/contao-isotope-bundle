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
use Vrpayment\ContaoIsotopeBundle\Http\ResponseInterface;
use Vrpayment\ContaoIsotopeBundle\StaticHelper;

class Enterpay extends AbstractBrand
{
    public function getPaymentData()
    {
        $data = 'entityId='.$this->getEntityId().
            '&customParameters[merchantId]='.StaticHelper::getUniqueIdentifier().
            '&amount='.$this->getAmount().
            '&currency='.$this->getCurrency().
            '&paymentBrand='.$this->getPaymentBrand().
            '&paymentType='.$this->getPaymentType().
            '&billing.city='.$this->getBillingAddress()->city.
            '&billing.postcode='.$this->getBillingAddress()->postal.
            '&billing.street1='.$this->getBillingAddress()->street_1.$this->getCartItems().
            '&shipping.city='.$this->getShippingAddress()->city.
            '&shipping.postcode='.$this->getShippingAddress()->postal.
            '&shipping.street1='.$this->getShippingAddress()->street_1.
            '&shopperResultUrl=https://www.google.de';

        return $data;
    }

    /**
     * @param IsotopeOrderableCollection $orderableCollection
     *
     * @return BrandInterface
     */
    public function setIsotopeOrderableProductCollection(IsotopeOrderableCollection $orderableCollection)
    {
        $this->order = $orderableCollection;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasPaymentForm()
    {
        return false;
    }

    public function getPaymentForm(ResponseInterface $response, $defaultUrl = '')
    {
        return '';
    }
}
