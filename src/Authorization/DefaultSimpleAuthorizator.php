<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


final class DefaultSimpleAuthorizator implements RequestFirewallAuthorizator
{
	private string $password;


	public function __construct(string $password = '123456')
	{
		$password = trim($password);
		if ($password === '') {
			throw new \LogicException('Default login password can not be empty string.');
		}
		$this->password = $password;
	}


	public function auth(string $credential): bool
	{
		return $credential === $this->password;
	}
}
