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
 * Interface CategoryInterface
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Api\Data
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
interface CategoryInterface
{
    const
        ID         = 'id',
        TITLE      = 'title',
        ITEM_ID    = 'id',
        SORT_ORDER = 'sort_order';

    /**
     * Get Id
     *
     * @return int|mixed
     */
    public function getId();

    /**
     * Set Id
     *
     * @param int $entityId Entity Id
     *
     * @return mixed
     */
    public function setId($entityId);


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
     * Get Sort Order
     *
     * @return mixed
     */
    public function getSortOrder();

    /**
     * Set Sort Order
     *
     * @param int $order Order
     *
     * @return mixed
     */
    public function setSortOrder(int $order);
}