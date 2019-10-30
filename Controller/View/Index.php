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

namespace Encomage\Careers\Controller\View;

use Encomage\Careers\Helper\Url;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use Encomage\Careers\Api\CareersRepositoryInterface;
use Encomage\Careers\Model\Careers\Source\Status as ItemStatus;
use Encomage\Careers\Helper\Url as UrlHelper;
use Magento\Framework\App\Action\Action;

/**
 * Class Index
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\View
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Index extends Action
{
    /**
     * Registry
     *
     * @var Registry
     */
    private $registry;

    /**
     * Careers Interface
     *
     * @var CareersRepositoryInterface
     */
    private $careersRepository;

    /**
     * Url Helper
     *
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * Index constructor.
     *
     * @param Context                    $context           Context
     * @param CareersRepositoryInterface $careersRepository Careers Interface
     * @param Registry                   $registry          Registry
     * @param UrlHelper                  $url               Url Helper
     */
    public function __construct(
        Context $context,
        CareersRepositoryInterface $careersRepository,
        Registry $registry,
        UrlHelper $url
    ) {
        parent::__construct($context);
        $this->urlHelper = $url;
        $this->registry = $registry;
        $this->careersRepository = $careersRepository;
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('id', 0);
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        if (!$id) {
            $this->messageManager->addErrorMessage(__('Params error.'));

            return $resultRedirect->setUrl($this->urlHelper->getCareersListUrl());
        }
        /**
         * Careers Interface
         *
         * @var \Encomage\Careers\Api\Data\CareersInterface $item
         */
        $item = $this->careersRepository->getById($id);
        if (!$item->getId()) {
            $this->messageManager->addNoticeMessage(__('Vacancy wasn\'t found.'));

            return $resultRedirect->setUrl($this->urlHelper->getCareersListUrl());
        }
        if ($item->getStatus() == ItemStatus::STATUS_DISABLED) {
            $this->messageManager->addNoticeMessage(__('Vacancy is not actual.'));

            return $resultRedirect->setUrl($this->urlHelper->getCareersListUrl());
        }
        $this->registry->register('current_vacancy', $item);

        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
