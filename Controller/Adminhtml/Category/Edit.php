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

namespace Encomage\Careers\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Create
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Adminhtml\Category
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Edit extends Action
{
    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Encomage_Careers::careers_category');
        $resultPage->getConfig()->getTitle()->prepend((__('Edit')));

        return $resultPage;
    }
}