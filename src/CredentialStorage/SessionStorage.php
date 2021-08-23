<?php

namespace Baraja\PrivacyFirewall;


class SessionStorage implements CredentialStorage
{

	public function isLoggedIn(): bool
	{
		// TODO: Implement isLoggedIn() method - check session.
		return true;
	}


	public function setIdentity(?string $expiration = null): void
	{
		session_start();
		if ($expiration !== null)
		{
			ini_set('session.gc_maxlifetime', $expiration);
			session_set_cookie_params($expiration);
		}

		// TODO: Implement setIdentity() method - set session.
	}


	public function logout(): void
	{
		// TODO: Implement logout() method - unset($_SESSION[]);.
	}
}
