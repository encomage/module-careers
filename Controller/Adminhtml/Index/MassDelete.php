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

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Encomage\Careers\Model\ResourceModel\Careers\CollectionFactory;
use Encomage\Careers\Api\CareersRepositoryInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\App\Cache\StateInterface;
use Magento\Framework\App\Cache\TypeListInterface;

/**
 * Class MassDelete
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Adminhtml\Index
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class MassDelete extends \Magento\Backend\App\Action
{
    /**
     * Filter
     *
     * @var Filter
     */
    private $filter;

    /**
     * Collection Factory
     *
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Careers Interface
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
     * MassDelete constructor.
     *
     * @param Context                    $context           Context
     * @param Filter                     $filter            Filter
     * @param CollectionFactory          $collectionFactory Collection Factory
     * @param CareersRepositoryInterface $careersRepository Careers Interface
     * @param StateInterface             $stateCache        State Interface
     * @param TypeListInterface          $typeList          Type List
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        CareersRepositoryInterface $careersRepository,
        StateInterface $stateCache,
        TypeListInterface $typeList
    ) {
        $this->careersRepository = $careersRepository;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->stateCache = $stateCache;
        $this->typeList = $typeList;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws LocalizedException
     */
    public function execute()
    {
        $collection = $this->filter
            ->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        try {
            foreach ($collection->getAllIds() as $id) {
                $this->careersRepository->deleteById($id);
            }
            $this->_invalidateCache();
            $this->messageManager
                ->addSuccessMessage(
                    __(
                        'A total of %1 element(s) have been deleted.',
                        (int)$collectionSize
                    )
                );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('Error while trying to delete item(s).')
            );
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

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