<?php


namespace Mourya\Shopfinder\Api\Data;

interface ShopsInterface
{

    const SHOP_ID       = 'shop_id';
    const NAME          = 'name';
    const IDENTIFIER    = 'identifier';
    const COUNTRY       = 'country';
    const IMAGE         = 'image';
    const STORE_VIEW    = 'store_id';
    const CREATED_AT    = 'created_at';


    /**
     * Get shop_id
     * @return string|null
     */
    
    public function getShopsId();

    /**
     * Set shop_id
     * @param string $shop_id
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setShopsId($shopsId);

    /**
     * Get name
     * @return string|null
     */
    
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setName($name);

    /**
     * Get identifier
     * @return string|null
     */
    
    public function getIdentifier();

    /**
     * Set identifier
     * @param string $identifier
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setIdentifier($identifier);

    /**
     * Get country
     * @return string|null
     */
    
    public function getCountry();

    /**
     * Set country
     * @param string $country
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setCountry($country);

    /**
     * Get image
     * @return string|null
     */
    
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setImage($image);

    /**
     * Get store_view
     * @return string|null
     */
    
    public function getStoreView();

    /**
     * Set store_view
     * @param string $store_view
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setStoreView($store_view);

    /**
     * Get created_at
     * @return string|null
     */
    
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $created_at
     * @return Mourya\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setCreatedAt($created_at);
}
