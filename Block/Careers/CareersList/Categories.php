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

namespace Encomage\Careers\Block\Careers\CareersList;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Encomage\Careers\Api\CategoryRepositoryInterface;
use Encomage\Careers\Api\CareersRepositoryInterfaceFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Encomage\Careers\Api\Data\CareersInterface;
use Encomage\Careers\Api\Data\CategoryInterface;
use Encomage\Careers\Helper\Config;

/**
 * Class Categories
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Block\Careers\CareersList
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Categories extends Template
{
    /**
     * Category Interface
     *
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepositoryInterface;

    /**
     * Careers Repository Interface
     *
     * @var CareersRepositoryInterfaceFactory
     */
    protected $careersRepositoryInterfaceFactory;

    /**
     * Load Categories
     *
     * @var null 
     */
    protected $loadedCategories = null;

    /**
     * Sort Order Builder
     *
     * @var SortOrderBuilder 
     */
    protected $sortOrderBuilder;

    /**
     * Search Criteria Builder
     *
     * @var SearchCriteriaBuilder 
     */
    protected $searchCriteriaBuilder;

    /**
     * Items Block Name
     *
     * @var string 
     */
    protected $itemsBlockName = 'careers.list.categories.items';

    /**
     * Json
     *
     * @var Json 
     */
    protected $json;

    /**
     * Helper
     *
     * @var Config
     */
    private $configHelper;

    /**
     * Categories constructor.
     *
     * @param Template\Context                  $context                           Context
     * @param CategoryRepositoryInterface       $categoryRepositoryInterface       Category Interface
     * @param CareersRepositoryInterfaceFactory $careersRepositoryInterfaceFactory Careers Interface
     * @param SearchCriteriaBuilder             $searchCriteriaBuilder             Search Criteria
     * @param SortOrderBuilder                  $sortOrderBuilder                  Sort Order
     * @param Json                              $json                              Json
     * @param Config                            $configHelper                      Helper
     * @param array                             $data                              Data
     */
    public function __construct(
        Template\Context $context,
        CategoryRepositoryInterface $categoryRepositoryInterface,
        CareersRepositoryInterfaceFactory $careersRepositoryInterfaceFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        Json $json,
        Config $configHelper,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
        $this->careersRepositoryInterfaceFactory = $careersRepositoryInterfaceFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->json = $json;
        $this->configHelper = $configHelper;
    }

    /**
     * Get Loaded Careers Categories
     *
     * @return mixed
     */
    public function getLoadedCareersCategories()
    {
        if ($this->loadedCategories === null) {
            $this->loadedCategories = $this->_loadCategories();
        }

        return $this->loadedCategories;
    }

    /**
     * Load Categories
     *
     * @return mixed
     */
    protected function _loadCategories()
    {
        $this->sortOrderBuilder->setField(CategoryInterface::SORT_ORDER);
        $this->sortOrderBuilder->setAscendingDirection();
        $sortOrder = $this->sortOrderBuilder->create();

        $this->searchCriteriaBuilder->addSortOrder($sortOrder);
        $this->searchCriteriaBuilder->addFilter(
            CareersInterface::STATUS,
            \Encomage\Careers\Model\Careers\Source\Status::STATUS_ENABLED
        );
        $searchCriteria = $this->searchCriteriaBuilder->create();

        $categoryCollection = $this->categoryRepositoryInterface
            ->getList($searchCriteria)
            ->getItems();
        foreach ($categoryCollection as $key => $item) {
            $this->searchCriteriaBuilder->addFilter(CareersInterface::CATEGORY_ID, $item->getId());
            $this->searchCriteriaBuilder->addFilter(
                CareersInterface::STATUS,
                \Encomage\Careers\Model\Careers\Source\Status::STATUS_ENABLED
            );
            $searchCriteria = $this->searchCriteriaBuilder->create();
            $careersRepository = $this->careersRepositoryInterfaceFactory->create();
            $vacancyCollection = $careersRepository->getList($searchCriteria)->getItems();

            if (!count($vacancyCollection)) {
                $categoryCollection = array_diff_key($categoryCollection, [$key => '']);
            }
        }

        return $categoryCollection;
    }

    /**
     * Get Items Html
     *
     * @return string
     */
    public function getItemsHtml()
    {
        return $this->getChildHtml($this->itemsBlockName);
    }

    /**
     * Get JS Config
     *
     * @return string
     */
    public function getJsConfig()
    {
        return $this->json->serialize(
            [
                'ajaxItemsUrl'    => $this->_getAjaxItemsUrl(),
                'ajaxCategoryUrl' => $this->_getAjaxCategoryUrl(),
            ]
        );
    }

    /**
     * Get Ajax Items Url
     *
     * @return string
     */
    protected function _getAjaxItemsUrl()
    {
        return $this->getUrl('careers/ajax/items');
    }

    /**
     * Get Ajax Category Url
     *
     * @return string
     */
    protected function _getAjaxCategoryUrl()
    {
        return $this->getUrl('careers/ajax/category');
    }

    /**
     * Get Text Empty Vacancy Page
     *
     * @return mixed
     */
    public function getTextEmptyVacancyPage()
    {
        return $this->configHelper->getTextEmptyVacancyPage();
    }

    /**
     * Prepare Layout
     *
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        /**
         * Items Block
         *
         * @var \Encomage\Careers\Block\Careers\CareersList\Items $itemsBlock
         */
        $itemsBlock = $this->getLayout()->getBlock($this->itemsBlockName);
        if ($itemsBlock) {
            $itemsBlock->setCategoriesBlock($this);
        }

        return $this;
    }
}