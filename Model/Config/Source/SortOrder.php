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

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class SortOrder
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\Config\Source
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class SortOrder implements OptionSourceInterface
{
    /**
     * To Option Array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return $this->getAllOptions();
    }

    /**
     * Get All Option
     *
     * @return array
     */
    public function getAllOptions()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = [
                    'value' => $index,
                    'label' => $value
                ];
        }

        return $result;
    }

    /**
     * Get Option Array
     *
     * @return array
     */
    public static function getOptionArray()
    {
        return
               [
                   \Magento\Framework\Api\SortOrder::SORT_ASC
                   => __('Ascending'),
                   \Magento\Framework\Api\SortOrder::SORT_DESC
                   => __('Descending')
               ];
    }
}