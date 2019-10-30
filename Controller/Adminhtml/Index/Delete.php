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

namespace Encomage\Careers\Controller\Adminhtml\Index;

use Encomage\Careers\Model\CareersFactory;
use Encomage\Careers\Api\CareersRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\Cache\StateInterface;
use Magento\Framework\App\Cache\TypeListInterface;

/**
 * Class Delete
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Adminhtml\Index
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
     * Careers Repository
     *
     * @var CareersRepositoryInterface
     */
    private $careersRepository;

    /**
     * State Interface
     *
     * @var StateInterface
     */
    private $stateCache;

    /**
     * Type List
     *
     * @var TypeListInterface
     */
    private $typeList;

    /**
     * Delete constructor.
     *
     * @param Action\Context $context Context
     * @param CareersFactory $careers Careers
     * @param CareersRepositoryInterface $careersRepository Careers Repository
     * @param StateInterface $stateCache State Interface
     * @param TypeListInterface $typeList Type List
     */
    public function __construct(
        Action\Context $context,
        CareersFactory $careers,
        CareersRepositoryInterface $careersRepository,
        StateInterface $stateCache,
        TypeListInterface $typeList
    ) {
        $this->careersRepository = $careersRepository;
        $this->careersFactory = $careers;
        $this->stateCache = $stateCache;
        $this->typeList = $typeList;
        parent::__construct($context);
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
                $this->careersRepository->deleteById($id);
                $this->_invalidateCache();
                $this->messageManager->addSuccessMessage(__('Removed successfully.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Error while trying to delete item.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Error while trying to delete item.'));
        }

        return $resultRedirect->setPath('*/*/index');
    }

    /**
     * Invalidate Cache
     *
     * @return $this
     */
    protected function _invalidateCache()
    {
        if ($this->stateCache->isEnabled(\Magento\PageCache\Model\Cache\Type::TYPE_IDENTIFIER)) {
            $this->typeList->invalidate([\Magento\PageCache\Model\Cache\Type::TYPE_IDENTIFIER]);
        }
        if ($this->stateCache->isEnabled(\Magento\Framework\App\Cache\Type\Block::TYPE_IDENTIFIER)) {
            $this->typeList->invalidate([\Magento\Framework\App\Cache\Type\Block::TYPE_IDENTIFIER]);
        }

        return $this;
    }
}