<?php

namespace Mourya\Shopfinder\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /* create table "am_shops" */
        if (!$installer->tableExists('mourya_shops')) {
            $table = $installer->getConnection()->newTable($installer->getTable('mourya_shops'))
                        ->addColumn(
                            'shop_id',
                            Table::TYPE_INTEGER,
                            null,
                            [
                                'identity' => true,
                                'nullable' => false,
                                'primary' => true
                            ],
                            'Shop Entity ID'
                        )
                        ->addColumn(
                            'name',
                            Table::TYPE_TEXT,
                            255,
                            [
                                'nullable' => false
                            ],
                            'Shop Name'
                        )
                        ->addColumn(
                            'identifier',
                            Table::TYPE_TEXT,
                            100,
                            [
                                'nullable' => false
                            ],
                            'Shop Identifier'
                        )
                        ->addColumn(
                            'country',
                            Table::TYPE_TEXT,
                            5,
                            [
                                'nullable' => false
                            ],
                            'Shop Country'
                        )
                        ->addColumn(
                            'image',
                            Table::TYPE_TEXT,
                            null,
                            [
                                'nullable' => false
                            ],
                            'Shop image media path'
                        )
                        ->addColumn(
                            'store_id',
                            Table::TYPE_INTEGER,
                            5,
                            [
                                'nullable' => true,
                                'default' => null
                            ],
                            'Store View id'
                        )
                        ->addColumn(
                            'created_at',
                            Table::TYPE_TIMESTAMP,
                            null,
                            ['default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                            'Created at'
                        )
                        ->setComment(
                            'Shops Table'
                        )
                        ->addIndex(
                            $installer->getIdxName(
                                'identifier',
                                ['identifier'],
                                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                            ),
                            ['identifier'],
                            ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                        );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();    
        }
    }
}