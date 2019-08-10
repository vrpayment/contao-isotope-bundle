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

class Visa extends AbstractBrand implements BrandInterface
{
    public function getPaymentData()
    {
        // TODO: Implement getPaymentData() method.
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
}
