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

namespace Encomage\Careers\Model;

use Encomage\Careers\Model\ResourceModel\Category as CareersCategory;
use Encomage\Careers\Api\Data\CategoryInterface;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Category
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Category extends AbstractModel implements CategoryInterface
{
//    /**
//     * Get Id
//     *
//     * @return int|mixed
//     */
//    public function getId()
//    {
//        return $this->getData(self::ID);
//    }
//
//    /**
//     * Set Id
//     *
//     * @param int|mixed $value
//     * @return Category|AbstractModel|mixed
//     */
//    public function setId($value)
//    {
//        return $this->setData(self::ID, $value);
//    }

    /**
     * Get Title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set Title
     *
     * @param string $title Title
     *
     * @return $this|mixed
     */
    public function setTitle(string $title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get Sort Order
     *
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }

    /**
     * Set Sort Order
     *
     * @param int $order Sort Order
     *
     * @return $this|mixed
     */
    public function setSortOrder(int $order)
    {
        return $this->setData(self::SORT_ORDER, $order);
    }

    /**
     * Construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(CareersCategory::class);
    }
}