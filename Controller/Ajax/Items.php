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

use Encomage\Careers\Api\CategoryRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Encomage\Careers\Helper\Config;
use Magento\Framework\App\Action\Action;

/**
 * Class Items
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Controller\Ajax
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Items extends Action
{
    /**
     * Careers Repository
     *
     * @var CategoryRepositoryInterface
     */
    private $careersCategoryRepository;

    /**
     * Helper
     *
     * @var Config
     */
    private $configHelper;

    /**
     * Items constructor.
     *
     * @param Context                     $context            Context
     * @param CategoryRepositoryInterface $categoryRepository Careers Interface
     * @param Config                      $configHelper       Helper
     */
    public function __construct(
        Context $context,
        CategoryRepositoryInterface $categoryRepository,
        Config $configHelper
    ) {
        parent::__construct($context);
        $this->careersCategoryRepository = $categoryRepository;
        $this->configHelper = $configHelper;
    }

    /**
     * Execute
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $careersCategoryId = (int)$this->getRequest()->getParam('id', 0);
        try {
            /**
             * Items Block
             *
             * @var \Encomage\Careers\Block\Careers\CareersList\Items $itemsBlock
             */
            $itemsBlock = $this->_view->getLayout()
                ->createBlock('Encomage\Careers\Block\Careers\CareersList\Items');
            $itemsBlock->setCareersCategoryId($careersCategoryId);
            $html = trim($itemsBlock->toHtml());
            if (!empty($html)) {
                $response['html'] = $html;
                $response['title'] = $this->configHelper->getCareersPageH1Title();
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = __($e->getMessage());
        }

        return $resultJson->setData($response);
    }
}
