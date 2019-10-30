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

use Encomage\Careers\Helper\Config;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

/**
 * Class Content
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Block\Careers\View
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Content extends Template
{
    /**
     * Registry
     *
     * @var Registry
     */
    protected $registry;

    /**
     * Template Processor
     *
     * @var \Zend_Filter_Interface
     */
    protected $templateProcessor;

    /**
     * Helper
     *
     * @var Config
     */
    protected $configHelper;

    /**
     * Content constructor.
     *
     * @param Context                $context           Context
     * @param Registry               $registry          Registry
     * @param \Zend_Filter_Interface $templateProcessor Template Processor
     * @param Config                 $config            Config
     * @param array                  $data              Data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        \Zend_Filter_Interface $templateProcessor,
        Config $config,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->registry = $registry;
        $this->configHelper = $config;
        $this->templateProcessor = $templateProcessor;
    }

    /**
     * Get Content
     *
     * @return mixed
     *
     * @throws \Zend_Filter_Exception
     */
    public function getContent()
    {
        return $this->_filterOutputHtml($this->_getItem()->getContent());
    }

    /**
     * Output Html Filter
     *
     * @param string $content Content
     *
     * @return mixed
     *
     * @throws \Zend_Filter_Exception
     */
    protected function _filterOutputHtml($content)
    {
        return $this->templateProcessor->filter($content);
    }

    /**
     * Get Item
     *
     * @return mixed|\Encomage\Careers\Api\Data\CareersInterface
     */
    protected function _getItem()
    {
        return $this->registry->registry('current_vacancy');
    }

    /**
     * Get Share Html Code
     *
     * @return mixed
     *
     * @throws \Zend_Filter_Exception
     */
    public function getShareToAnyCodeHtml()
    {
        return $this->_filterOutputHtml($this->configHelper->getShareToAnyCode());
    }

    /**
     * Prepare Layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set($this->getTitle());
        if ($this->_getItem()->getMetaDescription()) {
            $this->pageConfig
                ->setDescription($this->_getItem()->getMetaDescription());
        } else {
            $this->pageConfig->setDescription($this->getTitle());
        }
        if ($this->_getItem()->getMetaKeywords()) {
            $this->pageConfig->setKeywords($this->_getItem()->getMetaKeywords());
        }
        if ($this->_getItem()->getMetaTitle()) {
            $this->pageConfig->getTitle()->set($this->_getItem()->getMetaTitle());
        }

        return parent::_prepareLayout();
    }

    /**
     * Get Title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->_getItem()->getTitle();
    }
}
