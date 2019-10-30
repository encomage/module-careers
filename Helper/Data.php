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

namespace Encomage\Careers\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Store\Model\StoreManagerInterface;
use Encomage\Careers\Api\CareersRepositoryInterface;
use Encomage\Careers\Api\Data\CareersInterface;
use Encomage\Careers\Model\Careers\Source\Status as ItemStatus;
use Encomage\Careers\Helper\Config as ConfigHelper;

/**
 * Class Data
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Helper
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Data extends AbstractHelper
{
    /**
     * Careers Interface
     *
     * @var CareersRepositoryInterface
     */
    protected $careersRepository;

    /**
     * Search Criteria
     *
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * Sort Order Builder
     *
     * @var SortOrderBuilder
     */
    protected $sortOrderBuilder;

    /**
     * Helper
     *
     * @var ConfigHelper
     */
    protected $_configHelper;

    /**
     * Store Manager
     *
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Careers Items
     *
     * @var $careersItems
     */
    protected $_careersItems;

    /**
     * Data constructor.
     *
     * @param Context                    $context               Context
     * @param CareersRepositoryInterface $careersRepository     Careers Interface
     * @param SearchCriteriaBuilder      $searchCriteriaBuilder Search Criteria
     * @param SortOrderBuilder           $sortOrderBuilder      Sort Order Builder
     * @param StoreManagerInterface      $storeManager          Store Manager
     * @param Config                     $configHelper          Helper
     */
    public function __construct(
        Context $context,
        CareersRepositoryInterface $careersRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        StoreManagerInterface $storeManager,
        ConfigHelper $configHelper
    ) {
        parent::__construct($context);
        $this->careersRepository = $careersRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->_storeManager = $storeManager;
        $this->_configHelper = $configHelper;
    }

    /**
     * Get Careers Items
     *
     * @param int $categoryId Category Id
     *
     * @return mixed
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCareersItems(int $categoryId = 0)
    {
        if (!$this->_careersItems) {
            $this->sortOrderBuilder->setField($this->_configHelper->getSortBy());
            $this->sortOrderBuilder->setDirection(
                $this->_configHelper
                    ->getSortOrder()
            );
            $sortOrder = $this->sortOrderBuilder->create();
            $this->searchCriteriaBuilder
                ->addFilter(CareersInterface::STATUS, ItemStatus::STATUS_ENABLED);
            $this->searchCriteriaBuilder->addFilter(
                CareersInterface::STORE_ID,
                $this->_storeManager->getStore()
            );
            if ($categoryId) {
                $this->searchCriteriaBuilder->addFilter(
                    CareersInterface::CATEGORY_ID,
                    $categoryId
                );
            }
            $this->searchCriteriaBuilder->addSortOrder($sortOrder);
            $searchCriteria = $this->searchCriteriaBuilder->create();
            /**
             * Careers Interface
             *
             * @var \Encomage\Careers\Api\CareersRepositoryInterface $careers
             */
            $searchResults = $this->careersRepository->getList($searchCriteria);
            $this->_careersItems = $searchResults->getItems();
        }

        return $this->_careersItems;
    }
}
