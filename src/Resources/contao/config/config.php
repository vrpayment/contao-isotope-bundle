<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


// Register vrpayment as payment method
\Isotope\Model\Payment::registerModelType('vrpayment', 'Vrpayment\\ContaoIsotopeBundle\\Contao\\Model\\VrPayment');

// Config possible PaymentTypes
$GLOBALS['VRPAYMENT_TYPES'] = [
    'MASTER' => [
        'icon' => 'paymenticon_MASTER'
    ],
];
