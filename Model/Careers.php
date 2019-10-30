<?php

/**
 * Encomage_Careers
 *
 * PHP version 7.0
 *
 * @category Magento2-module
 * @package  Encomage_Careers
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */

namespace Encomage\Careers\Model;

use Encomage\Careers\Api\Data\CareersInterface;
use Encomage\Careers\Model\ResourceModel\Careers as CareersResource;
use Encomage\Careers\Helper\Url as UrlHelper;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Registry;

/**
 * Class Careers
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Careers extends AbstractModel implements CareersInterface
{
    /**
     * Helper Url
     *
     * @var UrlHelper
     */
    protected $urlHelper;

    /**
     * Careers constructor.
     *
     * @param UrlHelper             $urlHelper          Helper
     * @param Context               $context            Context
     * @param Registry              $registry           Registry
     * @param AbstractResource|null $resource           Resource Abstract
     * @param AbstractDb|null       $resourceCollection Collection
     * @param array                 $data               Data
     */
    public function __construct(
        UrlHelper $urlHelper,
        Context $context,
        Registry $registry,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
        $this->urlHelper = $urlHelper;
    }

    /**
     * Get View Url
     *
     * @return string
     */
    public function getViewUrl()
    {
        return $this->urlHelper->getViewUrl($this->getIdentifier());
    }

    /**
     * Get Identifier
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * Get Stores
     *
     * @return mixed
     */
    public function getStores()
    {
        return $this->hasData('stores') ? $this->getData('stores') :
            $this->getData('store_id');
    }

    /**
     * Get Item Id
     *
     * @return int|mixed
     */
    public function getItemId()
    {
        return (int)$this->getData(self::ITEM_ID);
    }

    /**
     * Set Item Id
     *
     * @param int $entityId Entity Id
     *
     * @return mixed
     */
    public function setItemId(int $entityId)
    {
        return $this->setData(self::ITEM_ID, $entityId);
    }

    /**
     * Get Status
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set Status
     *
     * @param string $status Status
     *
     * @return mixed
     */
    public function setStatus(string $status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get Title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set Title
     *
     * @param string $title Title
     *
     * @return mixed
     */
    public function setTitle(string $title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get Position
     *
     * @return int|mixed
     */
    public function getPosition()
    {
        return (int)$this->getData(self::POSITION);
    }

    /**
     * Set Position
     *
     * @param int $position Position
     *
     * @return mixed
     */
    public function setPosition(int $position)
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * Get Created Date
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set Created Date
     *
     * @param string $date Created Date
     *
     * @return mixed
     */
    public function setCreatedAt(string $date)
    {
        return $this->setData(self::CREATED_AT, $date);
    }

    /**
     * Get Updated At
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set Updated At
     *
     * @param string $date Update At
     *
     * @return mixed
     */
    public function setUpdatedAt(string $date)
    {
        return $this->setData(self::UPDATED_AT, $date);
    }

    /**
     * Get Content
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * Set Content
     *
     * @param string $content Content
     *
     * @return $this|mixed
     */
    public function setContent(string $content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * Set Identifier
     *
     * @param string $identifier Identifier
     *
     * @return $this|mixed
     */
    public function setIdentifier(string $identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * Get Meta Title
     *
     * @return mixed
     */
    public function getMetaTitle()
    {
        return $this->getData(self::META_TITLE);
    }

    /**
     * Set Meta Title
     *
     * @param string $title Meta Title
     *
     * @return mixed
     */
    public function setMetaTitle(string $title)
    {
        return $this->setData(self::META_TITLE, $title);
    }

    /**
     * Get Meta Description
     *
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->getData(self::META_DESCRIPTION);
    }

    /**
     * Set Meta Description
     *
     * @param string $description Meta Description
     *
     * @return mixed
     */
    public function setMetaDescription(string $description)
    {
        return $this->setData(self::META_DESCRIPTION, $description);
    }

    /**
     * Get Meta Keywords
     *
     * @return mixed
     */
    public function getMetaKeywords()
    {
        return $this->getData(self::META_KEYWORDS);
    }

    /**
     * Set Meta KeyWords
     *
     * @param string $keywords Meta Keywords
     *
     * @return mixed
     */
    public function setMetaKeywords(string $keywords)
    {
        return $this->setData(self::META_KEYWORDS, $keywords);
    }

    /**
     * Get Category Id
     *
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->getData(self::CATEGORY_ID);
    }

    /**
     * Set Category Id
     *
     * @param int $categoryId Category Id
     *
     * @return mixed
     */
    public function setCategoryId(int $categoryId)
    {
        return $this->setData(self::CATEGORY_ID, $categoryId);
    }

    /**
     * Construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(CareersResource::class);
    }
}