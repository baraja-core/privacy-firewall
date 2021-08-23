<?php

namespace Baraja\PrivacyFirewall;


class DefaultAuthorization implements RequestFirewallAuthorization
{
	public function auth(string $credential): bool
	{
		// TODO: Implement auth() method.
		return true;
	}
}
