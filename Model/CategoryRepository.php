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

namespace Encomage\Careers\Model;

use Encomage\Careers\Api\CategoryRepositoryInterface;
use Encomage\Careers\Api\Data;
use Encomage\Careers\Model\CategoryFactory as CareersCategoryFactory;
use Encomage\Careers\Model\ResourceModel\Category as ResourceCareersCategory;
use Encomage\Careers\Model\ResourceModel\Category\CollectionFactory;
use Encomage\Careers\Api\Data\CategorySearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class CategoryRepository
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Category Factory
     *
     * @var CategoryFactory
     */
    private $careersCategoryFactory;

    /**
     * Resource Category
     *
     * @var ResourceCareersCategory
     */
    private $careersCategoryResource;

    /**
     * Collection Factory
     *
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * Processor Interface
     *
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * Result Interface
     *
     * @var CategorySearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * CategoryRepository constructor.
     *
     * @param CategoryFactory                       $categoryFactory                       Category Interface
     * @param ResourceCareersCategory               $categoryCareersResource               Category Resource
     * @param CollectionFactory                     $collectionFactory                     Collection Factory
     * @param CollectionProcessorInterface          $collectionProcessor                   Collection Processor
     * @param CategorySearchResultsInterfaceFactory $categorySearchResultsInterfaceFactory Result Interface
     */
    public function __construct(
        CareersCategoryFactory $categoryFactory,
        ResourceCareersCategory $categoryCareersResource,
        CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        CategorySearchResultsInterfaceFactory $categorySearchResultsInterfaceFactory
    ) {
        $this->careersCategoryFactory = $categoryFactory;
        $this->careersCategoryResource = $categoryCareersResource;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $categorySearchResultsInterfaceFactory;
    }

    /**
     * Save
     *
     * @param Data\CategoryInterface $item Category Interface
     *
     * @return Data\CategoryInterface|mixed
     * @throws CouldNotSaveException
     */
    public function save(Data\CategoryInterface $item)
    {
        try {
            $this->careersCategoryResource->save($item);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $item;
    }

    /**
     * Get List
     *
     * @param SearchCriteriaInterface $searchCriteria Search Criteria
     *
     * @return Data\CategorySearchResultsInterface|mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /**
         * Collection
         *
         * @var \Encomage\Careers\Model\ResourceModel\Category\Collection $collection
         */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /**
         * Search Result
         *
         * @var \Encomage\Careers\Api\Data\CategorySearchResultsInterface $searchResults
         */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * Delete By Id
     *
     * @param int $entityId Entity Id
     *
     * @return bool|mixed
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($entityId)
    {
        return $this->delete($this->getById($entityId));
    }

    /**
     * Delete
     *
     * @param Data\CategoryInterface $item Category Interface
     *
     * @return bool|mixed
     * @throws CouldNotDeleteException
     */
    public function delete(Data\CategoryInterface $item)
    {
        try {
            $this->careersCategoryResource->delete($item);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * Get By Id
     *
     * @param int $entityId Entity Id
     *
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($entityId)
    {
        $item = $this->careersCategoryFactory->create();
        $this->careersCategoryResource->load($item, $entityId);
        if (!$item->getId()) {
            throw new NoSuchEntityException(__('Category id "%1" does not exist.', $entityId));
        }

        return $item;
    }
}