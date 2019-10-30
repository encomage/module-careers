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

namespace Encomage\Careers\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface CategorySearchResultsInterface
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Api\Data
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
interface CategorySearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get items list.
     *
     * @return \Magento\Cms\Api\Data\BlockInterface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param \Magento\Cms\Api\Data\BlockInterface[] $items setItems
     *
     * @return $this
     */
    public function setItems(array $items);
}