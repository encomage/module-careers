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

namespace Encomage\Careers\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface CategoryRepositoryInterface
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Api
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
interface CategoryRepositoryInterface
{
    /**
     * Save
     *
     * @param Data\CategoryInterface $item Item
     *
     * @return mixed
     */
    public function save(Data\CategoryInterface $item);

    /**
     * Get By Id
     *
     * @param int $entityId Entity
     *
     * @return mixed
     */
    public function getById($entityId);

    /**
     * Get List
     *
     * @param SearchCriteriaInterface $searchCriteria SearchCriteria
     *
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete
     *
     * @param Data\CategoryInterface $item Item
     *
     * @return mixed
     */
    public function delete(Data\CategoryInterface $item);

    /**
     * Delete By Id
     *
     * @param int $entityId Entity
     *
     * @return mixed
     */
    public function deleteById($entityId);
}