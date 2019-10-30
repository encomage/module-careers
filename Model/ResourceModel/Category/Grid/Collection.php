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

namespace Encomage\Careers\Model\ResourceModel\Category\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Encomage\Careers\Model\ResourceModel\Category\Collection as CareersCategoryCollection;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Psr\Log\LoggerInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Class Collection
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\ResourceModel\Category\Grid
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Collection extends CareersCategoryCollection implements SearchResultInterface
{
    /**
     * Aggregations
     *
     * @var AggregationInterface
     */
    protected $aggregations;

    /**
     * Collection constructor.
     *
     * @param EntityFactoryInterface $entityFactory Entity Interface
     * @param LoggerInterface        $logger        Logger
     * @param FetchStrategyInterface $fetchStrategy Strategy Interface
     * @param ManagerInterface       $eventManager  Manager Interface
     * @param $mainTable
     * @param $resourceModel
     * @param string                 $model         Model
     * @param null                   $connection    Connection
     * @param AbstractDb|null        $resource      Resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        $mainTable,
        $resourceModel,
        $model = Document::class,
        $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
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
     * @param AggregationInterface $aggregations Aggregations Interface
     *
     * @return $this|void
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * Get search criteria.
     *
     * @return \Magento\Framework\Api\SearchCriteriaInterface|null
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
     * @param int $totalCount Total Count
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