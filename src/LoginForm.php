<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


class LoginForm
{
	public function render(): void
	{
		require __DIR__ . '/assets/authForm.html';
	}


	public function getCredential(): ?string
	{
		if (isset($_POST['submit'])) {
			return $_POST['password'];
		} else {
			return null;
		}
	}
}
