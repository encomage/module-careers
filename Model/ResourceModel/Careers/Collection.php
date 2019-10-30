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

namespace Encomage\Careers\Model\ResourceModel\Careers;

use Encomage\Careers\Model\Careers;
use Encomage\Careers\Model\ResourceModel\Careers as ResourceCareers;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Collection
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\ResourceModel\Careers
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Collection extends AbstractCollection
{
    /**
     * Field Name
     *
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Store Manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Collection constructor.
     *
     * @param StoreManagerInterface  $storeManager  Store Manager
     * @param EntityFactoryInterface $entityFactory Entity Factory
     * @param LoggerInterface        $logger        Logger
     * @param FetchStrategyInterface $fetchStrategy Strategy Interface
     * @param ManagerInterface       $eventManager  Manager Interface
     * @param AdapterInterface|null  $connection    Connection
     * @param AbstractDb|null        $resource      Resource
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
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
        $this->storeManager = $storeManager;
    }

    /**
     * Add Store Filter
     *
     * @param int|array|\Magento\Store\Model\Store $store                Store
     * @param bool                                 $includeAllStoreViews All Store Views
     *
     * @return $this
     */
    public function addStoreFilter($store, bool $includeAllStoreViews = true)
    {
        if ($store instanceof Store) {
            $store = [$store->getId()];
        }
        if (!is_array($store)) {
            $store = [$store];
        }
        if ($includeAllStoreViews) {
            $store[] = Store::DEFAULT_STORE_ID;
        }
        $this->addFilter('store_id', ['in' => $store], 'public');

        return $this;
    }

    /**
     * Construct
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Careers::class, ResourceCareers::class);
        $this->_map['fields']['item_id']  = 'main_table.id';
        $this->_map['fields']['store_id'] = 'encomage_careers_store.store_id';
    }

    /**
     * Render Filters
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store_id')) {
            $this->getSelect()->join(
                ['encomage_careers_store'
                 => $this->getTable('encomage_careers_store')],
                'main_table.id = encomage_careers_store.item_id',
                []
            )->group('main_table.id');
        }
        parent::_renderFiltersBefore();
    }

    /**
     * After Load
     *
     * @return AbstractCollection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _afterLoad()
    {
        $linkField = 'item_id';
        $tableName = 'encomage_careers_store';
        $linkedIds = $this->getColumnValues('id');
        if (count($linkedIds)) {
            $connection = $this->getConnection();
            $select = $connection->select()
                ->from(['ecs' => $this->getTable($tableName)])
                ->where('ecs.' . $linkField . ' IN (?)', $linkedIds);
            $result = $connection->fetchAll($select);
            if ($result) {
                $storesData = [];
                foreach ($result as $storeData) {
                    $storesData[$storeData[$linkField]][] = $storeData['store_id'];
                }

                foreach ($this as $item) {
                    $linkedId = $item->getData('id');
                    if (!isset($storesData[$linkedId])) {
                        continue;
                    }
                    $storeIdKey = array_search(
                        Store::DEFAULT_STORE_ID, $storesData[$linkedId],
                        true
                    );
                    if ($storeIdKey !== false) {
                        $stores = $this->storeManager->getStores(false, true);
                        $storeId = current($stores)->getId();
                        $storeCode = key($stores);
                    } else {
                        $storeId = current($storesData[$linkedId]);
                        $storeCode = $this->storeManager
                            ->getStore($storeId)->getCode();
                    }
                    $item->setData('_first_store_id', $storeId);
                    $item->setData('store_code', $storeCode);
                    $item->setData('store_id', $storesData[$linkedId]);
                }
            }
        }

        return parent::_afterLoad();
    }
}