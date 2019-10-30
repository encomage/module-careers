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

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Encomage\Careers\Api\CareersRepositoryInterface;

/**
 * Class InlineEdit
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Adminhtml\Index
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class InlineEdit extends Action
{
    /**
     * Json Factory
     *
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * Careers Interface
     *
     * @var CareersRepositoryInterface
     */
    private $careersRepository;

    /**
     * InlineEdit constructor.
     *
     * @param Action\Context             $context           Context
     * @param JsonFactory                $jsonFactory       Json Factory
     * @param CareersRepositoryInterface $careersRepository Careers Factory
     */
    public function __construct(
        Action\Context $context,
        JsonFactory $jsonFactory,
        CareersRepositoryInterface $careersRepository
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->careersRepository = $careersRepository;
        parent::__construct($context);
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /**
         * Json Result
         *
         * @var \Magento\Framework\Controller\Result\Json $resultJson
         */
        $resultJson = $this->jsonFactory->create();
        $params = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($params))) {
            return $resultJson->setData(
                [
                'messages' => [__('Please correct the data sent.')],
                'error'    => true,
                ]
            );
        }
        foreach ($params as $item) {
            $model = $this->careersRepository->getById($item['id']);
            $model->setData($item);
            $this->careersRepository->save($model);
        }

        return $resultJson->setData(
            [
            'messages' => [__('Saved')],
            'error'    => false,
            ]
        );
    }
}