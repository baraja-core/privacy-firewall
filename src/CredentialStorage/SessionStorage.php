<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


class SessionStorage implements CredentialStorage
{
	public function isLoggedIn(): bool
	{
		if (isset($_SESSION['privacy-firewall']) === true) {
			return true;
		}

		return false;
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
	}


	public function logout(): void
	{
		if (isset($_SESSION['privacy-firewall']) === true) {
			unset($_SESSION['privacy-firewall']);
		}
	}
}
