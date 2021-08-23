<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


class SessionStorage implements CredentialStorage
{
	public function isLoggedIn(): bool
	{
		// TODO: if (isset($_SESSION[])).
		return true;
	}


	public function setIdentity(?string $expiration = null): void
	{
		session_start();
		if ($expiration !== null) {
			ini_set('session.gc_maxlifetime', $expiration);
			session_set_cookie_params($expiration);
		}

		if (isset($_SESSION['privacy-firewall']) === false) {
			//$_SESSION['privacy-firewall']
		}
		// TODO: set session.
	}


	public function logout(): void
	{
		// TODO: unset($_SESSION[]);.
	}
}
