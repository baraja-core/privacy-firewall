<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


final class LoginForm
{
	public function render(): void
	{
		require __DIR__ . '/assets/authForm.phtml';
	}


	public function getCredential(): ?string
	{
		return $_POST['password'] ?? null;
	}
}
