<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\ConnectionInterface;

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
    public array $default = [];

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

        $this->default = [
            'DSN'      => '',
            'hostname' => getenv('db.default.hostname') ?? 'localhost',
            'username' => getenv('db.default.username') ?? 'root',
            'password' => getenv('db.default.password') ?? '',
            'database' => getenv('db.default.database') ?? 'government_notifications',
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
    }

    /**
     * Creates and returns a database connection.
     *
     * @param array<string, mixed>|ConnectionInterface|string|null $db
     *
     * @return BaseConnection
     */
    public static function connect($db = null, bool $getShared = true): BaseConnection
    {
        static $connections = [];

        // If a ConnectionInterface is provided, return it directly
        if ($db instanceof ConnectionInterface) {
            return $db;
        }

        // Determine which config group to use
        $group = $db ?? (new self())->defaultGroup;

        // If we want a shared connection and one exists, return it
        if ($getShared && isset($connections[$group])) {
            return $connections[$group];
        }

        // Get the configuration for this group
        $config = new self();
        $settings = $config->{$group} ?? $config->default;

        // Handle array configuration
        if (is_array($db)) {
            $settings = $db;
        }

        // Instantiate the appropriate database driver
        $driverClass = '\\CodeIgniter\\Database\\' . ($settings['DBDriver'] ?? 'MySQLi');
        
        if (!class_exists($driverClass)) {
            $driverClass = '\\CodeIgniter\\Database\\' . ($settings['DBDriver'] ?? 'MySQLi') . '\\Connection';
        }

        $connection = new $driverClass($settings);

        // Store the connection if shared
        if ($getShared) {
            $connections[$group] = $connection;
        }

        return $connection;
    }
}