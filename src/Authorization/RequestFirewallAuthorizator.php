<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


interface RequestFirewallAuthorizator
{
	public function auth(string $credential): bool;
}
