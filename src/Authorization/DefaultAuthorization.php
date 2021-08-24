<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


final class DefaultAuthorization implements RequestFirewallAuthorization
{
	public function auth(string $credential): bool
	{
		return true;
	}
}
