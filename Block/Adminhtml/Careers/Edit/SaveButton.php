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

namespace Encomage\Careers\Block\Adminhtml\Careers\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveButton
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Block\Adminhtml\Careers\Edit
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Get Data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'          => __('Save'),
            'class'          => 'save primary',
            'data_attribute' => [
                'mage-init'  => [
                    'button' => [
                        'event'  => 'save',
                        'target' => '#edit_form',
                    ],
                ],
                'form-role' => 'save',
            ],
            'sort_order'     => 90,
        ];
    }
}