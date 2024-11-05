<?php

namespace Seed;

use mysqli;
use Seed\Model\Database;
use Seed\Model\DatabaseUser;

readonly class Mysql
{
    const DUMP_VOLUME_TABLES = 'tables';

    private mysqli $connection;

    public function __construct(private ?string $host, private ?int $port, private ?string $username, private ?string $password)
    {
    }

    public function createDatabase(Database $database, ?DatabaseUser $user): void
    {
        $connection = $this->getConnection();
        $connection->begin_transaction();
        $connection->query("DROP DATABASE IF EXISTS `$database->name`");
        $connection->query("CREATE DATABASE `$database->name`");
        if (!is_null($user)) {
            $connection->query("DROP USER IF EXISTS `$user->name`");
            $connection->query("CREATE USER '$user->name'@'$user->host' IDENTIFIED BY '$user->password'");
            $connection->query("GRANT ALL ON `$database->name`.* TO '$user->name'@'$user->host'");
        }
        $connection->commit();
    }

    public function getDatabaseDump(Database $database): string
    {
        $connection = $this->getConnection();
        $connection->select_db($database->name);
        $tablesData = $connection->query("SHOW TABLES")->fetch_all();
        $databaseDump = [
            self::DUMP_VOLUME_TABLES => [],
        ];
        foreach ($tablesData as $tablesDataItem) {
            [$tableName] = $tablesDataItem;
            $createTableData = $connection->query("SHOW CREATE TABLE `$tableName`")->fetch_all();
            [, $createTableQueryOrigin] = current($createTableData);

            $describeTableData = $connection->query("DESCRIBE `$tableName`")->fetch_all();
            $fields = [];
            foreach ($describeTableData as $describeTableDataItem) {
                [$field, $type, $null, $key, $default, $extra] = $describeTableDataItem;
                $fields[] = [
                    'field' => $field,
                    'type' => $type,
                    'default' => $default,
                    'null' => $null === 'YES',
                    'primary' => $key === 'PRI',
                    'unique' => $key === 'UNI',
                    'key' => $key === 'MUL',
                    'auto' => $extra === 'auto_increment',
                ];
            }

            $createFieldQueryParts = array_map(
                function ($field) {
                    [
                        'field' => $name,
                        'type' => $type,
                        'default' => $default,
                        'null' => $null,
                        'auto' => $auto,
                    ] = $field;
                    $part = "`$name` $type";
                    if (!$null) {
                        $part .= " NOT NULL";
                    }
                    if (!is_null($default)) {
                        $part .= " DEFAULT '$default'";
                    }
                    if ($auto) {
                        $part .= " AUTO_INCREMENT";
                    }
                    return $part;
                },
                $fields,
            );
            $createFieldsQueryInsertion = implode(', ', $createFieldQueryParts);

            $primaryKeyInsertion = implode(', ', array_map(
                fn($field) => "`$field`",
                array_map(
                    fn($field) => $field['field'],
                    array_filter(
                        $fields,
                        fn($field) => $field['primary'],
                    ),
                )
            ));
            if ($primaryKeyInsertion) {
                $createFieldsQueryInsertion .= ", PRIMARY KEY($primaryKeyInsertion)";
            }

            $createTableQuery = "CREATE TABLE `$tableName` ($createFieldsQueryInsertion)";

            $databaseTableDump = [
                'name' => $tableName,
                'fields' => $fields,
                'originQuery' => $createTableQueryOrigin,
                'query' => $createTableQuery,
                'entries' => [],
            ];

            $entriesData = $connection->query("SELECT * FROM `$tableName`")->fetch_all(MYSQLI_ASSOC);
            if (sizeof($entriesData) > 0) {
                foreach ($entriesData as $entryData) {
                    $fields = implode(', ', array_keys($entryData));
                    $values = '"' . implode('", "', array_map(fn($value) => $connection->real_escape_string($value), array_values($entryData))) . '"';
                    $insertRowQuery = "INSERT INTO `$tableName` ($fields) VALUES ($values)";
                    $databaseTableDump['entries'][] = [
                        'query' => $insertRowQuery,
                    ];
                }
            }

            $databaseDump[self::DUMP_VOLUME_TABLES][] = $databaseTableDump;
        }
        return json_encode($databaseDump);
    }

    public function restoreDatabaseDump(Database $database, string $dumpFilePath): void
    {
        $databaseDump = json_decode(file_get_contents($dumpFilePath), true);

        $connection = $this->getConnection();
        $connection->select_db($database->name);
        $connection->query("SET sql_mode = REPLACE(@@sql_mode, 'NO_ZERO_DATE', '')");

        foreach ($databaseDump[self::DUMP_VOLUME_TABLES] as $tableDump) {
            $tableName = $tableDump['name'];
            $connection->query("DROP TABLE IF EXISTS `$tableName`");
            $connection->query($tableDump['originQuery']);
            foreach ($tableDump['entries'] as $entryDump) {
                $connection->query($entryDump['query']);
            }
        }
    }

    private function getConnection(): mysqli
    {
        if (!isset($this->connection)) {
            $this->connection = new mysqli($this->host, $this->username, $this->password, null, $this->port, null);
        }
        return $this->connection;
    }
}
