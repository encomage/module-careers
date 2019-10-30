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

namespace Encomage\Careers\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Category
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\ResourceModel
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Category extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('encomage_careers_category', 'id');
    }
}