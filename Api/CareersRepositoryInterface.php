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
 * Interface CareersRepositoryInterface
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Api
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
interface CareersRepositoryInterface
{
    /**
     * Save
     *
     * @param Data\CareersInterface $item Save
     *
     * @return mixed
     */
    public function save(Data\CareersInterface $item);

    /**
     * Get By Id
     *
     * @param int $entityId Entity Id
     *
     * @return mixed
     */
    public function getById($entityId);

    /**
     * Get By Identifier
     *
     * @param string $identifier Identifier
     *
     * @return mixed
     */
    public function getByIdentifier($identifier);

    /**
     * Get List
     *
     * @param SearchCriteriaInterface $searchCriteria SearchCriteriaInterface
     *
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete
     *
     * @param Data\CareersInterface $item Item
     *
     * @return mixed
     */
    public function delete(Data\CareersInterface $item);

    /**
     * Delete By Id
     *
     * @param int $entityId Entity
     *
     * @return mixed
     */
    public function deleteById($entityId);
}