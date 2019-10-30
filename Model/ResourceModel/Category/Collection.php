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

namespace Encomage\Careers\Model\ResourceModel\Category;

use Encomage\Careers\Model\Category as CareersCategory;
use Encomage\Careers\Model\ResourceModel\Category as ResourceCareersCategory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\ResourceModel\Category
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Collection extends AbstractCollection
{
    /**
     * Construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(CareersCategory::class, ResourceCareersCategory::class);
    }

    /**
     * To Option array
     *
     * @param string $valueField Value Field
     * @param string $labelField Label Field
     * @param array  $additional Additional
     *
     * @return array
     */
    protected function _toOptionArray(
        $valueField = 'id',
        $labelField = 'title',
        $additional = []
    ) {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
}