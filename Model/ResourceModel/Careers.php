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

namespace Encomage\Careers\Model\ResourceModel;

use Encomage\Careers\Api\Data\CareersInterface;
use Encomage\Careers\Helper\Config;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\Store;
use \Zend_Db_Select as Select;

/**
 * Class Careers
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Model\ResourceModel
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class Careers extends AbstractDb
{
    /**
     * Helper
     *
     * @var Config
     */
    protected $configHelper;

    /**
     * Careers constructor.
     *
     * @param Config      $config         Config
     * @param Context     $context        Context
     * @param string|null $connectionName Connection Name
     */
    public function __construct(
        Config $config,
        Context $context,
        string $connectionName = null
    ) {
        $this->configHelper = $config;
        parent::__construct($context, $connectionName);
    }

    /**
     * Add Store Filter To Load Select
     *
     * @param Select $select   Select
     * @param array  $storeIds Store Ids
     *
     * @return Select
     * @throws LocalizedException
     */
    protected function _addStoreFilterToLoadSelect(Select $select, array $storeIds)
    {
        $select->join(
            ['ecs' => $this->getTable('encomage_careers_store')],
            $this->getMainTable() . '.' . $this->getIdFieldName() . ' = ecs.item_id',
            []
        )
            ->where('ecs.store_id IN (?)', $storeIds)
            ->order('ecs.store_id DESC')
            ->limit(1);

        return $select;
    }

    /**
     * Get Id By Position
     *
     * @param int $position Position
     *
     * @return string
     * @throws LocalizedException
     */
    public function getIdByPosition($position)
    {
        $select = $this->getConnection()
            ->select()
            ->from(
                $this->getMainTable(),
                [$this->getIdFieldName(),
                CareersInterface::POSITION]
            )
            ->where(CareersInterface::POSITION . ' =?', $position);

        return $this->getConnection()->fetchOne($select);
    }

    /**
     * Class construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('encomage_careers', 'id');
    }

    /**
     * Get Load Select
     *
     * @param string        $field  Field
     * @param mixed         $value  Value
     * @param AbstractModel $object Abstract Model
     *
     * @return \Magento\Framework\DB\Select|Select
     * @throws LocalizedException
     */
    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        if ($object->getStoreId()) {
            $select = $this->_addStoreFilterToLoadSelect(
                $select,
                [
                    Store::DEFAULT_STORE_ID,
                    (int)$object->getStoreId(),
                ]
            );
        }

        return $select;
    }

    /**
     * Before Save
     *
     * @param AbstractModel $object Abstract Model
     *
     * @return AbstractDb|void
     * @throws AlreadyExistsException
     * @throws LocalizedException
     */
    protected function _beforeSave(AbstractModel $object)
    {
        if (!$object->getIdentifier()) {
            $object->setIdentifier(
                strtolower(
                    str_replace(
                        ' ', '-',
                        $object->getTitle()
                    )
                )
            );
        }
        if ($object->isObjectNew()) {
            $id = $this->getIdByIdentifier($object->getIdentifier());
            if ($id) {
                throw new AlreadyExistsException(
                    __(
                        'Item with "%1" identifier already exist.',
                        $object->getIdentifier()
                    )
                );
            }
        }
        if ($object->getIdentifier() ==$this->configHelper->getFrontendRouterLink()
        ) {
            throw new AlreadyExistsException(
                __(
                    'This url key "%1" used for listing router.',
                    $object->getIdentifier()
                )
            );
        }
        if (!$this->isValidIdentifier($object)) {
            throw new LocalizedException(
                __('The URL key contains capital letters or disallowed symbols.')
            );
        }

        if ($this->isNumericIdentifier($object)) {
            throw new LocalizedException(
                __('The URL key cannot be made of only numbers.')
            );
        }
        parent::_beforeSave($object);
    }

    /**
     * Get Id By Identifier
     *
     * @param string $identifier Identifier
     *
     * @return string
     *
     * @throws LocalizedException
     */
    public function getIdByIdentifier($identifier)
    {
        $select = $this->getConnection()
            ->select()
            ->from(
                $this->getMainTable(),
                [$this->getIdFieldName(),
                CareersInterface::IDENTIFIER]
            )
            ->where(CareersInterface::IDENTIFIER . ' =?', $identifier);

        return $this->getConnection()->fetchOne($select);
    }

    /**
     * Is Valid Identifier
     *
     * @param AbstractModel $object Abstract Model
     *
     * @return false|int
     */
    protected function isValidIdentifier(AbstractModel $object)
    {
        return preg_match(
            '/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/',
            $object->getIdentifier()
        );
    }

    /**
     * Is Numeric Identifier
     *
     * @param AbstractModel $object Abstract Model
     *
     * @return false|int
     */
    protected function isNumericIdentifier(AbstractModel $object)
    {
        return preg_match('/^[0-9]+$/', $object->getIdentifier());
    }

    /**
     * After Save
     *
     * @param AbstractModel $object Abstract Model
     *
     * @return AbstractDb
     *
     * @throws LocalizedException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _afterSave(AbstractModel $object)
    {
        $oldStores = $this->lookupStoreIds((int)$object->getId());
        $newStores = (array)$object->getStores();
        if (empty($newStores)) {
            $newStores = (array)$object->getStoreId();
        }
        $table = $this->getTable('encomage_careers_store');
        $delete = array_diff($oldStores, $newStores);
        if ($delete) {
            $where = [
                'item_id = ?'     => (int)$object->getId(),
                'store_id IN (?)' => $delete,
            ];
            $this->getConnection()->delete($table, $where);
        }

        $insert = array_diff($newStores, $oldStores);
        if ($insert) {
            $data = [];
            foreach ($insert as $storeId) {
                $data[] = [
                    'item_id'  => (int)$object->getId(),
                    'store_id' => (int)$storeId,
                ];
            }
            $this->getConnection()->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);
    }

    /**
     * Lookup Store Ids
     *
     * @param int $id Id
     *
     * @return array
     *
     * @throws LocalizedException
     */
    public function lookupStoreIds($id)
    {
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from(['ecs' => $this->getTable('encomage_careers_store')], 'store_id')
            ->join(
                ['ec' => $this->getMainTable()],
                'ecs.item_id' . ' = ec.' . $this->getIdFieldName(),
                []
            )
            ->where('ec.' . $this->getIdFieldName() . ' = :id');

        return $connection->fetchCol($select, ['id' => (int)$id]);
    }
}