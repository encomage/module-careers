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

namespace Encomage\Careers\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

/**
 * Class UpgradeSchema
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Setup
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrade
     *
     * @param SchemaSetupInterface   $setup   Setup Schema
     * @param ModuleContextInterface $context Module Interface
     *
     * @throws \Zend_Db_Exception
     *
     * @return void
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        if (version_compare($context->getVersion(), '0.0.2', '<')) {
            $this->addMetaFields($setup);
        }
        if (version_compare($context->getVersion(), '0.0.3', '<')) {
            $this->installStoreTable($setup);
        }
        if (version_compare($context->getVersion(), '0.0.4', '<')) {
            $this->categoryTable($setup);
        }
        if (version_compare($context->getVersion(), '0.0.5', '<')) {
            $this->addStatusColumnInCategoryTable($setup);
        }
    }

    /**
     * Add Meta Fields
     *
     * @param SchemaSetupInterface $setup Setup Schema
     *
     * @return $this
     */
    private function addMetaFields(SchemaSetupInterface $setup)
    {
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('encomage_careers'),
                'meta_title',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'length'   => 255,
                    'nullable' => true,
                    'comment'  => 'Page Meta Title',
                ]
            );
        $setup->getConnection()->addColumn(
            $setup->getTable('encomage_careers'),
            'meta_description',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => '64k',
                'nullable' => true,
                'comment'  => 'Page Meta Description',
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('encomage_careers'),
            'meta_keywords',
            [
                'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length'   => '64k',
                'nullable' => true,
                'comment'  => 'Page Meta Keywords',
            ]
        );

        return $this;
    }

    /**
     * Install Store Table
     *
     * @param SchemaSetupInterface $setup Setup Schema
     *
     * @throws \Zend_Db_Exception
     *
     * @return void
     */
    private function installStoreTable(SchemaSetupInterface $setup)
    {
        $table = $setup->getConnection()->newTable(
            $setup->getTable('encomage_careers_store')
        )->addColumn(
            'item_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
                'nullable' => false,
                'primary'  => true
            ],
            'Vacancy ID'
        )->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'primary'  => true
            ],
            'Store ID'
        )->addIndex(
            $setup->getIdxName('encomage_careers_store', ['store_id']),
            ['store_id']
        )->addForeignKey(
            $setup->getFkName(
                'encomage_careers_store',
                'item_id',
                'encomage_careers',
                'id'
            ),
            'item_id',
            $setup->getTable('encomage_careers'),
            'id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->addForeignKey(
            $setup->getFkName(
                'encomage_careers_store',
                'item_id',
                'store',
                'store_id'
            ),
            'store_id',
            $setup->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Careers To Store Linkage Table'
        );
        $setup->getConnection()->createTable($table);
    }

    /**
     * Category Table
     *
     * @param SchemaSetupInterface $setup Setup Schema
     *
     * @throws \Zend_Db_Exception
     *
     * @return void
     */
    private function categoryTable(SchemaSetupInterface $setup)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('encomage_careers_category')
        )->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            [
                'identity' => true,
                'nullable' => false,
                'primary'  => true
            ],
            'Entity ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            64,
            ['nullable' => false],
            'Title'
        )->addColumn(
            'sort_order',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            10,
            [
                'nullable' => false,
                'default'  => 1
            ],
            'Sort Order'
        )->setComment(
            'Encomage Careers Category Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->getConnection()
            ->addColumn(
                $setup->getTable('encomage_careers'),
                'category_id',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    'length'   => '11',
                    'nullable' => true,
                    'default'  => null,
                    'comment'  => 'Careers category ID',
                ]
            );
        $installer->endSetup();
    }

    /**
     * Add Status Column Category Table
     *
     * @param SchemaSetupInterface $setup Setup Schema
     *
     * @return void
     */
    private function addStatusColumnInCategoryTable(SchemaSetupInterface $setup)
    {
        $installer = $setup;
        $installer->startSetup();
        $installer->getConnection()
            ->addColumn(
                $setup->getTable('encomage_careers_category'),
                'status',
                [
                    'type'     => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    'nullable' => false,
                    'default'  => 0,
                    'comment'  => 'Careers category status',
                ]
            );
        $installer->endSetup();
    }
}