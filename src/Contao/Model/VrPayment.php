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

use Contao\StringUtil;
use Contao\System;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Isotope\Interfaces\IsotopeOrderableCollection;
use Isotope\Interfaces\IsotopePayment;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Interfaces\IsotopePurchasableCollection;
use Isotope\Isotope;
use Isotope\Model\Payment;
use Isotope\Model\ProductCollection\Order;
use Isotope\Template;
use Vrpayment\ContaoIsotopeBundle\Brand\BrandFactory;
use Vrpayment\ContaoIsotopeBundle\Brand\BrandInterface;
use Vrpayment\ContaoIsotopeBundle\Http\ResponseInterface;
use Vrpayment\ContaoIsotopeBundle\Payment\PaymentDataEnterpay;
use Vrpayment\ContaoIsotopeBundle\Payment\PaymentDataFactory;

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
        $client = new \Vrpayment\ContaoIsotopeBundle\Client('OGFjN2E0Yzc2YmRmYWU0MzAxNmJlMTdkNWZhODA0NWN8S3lKczVocFd6eQ==');

        /** @var ResponseInterface $response */
        $response = $client->send($brand->getPaymentData());
        dump($response->getStatusCode());
        dump($response->getBody()); exit;


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

        /** @var Template|\stdClass $objTemplate */
        $objTemplate = new Template('iso_payment_vrpayment');
        $objTemplate->setData($arrData);

        return $objTemplate->parse();
    }

    protected function getPaymentData(IsotopeOrderableCollection $objOrder)
    {
        switch ($objOrder->getPaymentMethod()->vrpayment_brand) {

            case 'ENTERPAY':

                return new PaymentDataEnterpay($objOrder);

            default:

                return null;
        }



    }
}
