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


use Contao\FrontendTemplate;
use Isotope\Interfaces\IsotopeOrderableCollection;

class Visa extends AbstractBrand implements BrandInterface
{
    public function getPaymentData()
    {
        $data = "entityId=".$this->getEntityId() .
            "&amount=" .$this->getAmount() .
            "&currency=" . $this->getCurrency() .
            "&paymentType=" . $this->getPaymentType();

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
        return true;
    }

    public function getPaymentForm()
    {

        $template = new FrontendTemplate('vrpayment_debit_checkoutform');
        $template->shopperResultUrl = $this->order->getPaymentMethod()->vrpayment_shopperResultUrl;
        $template->brand = $this->order->getPaymentMethod()->vrpayment_brand;

        return $template->parse();
    }
}
