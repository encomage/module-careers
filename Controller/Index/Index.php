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

namespace Encomage\Careers\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Encomage\Careers\Helper\Config;
use Magento\Framework\App\Action\Action;

/**
 * Class Index
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Index
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Index extends Action
{
    /**
     * Helper
     *
     * @var Config
     */
    private $helperConfig;

    /**
     * Index constructor.
     *
     * @param Context $context      Context
     * @param Config  $helperConfig Helper
     */
    public function __construct(
        Context $context,
        Config $helperConfig
    ) {
        parent::__construct($context);
        $this->helperConfig = $helperConfig;
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        if ($this->helperConfig->isEnabledOnFront()) {
            $result = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            if ($this->helperConfig->getCareersPageMetaTitle()) {
                $result->getConfig()->getTitle()->set(
                    $this->helperConfig->getCareersPageMetaTitle()
                );
            }
            if ($this->helperConfig->getCareersPageMetaKeywords()) {
                $result->getConfig()->setKeywords(
                    $this->helperConfig->getCareersPageMetaKeywords()
                );
            }
            if ($this->helperConfig->getCareersPageMetaDescription()) {
                $result->getConfig()->setDescription(
                    $this->helperConfig->getCareersPageMetaDescription()
                );
            }

            if ($this->helperConfig->getCareersPageH1Title()) {
                $result->getLayout()->getBlock('page.main.title')
                    ->setPageTitle(
                        $this->helperConfig->getCareersPageH1Title()
                    );
            }
        } else {
            $this->messageManager->addWarningMessage(
                __('Enable this page:Stores->Configuration->Settings->Enable to Frontend.')
            );
            $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $result->setUrl(
                $this->_redirect->getRedirectUrl($this->helperConfig->getFrontendRouterLink())
            );
        }

        return $result;
    }
}
