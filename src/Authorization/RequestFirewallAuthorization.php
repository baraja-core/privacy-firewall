<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


interface RequestFirewallAuthorization
{
	public function auth(string $credential): bool;
}
