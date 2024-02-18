<?php

namespace App\helpers;

use DI\Container;
use DI\ContainerBuilder;
use Exception;

class ContainerGlobal {
	private static null $container = null;

	public static function getContainer(): ?Container
	{
		try {
			if (self::$container === null) {
				// Provide the path to your definitions file
				$definitions = include __DIR__.'/../../config/container.php';

				$builder = new ContainerBuilder();
				$builder->addDefinitions($definitions);
				$container = $builder->build();

				self::$container = $container;
			}

			return self::$container;

		}catch (Exception){
			return null;
		}

	}
}