<?php 
return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'pgsql', // Use 'pgsql' for PostgreSQL
            'host' => 'localhost',
            'name' => 'store',
            'user' => 'postgres', // Change to a dedicated user if possible
            'pass' => 'Russeldc189', // Set the actual password if there is one
            'port' => '5432',
            'charset' => 'utf8', // Use 'utf8' as appropriate
        ],
        'development' => [
          'adapter' => 'pgsql', // Use 'pgsql' for PostgreSQL
            'host' => 'store_db_1',
            'name' => 'store',
            'user' => 'postgres', // Change to a dedicated user if possible
            'pass' => 'Russeldc189', // Set the actual password if there is one
            'port' => '5432',
            'charset' => 'utf8', // Use 'utf8' as appropriate
        ],
        'testing' => [
            'adapter' => 'pgsql', // Use 'pgsql' for PostgreSQL
            'host' => 'localhost',
            'name' => 'store',
            'user' => 'postgres', // Change to a dedicated user if possible
            'pass' => 'Russeldc189', // Set the actual password if there is one
            'port' => '5432',
            'charset' => 'utf8', // Use 'utf8' as appropriate
        ],  
    ],
    'version_order' => 'creation',
];
