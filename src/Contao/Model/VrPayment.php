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
use Isotope\Interfaces\IsotopePayment;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Interfaces\IsotopePurchasableCollection;
use Isotope\Isotope;
use Isotope\Model\Payment;
use Isotope\Template;

class VrPayment extends Payment implements IsotopePayment
{
    public function processPayment(IsotopeProductCollection $objOrder, \Module $objModule)
    {
        // TODO: Implement processPayment() method.
    }

    public function checkoutForm(IsotopeProductCollection $objOrder, \Module $objModule)
    {
        if (!$objOrder instanceof IsotopePurchasableCollection) {
            \System::log('Product collection ID "'.$objOrder->getId().'" is not purchasable', __METHOD__, TL_ERROR);

            return false;
        }

        $apiManager = System::getContainer()->get('Vrpayment\ContaoIsotopeBundle\Api\ApiManager');
        $apiManager->initializeWithToken('OGFjN2E0Yzc2YmRmYWU0MzAxNmJlMTdkNWZhODA0NWN8S3lKczVocFd6eQ==', true);

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

        $arrData['paymentTypes'] = $this->getPaymentTypes($objOrder->getPaymentMethod());

        /** @var Template|\stdClass $objTemplate */
        $objTemplate = new Template('iso_payment_vrpayment');
        $objTemplate->setData($arrData);

        return $objTemplate->parse();
    }

    protected function getPaymentTypes(IsotopePayment $objPayment)
    {
        /** @var array $configPaymentType */
        $configPaymentType = $GLOBALS['VRPAYMENT_TYPES'];

        /** @var array $givenPaymentTypes */
        $givenPaymentTypes = StringUtil::deserialize($objPayment->vrpayment_paymentmethod);

        $arrData = [];

        //** @var Template|\stdClass $objTemplate */
        $objTemplate = new Template('iso_payment_vrpayment_paymenttypes');

        foreach ($givenPaymentTypes as $givenPaymentType) {
            $arrData['paymentTypes'][] = [
                'name' => $givenPaymentType['vrpayment_paymentmethod_label'],
                'brand' => $givenPaymentType['vrpayment_paymentmethod_brand'],
                'entityId' => $givenPaymentType['vrpayment_paymentmethod_entityid'],
                'type' => $givenPaymentType['vrpayment_paymentmethod_type'],
                'icon' => $configPaymentType[$givenPaymentType['vrpayment_paymentmethod_brand']]['icon'],
                'handling' => $configPaymentType[$givenPaymentType['vrpayment_paymentmethod_brand']]['handling'],
            ];
        }

        $objTemplate->setData($arrData);

        return $objTemplate->parse();
    }
}
