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

use Contao\Environment;
use Contao\FrontendTemplate;
use Contao\PageModel;
use Isotope\Interfaces\IsotopeOrderableCollection;
use Vrpayment\ContaoIsotopeBundle\Http\ResponseInterface;

class DirectDebitSepa extends AbstractBrand implements BrandInterface
{
    public function getPaymentData()
    {
        $data = 'entityId='.$this->getEntityId().
            '&amount='.$this->getAmount().
            '&currency='.$this->getCurrency().
            '&paymentType='.$this->getPaymentType();

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
        return true;
    }

    /**
     * @param ResponseInterface $response
     * @param string            $defaultUrl
     *
     * @return string
     */
    public function getPaymentForm(ResponseInterface $response, $defaultUrl)
    {
        $template = new FrontendTemplate('vrpayment_debit_checkoutform');
        $template->shopperResultUrl = Environment::get('url').'/'.PageModel::findOneBy('id', $this->order->getPaymentMethod()->vrpayment_shopperResultUrl)->getFrontendUrl();
        $template->brand = $this->order->getPaymentMethod()->vrpayment_brand;
        $template->defaultUrl = $defaultUrl;
        $template->checkoutID = $this->getPaymentFormCheckoutId($response->json());

        return $template->parse();
    }
}
