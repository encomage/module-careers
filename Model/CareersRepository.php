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

use Encomage\Careers\Api\CareersRepositoryInterface;
use Encomage\Careers\Api\Data\CareersInterface;
use Encomage\Careers\Model\ResourceModel\Careers as ResourceCareers;
use Encomage\Careers\Model\CareersFactory;
use Encomage\Careers\Model\ResourceModel\Careers\CollectionFactory as CareersCollectionFactory;
use Encomage\Careers\Api\Data\CareersSearchResultsInterfaceFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class CareersRepository
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class CareersRepository implements CareersRepositoryInterface
{
    /**
     * Resource
     *
     * @var ResourceCareers
     */
    private $resource;

    /**
     * Careers Factory
     *
     * @var \Encomage\Careers\Model\CareersFactory
     */
    private $careersFactory;

    /**
     * Collection Factory
     *
     * @var CareersCollectionFactory
     */
    private $collectionFactory;

    /**
     * Collection Processor
     *
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * Search Result
     *
     * @var CareersSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * Store Manager
     *
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * CareersRepository constructor.
     *
     * @param StoreManagerInterface $storeManager Store Manager
     * @param ResourceCareers $resourceCareers Resources
     * @param CareersCollectionFactory $collectionFactory Collection Factory
     * @param CollectionProcessorInterface $collectionProcessor Collection Processor
     * @param CareersSearchResultsInterfaceFactory $searchResultsFactory Search Result
     * @param \Encomage\Careers\Model\CareersFactory $careersFactory Careers Factory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ResourceCareers $resourceCareers,
        CareersCollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        CareersSearchResultsInterfaceFactory $searchResultsFactory,
        CareersFactory $careersFactory
    ) {
        $this->resource = $resourceCareers;
        $this->storeManager = $storeManager;
        $this->careersFactory = $careersFactory;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;

    }

    /**
     * Save
     *
     * @param CareersInterface $item Careers Interface
     * @return CareersInterface|mixed
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function save(CareersInterface $item)
    {
        if (empty($item->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $item->setStoreId($storeId);
        }
        try {
            $this->resource->save($item);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $item;
    }

    /**
     * Get By Identifier
     *
     * @param string $identifier Identifier
     *
     * @return mixed
     * @throws NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getByIdentifier($identifier)
    {
        $id = $this->resource->getIdByIdentifier($identifier);
        if (!$id) {
            throw new NoSuchEntityException(__(/** @lang text */
                'Identifierd "%1" does not exist.', $identifier));
        }
        $item = $this->getById($id);

        return $item;
    }

    /**
     * @param int $itemId Item Id
     *
     * @return mixed
     * @throws NoSuchEntityException
     */
    public function getById($itemId)
    {
        $item = $this->careersFactory->create();
        $this->resource->load($item, $itemId);
        if (!$item->getId()) {
            throw new NoSuchEntityException(__(/** @lang text */
                'Item id "%1" does not exist.', $itemId));
        }

        return $item;
    }

    /**
     * Get List
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Encomage\Careers\Api\Data\CareersSearchResultsInterface|mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /**
         * Collection
         *
         * @var \Encomage\Careers\Model\ResourceModel\Careers\Collection $collection
         */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /**
         * Search Result
         *
         * @var \Encomage\Careers\Api\Data\CareersSearchResultsInterface $searchResults
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
     * @param int $itemId
     *
     * @return bool|mixed
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($itemId)
    {
        return $this->delete($this->getById($itemId));
    }

    /**
     * Delete
     *
     * @param CareersInterface $item
     *
     * @return bool|mixed
     * @throws CouldNotDeleteException
     */
    public function delete(CareersInterface $item)
    {
        try {
            $this->resource->delete($item);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }
}