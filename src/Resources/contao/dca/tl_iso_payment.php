<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */

$GLOBALS['TL_DCA']['tl_iso_payment']['palettes']['vrpayment'] = '{type_legend},name,label,type;{note_legend:hide},note;{config_legend},new_order_status,quantity_mode,minimum_quantity,maximum_quantity,minimum_total,maximum_total,countries,shipping_modules,product_types,product_types_condition,config_ids;{gateway_legend},vrpayment_token, vrpayment_entityid, vrpayment_brand,vrpayment_brandlogo;{vrpayment_config_legend};{price_legend:hide},price,tax_class;{enabled_legend},enabled,debug,logging';

// Additional Fields
$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['vrpayment_token'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_token'],
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                   => 'text NULL',
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['vrpayment_entityid'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_entityid'],
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                   => "varchar(255) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['vrpayment_brand'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_brand'],
    'inputType'             => 'text',
    'eval'                  => array('mandatory'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                   => "varchar(64) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_iso_payment']['fields']['vrpayment_brandlogo'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_iso_payment']['vrpayment_brandlogo'],
    'exclude'                 => true,
    'inputType'               => 'fileTree',
    'eval'                    => array('fieldType'=>'radio', 'filesOnly'=>true, 'mandatory'=>true, 'tl_class'=>'clr', 'extensions'=>'jpg,png,jpeg,gif'),
    'sql'                     => "binary(16) NULL"
);
