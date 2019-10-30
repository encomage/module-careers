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

namespace Encomage\Careers\Ui\Component\Listing\Column;

use Magento\Store\Ui\Component\Listing\Column\Store\Options as StoreOptions;

/**
 * Class Options
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Ui\Component\Listing\Column
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Options extends StoreOptions
{
    /**
     * All Store Views value
     */
    const ALL_STORE_VIEWS = '0';

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        if ($this->options) {
            return $this->options;
        }
        $this->currentOptions['All Store Views'] = [
            'label' => __('All Store Views'),
            'value' => self::ALL_STORE_VIEWS,
        ];
        $this->generateCurrentOptions();
        $this->options = array_values($this->currentOptions);

        return $this->options;
    }
}