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

use Contao\Controller;
use Contao\Input;
use Contao\System;
use Isotope\Interfaces\IsotopePayment;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Interfaces\IsotopePurchasableCollection;
use Isotope\Isotope;
use Isotope\Model\Payment;
use Isotope\Module\Checkout;
use Isotope\Template;
use Vrpayment\ContaoIsotopeBundle\Brand\BrandFactory;
use Vrpayment\ContaoIsotopeBundle\Brand\BrandInterface;
use Vrpayment\ContaoIsotopeBundle\Client;
use Vrpayment\ContaoIsotopeBundle\Http\ResponseInterface;
use Vrpayment\ContaoIsotopeBundle\ResultCodeHandler;

class VrPayment extends Payment implements IsotopePayment
{
    /**
     * @var string
     */
    protected $ressourcePath;

    public function processPayment(IsotopeProductCollection $objOrder, \Module $objModule)
    {
        return true;
    }

    public function checkoutForm(IsotopeProductCollection $objOrder, \Module $objModule)
    {
        if (!$objOrder instanceof IsotopePurchasableCollection) {
            \System::log('Product collection ID "'.$objOrder->getId().'" is not purchasable', __METHOD__, TL_ERROR);

            return false;
        }

        // Set Ressource Path if calling payment Status is available
        $this->ressourcePath = Input::get('resourcePath');

        /** @var ResultCodeHandler $resultCodeValiadtor */
        $resultCodeValiadtor = System::getContainer()->get('Vrpayment\ContaoIsotopeBundle\ResultCodeHandler');

        /** @var BrandInterface $brand */
        $brand = BrandFactory::getBrandByPaymentType($objOrder->getPaymentMethod()->vrpayment_brand);
        $brand->setIsotopeOrderableProductCollection($objOrder);

        /** @var \Vrpayment\ContaoIsotopeBundle\Client $client */
        $client = new Client($objOrder->getPaymentMethod()->vrpayment_token, true);

        if (null !== $this->ressourcePath) {

            $response = $client->getPaymentStatus($objOrder, $this->ressourcePath);
            $resultCodeValiadtor->proceedResponseJson($response->json());

            if($resultCodeValiadtor->isSuccessfullyProcessedTransaction())
            {
                $objOrder->checkout();
                $objOrder->updateOrderStatus($this->new_order_status);

                // Redirect to Checkout
                $strUrl = Checkout::generateUrlForStep('complete', $objOrder);
                Controller::redirect($strUrl, 301);
            }

            // Redirect to Checkout
            $strUrl = Checkout::generateUrlForStep('process', $objOrder);
            Controller::redirect($strUrl, 301);

        }

        /** @var ResponseInterface $response */
        $response = $client->send($objOrder->getPaymentMethod()->vrpayment_type, $brand->getPaymentData());
        $resultCodeValiadtor->proceedResponseJson($response->json());

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
        $arrData['review']['copyPayPaymentForm'] = ($brand->hasPaymentForm()) ? $brand->getPaymentForm($response, $client->getUrlWidgetJs()) : false;

        /** @var Template|\stdClass $objTemplate */
        $objTemplate = new Template('iso_payment_vrpayment');
        $objTemplate->setData($arrData);

        return $objTemplate->parse();
    }
}
