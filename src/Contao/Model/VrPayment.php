<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Vrpayment\ContaoIsotopeBundle\Contao\Model;


use Contao\StringUtil;
use Isotope\CheckoutStep\PaymentMethod;
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
            \System::log('Product collection ID "' . $objOrder->getId() . '" is not purchasable', __METHOD__, TL_ERROR);
            return false;
        }

        $arrData = [];

        foreach($objOrder->getItems() as $objItem)
        {
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
        $objTemplate             = new Template('iso_payment_vrpayment');
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

        foreach ($givenPaymentTypes as $givenPaymentType)
        {
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
