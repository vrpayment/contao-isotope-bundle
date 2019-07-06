<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */

$GLOBALS['TL_DCA']['tl_iso_payment']['palettes']['vrpayment'] = '{type_legend},name,label,type;{note_legend:hide},note;{config_legend},new_order_status,quantity_mode,minimum_quantity,maximum_quantity,minimum_total,maximum_total,countries,shipping_modules,product_types,product_types_condition,config_ids;{gateway_legend},vrpayment_userid,vrpayment_password;{vrpayment_config_legend},vrpayment_paymentmethod;{price_legend:hide},price,tax_class;{enabled_legend},enabled,debug,logging';

// Additional Fields
$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['vrpayment_userid'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_userid'],
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                   => "varchar(255) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['vrpayment_password'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_password'],
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50', 'hideInput'=>true),
    'sql'                   => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['vrpayment_paymentmethod'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_paymentmethod'],
    'exclude' 		        => true,
    'inputType' 		    => 'multiColumnWizard',
    'eval' 			=> array
    (
        'columnFields' => array
        (
            'vrpayment_paymentmethod_brand' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_paymentmethod_brand'],
                'inputType'             => 'select',
                'options'               => array('MASTER', 'VISA', 'PAYDIREKT', 'PAYPAL', 'SOFORTUEBERWEISUNG', 'DIRECTDEBIT_SEPA'),
                'eval' 			        => array('style' => 'width:150px', 'includeBlankOption'=>true, 'chosen'=>true, 'mandatory' => true),
                'reference'             => &$GLOBALS['TL_LANG']['tl_iso_payment'],
            ),
            'vrpayment_paymentmethod_entityid' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_paymentmethod_entityid'],
                'inputType'             => 'text',
                'eval' 			        => array('style' => 'width:300px', 'mandatory'=>true, 'decodeEntities'=>true)
            ),
            'vrpayment_paymentmethod_type' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_paymentmethod_type'],
                'inputType'             => 'select',
                'options'                 => array('PA' => 'Preauthorization', 'DB' => 'Debit', 'CD' => 'Credit', 'CP' => 'Capture', 'RV' => 'Reversal', 'RF' => 'Refund'),
                'eval' 			        => array('style' => 'width:120px', 'includeBlankOption'=>true, 'chosen'=>true, 'mandatory' => true)
            ),
            'vrpayment_paymentmethod_label' => array
            (
                'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_paymentmethod_label'],
                'inputType'             => 'text',
                'eval' 			        => array('style' => 'width:300px', 'mandatory'=>true, 'decodeEntities'=>true)
            ),
        ),
        'tl_class' => 'long'
    ),
    'sql'                   => "blob NULL"
);
