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

use Encomage\Careers\Model\CareersFactory;
use Encomage\Careers\Api\CategoryRepositoryInterface;
use Magento\Backend\App\Action;

/**
 * Class Delete
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Adminhtml\Category
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Delete extends Action
{
    /**
     * Careers Factory
     *
     * @var CareersFactory
     */
    private $careersFactory;

    /**
     * Category Repository Interface
     *
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * Delete constructor.
     *
     * @param Action\Context              $context            Context
     * @param CareersFactory              $careersFactory     Careers Factory
     * @param CategoryRepositoryInterface $categoryRepository Category Repository
     */
    public function __construct(
        Action\Context $context,
        careersFactory $careersFactory,
        categoryRepositoryInterface $categoryRepository
    ) {
        parent::__construct($context);
        $this->careersFactory = $careersFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id', 0);
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $this->categoryRepository->deleteById($id);
                $this->messageManager->addSuccessMessage(
                    __('Removed successfully.')
                );
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__($e->getMessage()));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Id doesn\'t exist.'));
        }

        return $resultRedirect->setPath('*/*/index');
    }
}