<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Vrpayment\ContaoIsotopeBundle\Brand;


use Isotope\Interfaces\IsotopeOrderableCollection;
use Vrpayment\ContaoIsotopeBundle\Http\ResponseInterface;
use Vrpayment\ContaoIsotopeBundle\StaticHelper;

class Enterpay extends AbstractBrand
{
    public function getPaymentData()
    {
        $data = "entityId=".$this->getEntityId() .
            "&customParameters[merchantId]=" . StaticHelper::getUniqueIdentifier() .
            "&amount=" .$this->getAmount() .
            "&currency=" . $this->getCurrency() .
            "&paymentBrand=" . $this->getPaymentBrand() .
            "&paymentType=" . $this->getPaymentType() .
            "&billing.city=" . $this->getBillingAddress()->city .
            "&billing.postcode=" . $this->getBillingAddress()->postal .
            "&billing.street1=" . $this->getBillingAddress()->street_1 . $this->getCartItems().
            "&shipping.city=". $this->getShippingAddress()->city .
            "&shipping.postcode=". $this->getShippingAddress()->postal .
            "&shipping.street1=". $this->getShippingAddress()->street_1 .
            "&shopperResultUrl=https://www.google.de";

        return $data;
    }

    /**
     * @param IsotopeOrderableCollection $orderableCollection
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

    public function getPaymentForm()
    {
        return '';
    }
}
