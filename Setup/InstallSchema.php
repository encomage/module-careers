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

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 *
 * @category Magento2-module
 * @package  Encomage\Careers\Setup
 * @author   Encomage <hello@encomage.com>
 * @license  OSL <https://opensource.org/licenses/OSL-3.0>
 * @link     http://encomage.com
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Install
     *
     * @param SchemaSetupInterface   $setup   Setup Schema
     * @param ModuleContextInterface $context Module Interface
     *
     * @throws \Zend_Db_Exception
     *
     * @return void
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('encomage_careers')
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
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            ['nullable' => false],
            'Status'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            64,
            ['nullable' => false],
            'Title'
        )->addColumn(
            'identifier',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            64,
            ['nullable' => false],
            'Url Identifier'
        )->addColumn(
            'position',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => false],
            'Position'
        )->addColumn(
            'content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            '2M',
            [],
            'Content'
        )->addColumn(
            'created_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false],
            'Created At'
        )->addColumn(
            'updated_at',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false],
            'Updated At'
        )->setComment(
            'Encomage Careers Table'
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}