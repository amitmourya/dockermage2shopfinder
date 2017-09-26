<?php


namespace Mourya\Shopfinder\Model;

use Mourya\Shopfinder\Api\Data\ShopsInterface;

class Shops extends \Magento\Framework\Model\AbstractModel implements ShopsInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mourya\Shopfinder\Model\ResourceModel\Shops');
    }

    /**
     * Get shop_id
     * @return string
     */
    public function getShopsId()
    {
        return $this->getData(self::SHOP_ID);
    }

    /**
     * Set shop_id
     * @param string $shopsId
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    public function setShopsId($shopsId)
    {
        return $this->setData(self::SHOP_ID, $shopsId);
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set name
     * @param string $name
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Get identifier
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * Set identifier
     * @param string $identifier
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * Get country
     * @return string
     */
    public function getCountry()
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * Set country
     * @param string $country
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    public function setCountry($country)
    {
        return $this->setData(self::COUNTRY, $country);
    }

    /**
     * Get image
     * @return string
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Get image
     * @return string
     */
    public function getImageUrl()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set image
     * @param string $image
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    public function setImage($image)
    {
        return 'amit'.$this->setData(self::IMAGE, $image);
    }

    /**
     * Set image
     * @param string $image
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    public function setImageUrl($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get store_view
     * @return string
     */
    public function getStoreView()
    {
        return $this->getData(self::STORE_VIEW);
    }

    /**
     * Set store_view
     * @param string $store_view
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    public function setStoreView($store_view)
    {
        return $this->setData(self::STORE_VIEW, $store_view);
    }

    /**
     * Get created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $created_at
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    public function setCreatedAt($created_at)
    {
        return $this->setData(self::CREATED_AT, $created_at);
    }
}
