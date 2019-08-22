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
use Isotope\Model\Payment;
use Isotope\Module\Checkout;
use Isotope\Template;
use Vrpayment\ContaoIsotopeBundle\Entity\PaymentStatus;
use Vrpayment\ContaoIsotopeBundle\Entity\PreAuthorization;
use Vrpayment\ContaoIsotopeBundle\VrPaymentManager;

class VrPayment extends Payment implements IsotopePayment
{
    /**
     * @var string
     */
    protected $ressourcePath;

    public function __construct(\Database\Result $objResult = null)
    {
        $this->ressourcePath = Input::get('resourcePath');
        parent::__construct($objResult);
    }

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

        /** @var Template|\stdClass $objTemplate */
        $objTemplate = new Template('iso_payment_vrpayment');

        /** @var VrPaymentManager $vrPaymentManager */
        $vrPaymentManager = System::getContainer()->get('Vrpayment\ContaoIsotopeBundle\VrPaymentManager')
            ->setOrder($objOrder)
            ->setBrand()
            ->setClient();

        // Handle Request come back with Ressource Path
        if (null !== $this->ressourcePath) {

            $paymentStatus = $vrPaymentManager->getPaymentStatus($this->ressourcePath);

            if (!$paymentStatus->isHasError()) {
                $objOrder->checkout();
                $objOrder->updateOrderStatus($this->new_order_status);

                // Redirect to Checkout
                $strUrl = Checkout::generateUrlForStep('complete', $objOrder);
                Controller::redirect($strUrl, 301);
            }

            $objTemplate->error = 'Wir konnten Ihre Zahlung nicht abwickeln. Fehlercode: '.$paymentStatus->getResultCode().', Description:'.$paymentStatus->getResultDescription();

            return $objTemplate->parse();
        }

        // Handle if PaymentBrand has to show a PaymentForm
        if ($vrPaymentManager->getBrand()->showPaymentForm()) {
            $objTemplate->paymentForm = $vrPaymentManager->getBrand()->getPaymentForm($vrPaymentManager->getPrecheckout());

            return $objTemplate->parse();
        }

        // Handle if PaymentBrand has to proceed any Pre Authorization
        if ($vrPaymentManager->getBrand()->proceedPreAuthorization()) {
            /** @var PreAuthorization $preAuthorization */
            $preAuthorization = $vrPaymentManager->getPreAuthorization();

            if ($preAuthorization->isHasError()) {
                $objTemplate->error = 'Fehlercode: '.$preAuthorization->getResultCode().', Description:'.$preAuthorization->getResultDescription();

                return $objTemplate->parse();
            }

            Controller::redirect($preAuthorization->getRedirectUrl());
        }
    }
}
