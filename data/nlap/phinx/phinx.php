<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/work/phinx/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/work/phinx/seeder'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
#        'production' => [
#            'adapter' => 'mysql',
#            'host' => '127.0.0.1',
#            'name' => 'production_db',
#            'user' => 'root',
#            'pass' => '',
#            'port' => '3306',
#            'charset' => 'utf8',
#        ],
        'development' => [
            'adapter' => 'mysql',
            'host' => 'nomilog_nldb_1',
            'name' => 'nomilog',
            'user' => 'root',
            'pass' => 'root',
            'port' => '3306',
            'charset' => 'utf8',
        ],
#        'testing' => [
#            'adapter' => 'mysql',
#            'host' => 'localhost',
#            'name' => 'testing_db',
#            'user' => 'root',
#            'pass' => '',
#            'port' => '3306',
#            'charset' => 'utf8',
#        ]
    ],
    'version_order' => 'creation'
];
