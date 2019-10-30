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

use Encomage\Careers\Model\CategoryFactory;
use Encomage\Careers\Api\CategoryRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\App\Cache\StateInterface;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class Save
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Adminhtml\Category
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Save extends Action
{
    /**
     * Category Factory
     *
     * @var CategoryFactory
     */
    private $careersCategoryFactory;

    /**
     * Category Repository
     *
     * @var CategoryRepositoryInterface
     */
    private $careersCategoryRepository;

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
     * @param Action\Context              $context           Context
     * @param CategoryRepositoryInterface $careersRepository Careers Repository
     * @param CategoryFactory             $careersFactory    Careers Factory
     * @param TypeListInterface           $typeList          Type List
     * @param StateInterface              $cacheState        State Interface
     * @param DataPersistorInterface      $dataPersistor     Data Persistor
     */
    public function __construct(
        Action\Context $context,
        CategoryRepositoryInterface $careersRepository,
        CategoryFactory $careersFactory,
        TypeListInterface $typeList,
        StateInterface $cacheState,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->careersCategoryFactory = $careersFactory;
        $this->careersCategoryRepository = $careersRepository;
        $this->cacheState = $cacheState;
        $this->typeList = $typeList;
        $this->dataPersistor = $dataPersistor;
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
                $model = $this->careersCategoryRepository->getById($id);
            } else {
                $model = $this->careersCategoryFactory->create();
                unset($params['id']);
            }
            $model->setData($params);
            try {
                $this->careersCategoryRepository->save($model);
                $this->messageManager->addSuccessMessage(__('Saved successfully.'));
                $this->dataPersistor->clear('careers_category_item');

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?: $e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage(
                    $e,
                    __('Something went wrong while saving.')
                );
            }
            $this->dataPersistor->set('careers_category_item', $params);
            $redirectParams = ($id) ? ['id' => $id] : [];

            return $resultRedirect->setPath('*/*/edit', $redirectParams);
        }

        return $resultRedirect->setPath('*/*/index');
    }
}