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

namespace Encomage\Careers\Controller\Ajax;

use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;

/**
 * Class Category
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Ajax
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Category extends Action
{
    /**
     * Redirect Factory
     *
     * @var RedirectFactory
     */
    private $_redirectFactory;

    /**
     * Listing constructor.
     *
     * @param Context         $context         Context
     * @param RedirectFactory $redirectFactory Redirect Factory
     */
    public function __construct(
        Context $context,
        RedirectFactory $redirectFactory
    ) {
        parent::__construct($context);
        $this->_redirectFactory = $redirectFactory;
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        if (!$this->getRequest()->isAjax()) {
            $this->messageManager->addErrorMessage(__('Incorrect Params.'));

            /**
             * Redirect Interface
             *
             * @var \Magento\Framework\Controller\ResultInterface $resultRedirect
             */
            $resultRedirect = $this->_redirectFactory->create();

            return $resultRedirect->setRefererUrl();
        }

        $categoryBlock = $this->_view->getLayout()
            ->createBlock(\Encomage\Careers\Block\Careers\CareersList\Categories::class);
        $categoryCollection = $categoryBlock->getLoadedCareersCategories();

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        if (count($categoryCollection)) {
            $block = $this->_view->getLayout()
                ->createBlock(\Magento\Framework\View\Element\Template::class)
                ->setTemplate('Encomage_Careers::list/categories-buttons.phtml');
            $html = $block->toHtml();
            foreach ($categoryCollection as $item) {
                $html .= $block->setItem($item)->toHtml();
            }

            return $resultJson->setData(['success' => true, 'html' => $html]);
        }

        return $resultJson->setData(['success' => false]);
    }
}