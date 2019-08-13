<?php
/**
 * contao-isotope-bundle for Contao Open Source CMS
 *
 * Copyright (C) 2019 47GradNord - Agentur für Internetlösungen
 *
 * @license    commercial
 * @author     Holger Neuner
 */


namespace Vrpayment\ContaoIsotopeBundle;


use Contao\PageModel;
use Isotope\Interfaces\IsotopeOrderableCollection;
use Isotope\Model\ProductCollectionItem;
use Isotope\Model\TaxRate;

class Order
{
    /** @var IsotopeOrderableCollection */
    protected $orderableCollection;

    /**
     * Order constructor.
     * @param IsotopeOrderableCollection $orderableCollection
     */
    public function __construct(IsotopeOrderableCollection $orderableCollection)
    {
        $this->orderableCollection = $orderableCollection;
    }

    /**
     * @return string
     */
    public function getPaymentAuthorizationToken()
    {
        return $this->orderableCollection->getPaymentMethod()->vrpayment_token;
    }

    /**
     * @return string
     */
    public function getPaymentEntityId()
    {
        return $this->orderableCollection->getPaymentMethod()->vrpayment_entityid;
    }

    /**
     * @return string
     */
    public function getPaymentBrand()
    {
        return $this->orderableCollection->getPaymentMethod()->vrpayment_brand;
    }

    /**
     * @return string
     */
    public function getPaymentType()
    {
        return $this->orderableCollection->getPaymentMethod()->vrpayment_type;
    }

    /***
     * @param bool $id
     * @return string|int
     */
    public function getPaymentShopperResultUrl($id = false)
    {
        if(!$id)
        {
            return \Environment::get('url').'/'.PageModel::findByPk($this->orderableCollection->getPaymentMethod()->vrpayment_shopperResultUrl)->getFrontendUrl();
        }

        return $this->orderableCollection->getPaymentMethod()->vrpayment_shopperResultUrl;
    }

    /**
     * @return string
     */
    public function getPaymentMerchantId()
    {
        return $this->orderableCollection->getPaymentMethod()->vrpayment_merchantId;
    }

    /**
     * @return string
     */
    public function getOrderCustomerGivenName()
    {
        return $this->orderableCollection->getMember()->firstname;
    }

    /**
     * @return string
     */
    public function getOrderCustomerSurname()
    {
        return $this->orderableCollection->getMember()->lastname;
    }

    public function getOrderCustomerCompanyName()
    {
        return $this->orderableCollection->getMember()->company;
    }

    /**
     * @return string
     */
    public function getOrderCustomerEmail()
    {
        return $this->orderableCollection->getMember()->email;
    }

    /**
     * @return \Isotope\Model\Address|null
     */
    public function getOrderBillingAddress()
    {
        return $this->orderableCollection->getBillingAddress();
    }

    /**
     * @return \Isotope\Model\Address|null
     */
    public function getOrderShippingAddress()
    {
        return $this->orderableCollection->getShippingAddress();
    }

    /**
     * @return float
     */
    public function getOrderAmount()
    {
        return number_format($this->orderableCollection->getTotal(), 2);
    }

    public function getOrderCurrency()
    {
        return $this->orderableCollection->getCurrency();
    }

    public function getOrderCartItems($addShipping = false)
    {
        $cartItems = '';

        $count = 0;

        /** @var ProductCollectionItem $item */
        foreach ($this->orderableCollection->getItems() as $key => $item) {
            $cartItems .= '&cart.items['.$count.'].name='.$item->getName().
                '&cart.items['.$count.'].merchantItemId='.$item->getSku().
                '&cart.items['.$count.'].price='.number_format($item->getPrice(), 2).
                '&cart.items['.$count.'].quantity='.$item->quantity.
                '&cart.items['.$count.'].totalAmount='.number_format($item->getTotalPrice(), 2).
                '&cart.items['.$count.'].tax='.$this->getOrderTaxRatePerCartItemFormatted($item).
                '&cart.items['.$count.'].totalTaxAmount='.$this->getOrderTotalTaxAmount($item);

            ++$count;
        }

        if(!$addShipping)
        {
            return $cartItems;
        }

        $cartItems .= '&cart.items['.$count.'].name='.$this->orderableCollection->getShippingSurcharge()->label.
            '&cart.items['.$count.'].merchantItemId=S'.$this->orderableCollection->getShippingSurcharge()->source_id.
            '&cart.items['.$count.'].price='.number_format($this->orderableCollection->getShippingSurcharge()->total_price, 2).
            '&cart.items['.$count.'].quantity=1&cart.items['.$count.'].totalAmount='.number_format($this->orderableCollection->getShippingSurcharge()->total_price, 2).
            '&cart.items['.$count.'].tax=0&cart.items['.$count.'].totalTaxAmount=0';

        return $cartItems;
    }

    /**
     * @return bool
     */
    public function getTestmode()
    {
        if('1' === $this->orderableCollection->getPaymentMethod()->debug)
        {
            return true;
        }

        false;
    }

    /**
     * @param ProductCollectionItem $item
     *
     * @return float
     */
    private function getOrderTaxRatePerCartItemFormatted(ProductCollectionItem $item)
    {
        if (!$item->hasProduct()) {
            return 0.0;
        }

        $objProduct = $item->getProduct();
        $price = $objProduct->getPrice();
        $objTaxClass = $price->getRelated('tax_class');

        /** @var TaxRate $taxRate */
        $taxRate = $objTaxClass->getRelated('includes');

        $rate = explode('.', $taxRate->getAmount());

        return '0.'.$rate[0];
    }

    /**
     * @param ProductCollectionItem $item
     *
     * @return float
     */
    private function getOrderTotalTaxAmount(ProductCollectionItem $item)
    {
        return number_format($item->getTotalPrice() - $item->getTaxFreeTotalPrice(), 2);
    }
}
