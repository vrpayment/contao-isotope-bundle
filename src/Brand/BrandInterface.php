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

interface BrandInterface
{
    /**
     * @return string
     */
    public function getPaymentData();

    /**
     * @param IsotopeOrderableCollection $orderableCollection
     *
     * @return BrandInterface
     */
    public function setIsotopeOrderableProductCollection(IsotopeOrderableCollection $orderableCollection);

    /**
     * @return bool
     */
    public function hasPaymentForm();

    /**
     * @param ResponseInterface $response
     * @param string            $defaultUrl
     *
     * @return string
     */
    public function getPaymentForm(ResponseInterface $response, $defaultUrl);
}
