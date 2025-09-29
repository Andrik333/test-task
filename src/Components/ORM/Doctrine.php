<?php

namespace App\Components\ORM;

use Symfony\Component\Dotenv\Dotenv;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class Doctrine
{
    /**
     * @var string
     */
    protected string $dbUrl;

    /**
     * @var array
     */
    protected array $entityLib = [];

    /**
     * @var string
     */
    protected string $proxyDir;

    /**
     * @var string
     */
    protected string $proxyNamespace = 'Doctrine\Proxies';

    /**
     * @param string $projectRoot
     */
    public function __construct(string $projectRoot)
    {
        $dotenv = new Dotenv();
        $dotenv->loadEnv($projectRoot .'.env');

        $this->dbUrl = $_ENV['DB_URL'];
        $this->entityLib = [$projectRoot . implode(DIRECTORY_SEPARATOR, ['src', 'Entity'])];
        $this->proxyDir = $projectRoot . implode(DIRECTORY_SEPARATOR, ['var', 'doctrine']);
    }

    /**
     * @return EntityManager
     */
    public function init(): EntityManager
    {
        $dsnParser = new DsnParser();
        $connectionParams = $dsnParser->parse($this->dbUrl);

        $config = ORMSetup::createAttributeMetadataConfig($this->entityLib, true);
        $config->setProxyDir($this->proxyDir);
        $config->setProxyNamespace($this->proxyNamespace);

        $connection = DriverManager::getConnection($connectionParams, $config);

        return new EntityManager($connection, $config);
    }
}
