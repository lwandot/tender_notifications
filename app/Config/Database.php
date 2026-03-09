<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Database extends BaseConfig
{
    /**
     * The directory that holds the Migrations and Seeds directories.
     */
    public ?string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to use if no other is specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection.
     */
    public array $default = [
        'DSN'      => '',
        'hostname' => getenv('db.default.hostname') ?? 'localhost',
        'username' => getenv('db.default.username') ?? 'root',
        'password' => getenv('db.default.password') ?? '',
        'database' => getenv('db.default.database') ?? 'tender_notifications',
        'DBDriver' => getenv('db.default.DBDriver') ?? 'MySQLi',
        'DBPrefix' => getenv('db.default.DBPrefix') ?? '',
        'pConnect' => false,
        'DBDebug'  => (getenv('CI_ENVIRONMENT') !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    /**
     * This database connection is used when
     * running PHPUnit database tests.
     */
    public array $tests = [
        'DSN'      => '',
        'hostname' => '127.0.0.1',
        'username' => '',
        'password' => '',
        'database' => ':memory:',
        'DBDriver' => 'SQLite3',
        'DBPrefix' => 'db_',
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

    public function __construct()
    {
        parent::__construct();
    }
}
