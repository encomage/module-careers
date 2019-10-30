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

namespace Encomage\Careers\Block\Careers\View;

use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Encomage\Careers\Helper\Url as UrlHelper;
use Encomage\Careers\Helper\Data as DataHelper;
use Magento\Framework\View\Element\Template;

/**
 * Class SwitchItem
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Block\Careers\View
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class SwitchItem extends Template
{
    /**
     * Registry
     *
     * @var Registry
     */
    protected $registry;

    /**
     * Helper Url
     *
     * @var UrlHelper
     */
    protected $_urlHelper;

    /**
     * Data Helper
     *
     * @var DataHelper
     */
    protected $_dataHelper;

    /**
     * SwitchItem constructor.
     *
     * @param Context    $context    Context
     * @param Registry   $registry   Registry
     * @param UrlHelper  $urlHelper  Helper Url
     * @param DataHelper $dataHelper Data Helper
     * @param array      $data       Data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        UrlHelper $urlHelper,
        DataHelper $dataHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->_urlHelper = $urlHelper;
        $this->_dataHelper = $dataHelper;
    }

    /**
     * Get Previous Item
     *
     * @return \Encomage\Careers\Model\Careers
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getPreviousItem()
    {
        $items = $this->_dataHelper->getCareersItems();
        while (key($items) !== $this->_getCurrentItem()->getItemId()) {
            next($items);
        }

        return prev($items);
    }

    /**
     * Get Current Item
     *
     * @return mixed|\Encomage\Careers\Model\Careers
     */
    protected function _getCurrentItem()
    {
        return $this->registry->registry('current_vacancy');
    }

    /**
     * Get Next Item
     *
     * @return \Encomage\Careers\Model\Careers
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getNextItem()
    {
        $items = $this->_dataHelper->getCareersItems();
        while (key($items) !== $this->_getCurrentItem()->getItemId()) {
            next($items);
        }

        return next($items);
    }

    /**
     * Get Careers Listing Url
     *
     * @return string
     */
    public function getCareersListingUrl()
    {
        return $this->_urlHelper->getCareersListUrl();
    }
}