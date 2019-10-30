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

namespace Encomage\Careers\Model\Config\Source;

use Magento\Cms\Model\ResourceModel\Block\Collection;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class CmsBlockList
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\Config\Source
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class CmsBlockList implements ArrayInterface
{
    /**
     * Cms Block Collection
     *
     * @var Collection
     */
    protected $collection;

    /**
     * CmsBlockList constructor.
     *
     * @param Collection $collection Block Collection
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * To Option Array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array_merge(
            [
            [
                'value' => '',
                'label' => __('---None---')
            ]],
            $this->collection->toOptionArray()
        );
    }
}