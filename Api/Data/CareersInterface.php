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

namespace Encomage\Careers\Api\Data;

/**
 * Interface CareersInterface
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Api\Data
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
interface CareersInterface
{
    const
        TITLE            = 'title',
        STATUS           = 'status',
        ITEM_ID          = 'id',
        CONTENT          = 'content',
        POSITION         = 'position',
        CREATED_AT       = 'created_at',
        UPDATED_AT       = 'updated_at',
        IDENTIFIER       = 'identifier',
        META_TITLE       = 'meta_title',
        META_KEYWORDS    = 'meta_keywords',
        META_DESCRIPTION = 'meta_description',
        CATEGORY_ID      = 'category_id',
        STORE_ID         = 'store_id';

    /**
     * Get Item Id
     *
     * @return int|mixed
     */
    public function getItemId();

    /**
     * Set Item Id
     *
     * @param int $entityId Entity Id
     *
     * @return mixed
     */
    public function setItemId(int $entityId);

    /**
     * Get Status
     *
     * @return mixed
     */
    public function getStatus();

    /**
     * Set Status
     *
     * @param string $status Status
     *
     * @return mixed
     */
    public function setStatus(string $status);

    /**
     * Get Title
     *
     * @return mixed
     */
    public function getTitle();

    /**
     * Set Title
     *
     * @param string $title Title
     *
     * @return mixed
     */
    public function setTitle(string $title);

    /**
     * Get Identifier
     *
     * @return mixed
     */
    public function getIdentifier();

    /**
     * Set Identifier
     *
     * @param string $identifier Identifier
     *
     * @return mixed
     */
    public function setIdentifier(string $identifier);

    /**
     * Get Position
     *
     * @return int|mixed
     */
    public function getPosition();

    /**
     * Set Position
     *
     * @param int $position Position
     *
     * @return mixed
     */
    public function setPosition(int $position);

    /**
     * Get Created Date
     *
     * @return mixed
     */
    public function getCreatedAt();

    /**
     * Set Created Date
     *
     * @param string $date CreatedAt
     *
     * @return mixed
     */
    public function setCreatedAt(string $date);

    /**
     * Get Updated Date
     *
     * @return mixed
     */
    public function getUpdatedAt();

    /**
     * Set Created Date
     *
     * @param string $date UpdateAt
     *
     * @return mixed
     */
    public function setUpdatedAt(string $date);

    /**
     * Get Content
     *
     * @return mixed
     */
    public function getContent();

    /**
     * Set Content
     *
     * @param string $content Content
     *
     * @return mixed
     */
    public function setContent(string $content);

    /**
     * Get Meta Title
     *
     * @return mixed
     */
    public function getMetaTitle();

    /**
     * Set Meta Title
     *
     * @param string $title MetaTitle
     *
     * @return mixed
     */
    public function setMetaTitle(string $title);

    /**
     * Get Meta Description
     *
     * @return mixed
     */
    public function getMetaDescription();

    /**
     * Set Meta Description
     *
     * @param string $description MetaDescription
     *
     * @return mixed
     */
    public function setMetaDescription(string $description);

    /**
     * Get Meta Keywords
     *
     * @return mixed
     */
    public function getMetaKeywords();

    /**
     * Set Meta Keywords
     *
     * @param string $keywords MetaKeywords
     *
     * @return mixed
     */
    public function setMetaKeywords(string $keywords);

    /**
     * Get Category Id
     *
     * @return mixed
     */
    public function getCategoryId();

    /**
     * Set Category Id
     *
     * @param int $categoryId CategoryId
     *
     * @return mixed
     */
    public function setCategoryId(int $categoryId);
}