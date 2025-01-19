<?php

namespace App\Core\Providers;

use Doctrine\ORM\ORMSetup;
use Nimbly\Carton\Container;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Nimbly\Carton\ServiceProviderInterface;

class DatabaseProvider implements ServiceProviderInterface
{
	public function register(Container $container): void
	{
		$container->singleton(
			EntityManager::class,
			function(Container $container): EntityManager {

				foreach( \config("doctrine.types") ?? [] as $type => $class_name ){
					\Doctrine\DBAL\Types\Type::addType($type, $class_name);
				}

				$config = ORMSetup::createAttributeMetadataConfiguration(
					paths: \config("doctrine.entities") ?? [],
					isDevMode: \config("app.debug"),
				);

				$params = [
					"driver" => "pdo_" . \config("database.adapter"),
					"host" => \config("database.host"),
					"port" => \config("database.port"),
					//"path" => \config("database.database"),
					"user" => \config("database.username"),
					"password" => \config("database.password"),
					"dbname" => \config("database.database"),
				];

				$connection = DriverManager::getConnection($params, $config);

				return new EntityManager($connection, $config);
			}
		);
	}
}