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

namespace Encomage\Careers\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor;

use Magento\Framework\Api\Filter;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor\FilterProcessor\CustomFilterInterface;
use Magento\Framework\Data\Collection\AbstractDb;

/**
 * Class CareersStoreFilter
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\Api\SearchCriteria\CollectionProcessor\FilterProcessor
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class CareersStoreFilter implements CustomFilterInterface
{
    /**
     * Apply
     *
     * @param Filter     $filter     Filter
     * @param AbstractDb $collection Collection
     *
     * @return bool
     */
    public function apply(Filter $filter, AbstractDb $collection)
    {
        /**
         * Collection
         *
         * @var \Encomage\Careers\Model\ResourceModel\Careers\Collection $collection
         */
        $collection->addStoreFilter($filter->getValue());

        return true;
    }
}