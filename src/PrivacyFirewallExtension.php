<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


use Nette\Application\Application;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\PhpGenerator\ClassType;

final class PrivacyFirewallExtension extends CompilerExtension
{
	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('firewall'))
			->setType(RequestFirewall::class);
	}


	public function afterCompile(ClassType $class): void
	{
		$builder = $this->getContainerBuilder();

		/** @var ServiceDefinition $application */
		$application = $builder->getDefinitionByType(Application::class);

		/** @var ServiceDefinition $firewall */
		$firewall = $builder->getDefinitionByType(RequestFirewall::class);

		if (PHP_SAPI === 'cli') {
			return;
		}
		$class->getMethod('initialize')->addBody(
			'// privacy firewall.' . "\n"
			. '(function (): void {' . "\n"
			. "\t" . '$this->getService(?)->onStartup[] = function(' . Application::class . ' $a): void {' . "\n"
			. "\t\t" . '$this->getService(?)->run();' . "\n"
			. "\t" . '};' . "\n"
			. '})();',
			[
				$application->getName(),
				$firewall->getName(),
			],
		);
	}
}
