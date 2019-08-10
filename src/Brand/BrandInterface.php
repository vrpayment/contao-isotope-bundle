<?php


namespace Vrpayment\ContaoIsotopeBundle\Brand;


use Isotope\Interfaces\IsotopeOrderableCollection;
use Vrpayment\ContaoIsotopeBundle\Http\ResponseInterface;

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

    /**
     * @return bool
     */
    public function hasPaymentForm();

    /**
     * @return string
     */
    public function getPaymentForm();

}
