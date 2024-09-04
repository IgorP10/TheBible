<?php

require_once 'vendor/autoload.php';

use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Kernel\Db\Connection\MigrationConnection;

if (!defined("ROOT_PATH")) {
    define("ROOT_PATH", __DIR__ );
}

$config = new PhpFile('./migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders
$connection = new MigrationConnection();

return DependencyFactory::fromConnection($config, new ExistingConnection($connection->getDriverManager()));
