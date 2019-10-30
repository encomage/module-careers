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
 * Class SaveAndContinueButton
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Block\Adminhtml\Careers\Edit
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class SaveAndContinueButton implements ButtonProviderInterface
{
    /**
     * Get Data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'          => __('Save and Continue Edit'),
            'class'          => 'save',
            'data_attribute' => [
                'mage-init'  => [
                    'button' => [
                        'event' => 'saveAndContinueEdit',
                    ],
                ],
            ],
            'sort_order'     => 80,
        ];
    }
}