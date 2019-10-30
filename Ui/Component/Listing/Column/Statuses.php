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

use Magento\Ui\Component\Listing\Columns\Column;
use Encomage\Careers\Model\Careers\Source\Status;

/**
 * Class Statuses
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Ui\Component\Listing\Column
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Statuses extends Column
{
    /**
     * Prepare Data Source
     *
     * @param array $dataSource Data Sources
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item['status'] = $this->_renderHtml($item['status']);
            }
        }

        return $dataSource;
    }

    /**
     * Render Html
     *
     * @param string $value Value
     *
     * @return string
     */
    protected function _renderHtml($value)
    {
        switch ($value) {
        case Status::STATUS_ENABLED:
            return '<span class="grid-severity-notice" style="max-width: 100px">' . __('Enabled') . '</span>';

        case Status::STATUS_DISABLED:
            return '<span class="grid-severity-critical" style="max-width: 100px">' . __('Disabled') . '</span>';
        default:
            return '';
        }
    }
}