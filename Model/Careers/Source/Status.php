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

namespace Encomage\Careers\Model\Careers\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Status
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\Careers\Source
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Status implements OptionSourceInterface
{
    /**
     * Enabled | Disabled option
     */
    const
        STATUS_ENABLED  = 1,
        STATUS_DISABLED = 0;

    /**
     * Option Interface
     *
     * @var OptionSourceInterface
     */
    protected $options;

    /**
     * Retrieve Visible Status Ids
     *
     * @return int[]
     */
    public function getVisibleStatusIds()
    {
        return [static::STATUS_ENABLED];
    }

    /**
     * To Option Array
     *
     * @return array|OptionSourceInterface
     */
    public function toOptionArray()
    {
        if ($this->options) {
            return $this->options;
        }
        $this->options[] = [
            'label' => __('Enabled'),
            'value' => static::STATUS_ENABLED,
            ];
        $this->options[] = [
            'label' => __('Disabled'),
            'value' => static::STATUS_DISABLED,
            ];

        return $this->options;
    }
}