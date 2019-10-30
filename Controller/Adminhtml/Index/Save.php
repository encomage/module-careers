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
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Adminhtml\Index
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Save extends Action
{
    /**
     * Careers Factory
     *
     * @var CareersFactory
     */
    private $careersFactory;

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
    private $cacheState;

    /**
     * Type List
     *
     * @var TypeListInterface
     */
    private $typeList;

    /**
     * Data Persistor
     *
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * Save constructor.
     *
     * @param Action\Context             $context           Context
     * @param CareersRepositoryInterface $careersRepository Careers Interface
     * @param CareersFactory             $careersFactory    Careers Factory
     * @param TypeListInterface          $typeList          Type List
     * @param StateInterface             $cacheState        State Interface
     * @param DataPersistorInterface     $dataPersistor     Data Persistor
     */
    public function __construct(
        Action\Context $context,
        CareersRepositoryInterface $careersRepository,
        CareersFactory $careersFactory,
        TypeListInterface $typeList,
        StateInterface $cacheState,
        DataPersistorInterface $dataPersistor
    ) {
        $this->careersFactory = $careersFactory;
        $this->careersRepository = $careersRepository;
        $this->cacheState = $cacheState;
        $this->typeList = $typeList;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getPostValue();
        if (!empty($params)) {
            $id = (int)$this->getRequest()->getParam('id', 0);
            if ($id) {
                $model = $this->careersRepository->getById($id);
            } else {
                $model = $this->careersFactory->create();
                unset($params['id']);
            }
            $model->setData($params);
            try {
                $this->careersRepository->save($model);
                $this->invalidateCache();
                $this->messageManager->addSuccessMessage(__('Saved successfully.'));
                $this->dataPersistor->clear('careers_item');
                $param = $this->getRequest()->getParam('back');
                if (!$param) {
                    return $resultRedirect->setPath('*/*/');
                }
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving the page.')
                );
            }
            $this->dataPersistor->set('careers_item', $params);
            $redirectParams = ($id) ? ['id' => $id] : [];

            return $resultRedirect->setPath('*/*/edit', $redirectParams);
        }

        return $resultRedirect->setPath('*/*/index');
    }

    /**
     * Invalidate Cache
     *
     * @return $this
     */
    protected function invalidateCache()
    {
        if ($this->cacheState->isEnabled(\Magento\PageCache\Model\Cache\Type::TYPE_IDENTIFIER)) {
            $this->typeList->invalidate([\Magento\PageCache\Model\Cache\Type::TYPE_IDENTIFIER]);
        }
        if ($this->cacheState->isEnabled(\Magento\Framework\App\Cache\Type\Block::TYPE_IDENTIFIER)) {
            $this->typeList->invalidate([\Magento\Framework\App\Cache\Type\Block::TYPE_IDENTIFIER]);
        }

        return $this;
    }
}