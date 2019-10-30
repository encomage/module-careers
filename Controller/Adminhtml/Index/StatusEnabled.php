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
use Encomage\Careers\Model\Careers\Source\Status;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\App\Action;

/**
 * Class StatusEnabled
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Adminhtml\Index
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class StatusEnabled extends Action
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
     * MassDelete constructor.
     *
     * @param Context                    $context           Context
     * @param Filter                     $filter            Filter
     * @param CollectionFactory          $collectionFactory Collection Factory
     * @param CareersRepositoryInterface $careersRepository Careers Interface
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        CareersRepositoryInterface $careersRepository
    ) {
        $this->careersRepository = $careersRepository;
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
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
                /**
                 * Careers Interface
                 *
                 * \Encomage\Careers\Api\Data\CareersInterface $item
                 */
                $item = $this->careersRepository->getById($id);
                $item->setStatus(Status::STATUS_ENABLED);
                $this->careersRepository->save($item);
            }
            $this->messageManager
                ->addSuccessMessage(
                    __(
                        'A total of %1 element(s) have changed to \'Enabled\'.',
                        (int)$collectionSize
                    )
                );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(
                __('Error while trying to change status.')
            );
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/index');
    }
}