<?php


namespace Vrpayment\ContaoIsotopeBundle\Brand;


use Isotope\Interfaces\IsotopeOrderableCollection;

interface BrandInterface
{
    /**
     * @return string
     */
    public function getPaymentData();

    /**
     * @param IsotopeOrderableCollection $orderableCollection
     * @return BrandInterface
     */
    public function setIsotopeOrderableProductCollection(IsotopeOrderableCollection $orderableCollection);
}
