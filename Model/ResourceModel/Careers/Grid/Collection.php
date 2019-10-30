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

namespace Encomage\Careers\Model\ResourceModel\Careers\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Encomage\Careers\Model\ResourceModel\Careers\Collection as CareersCollection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Class Collection
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\ResourceModel\Careers\Grid
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Collection extends CareersCollection implements SearchResultInterface
{
    /**
     * Aggregations Interface
     *
     * @var AggregationInterface
     */
    protected $aggregations;

    /**
     * Collection constructor.
     *
     * @param StoreManagerInterface  $storeManager  Store Manager
     * @param EntityFactoryInterface $entityFactory Entity Factory
     * @param LoggerInterface        $logger        Logger
     * @param FetchStrategyInterface $fetchStrategy Fetch Factory
     * @param ManagerInterface       $eventManager  Manager Interface
     * @param $mainTable
     * @param $resourceModel
     * @param string                 $model         Model
     * @param null                   $connection    Connection
     * @param AbstractDb|null        $resource      Resource
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = Document::class,
        $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
            $storeManager,
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    /**
     * Get Aggregations
     *
     * @return AggregationInterface
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * Set Aggregations
     *
     * @param AggregationInterface $aggregations Aggregations
     *
     * @return $this|void
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * Get Search Criteria
     *
     * @return \Magento\Framework\Api\Search\SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param SearchCriteriaInterface|null $searchCriteria Search Criteria
     *
     * @return $this
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * Set Total Count
     *
     * @param int $totalCount Totl Count
     *
     * @return $this|SearchResultInterface
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * Set Items
     *
     * @param array|null $items Items
     *
     * @return $this|SearchResultInterface
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
}