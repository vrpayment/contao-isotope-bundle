<?php

/*
 * VR Payment GmbH Contao Isotope Bundle
 *
 * @copyright  Copyright (c) 2019-2019, VR Payment GmbH
 * @author     VR Payment GmbH <info@vr-payment.de>
 *
 * @license LGPL-3.0-or-later
 */

namespace Vrpayment\ContaoIsotopeBundle\Contao\Model;

use Contao\FrontendTemplate;
use GuzzleHttp\Client;
use Isotope\Interfaces\IsotopePayment;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Interfaces\IsotopePurchasableCollection;
use Isotope\Isotope;
use Isotope\Model\Payment;
use Isotope\Template;
use Vrpayment\ContaoIsotopeBundle\Brand\BrandFactory;
use Vrpayment\ContaoIsotopeBundle\Brand\BrandInterface;
use Vrpayment\ContaoIsotopeBundle\Http\ResponseInterface;

class VrPayment extends Payment implements IsotopePayment
{
    public function processPayment(IsotopeProductCollection $objOrder, \Module $objModule)
    {
    }

    public function checkoutForm(IsotopeProductCollection $objOrder, \Module $objModule)
    {
        if (!$objOrder instanceof IsotopePurchasableCollection) {
            \System::log('Product collection ID "'.$objOrder->getId().'" is not purchasable', __METHOD__, TL_ERROR);

            return false;
        }

        /** @var BrandInterface $brand */
        $brand = BrandFactory::getBrandByPaymentType($objOrder->getPaymentMethod()->vrpayment_brand);
        $brand->setIsotopeOrderableProductCollection($objOrder);

        /** @var \Vrpayment\ContaoIsotopeBundle\Client $client */
        $client = new \Vrpayment\ContaoIsotopeBundle\Client($objOrder->getPaymentMethod()->vrpayment_token, true);

        /** @var ResponseInterface $response */
        $response = $client->send($objOrder->getPaymentMethod()->vrpayment_type, $brand->getPaymentData());

        $arrData = [];

        foreach ($objOrder->getItems() as $objItem) {
            $arrData['items'][] = [
                'name' => $objItem->getName(),
                'price' => Isotope::formatPriceWithCurrency($objItem->getPrice()),
                'quantitiy' => $objItem->quantity,
            ];
        }

        $arrData['review']['total'] = Isotope::formatPriceWithCurrency($objOrder->getTotal());
        $arrData['review']['subtotal'] = Isotope::formatPriceWithCurrency($objOrder->getSubtotal());
        $arrData['review']['copyPayPaymentForm'] = ($brand->hasPaymentForm()) ? $brand->getPaymentForm($response, $client->getDefaultUrl()) : false;

        /** @var Template|\stdClass $objTemplate */
        $objTemplate = new FrontendTemplate('iso_payment_vrpayment');
        $objTemplate->setData($arrData);

        return $objTemplate->parse();
    }
}
