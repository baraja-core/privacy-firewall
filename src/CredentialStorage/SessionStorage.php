<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


final class SessionStorage implements CredentialStorage
{
	public const SESSION_KEY = '__brj-privacy-firewall';


	public function isLoggedIn(): bool
	{
		$time = $_SESSION[self::SESSION_KEY] ?? null;

		return $time !== null && $time >= time();
	}


	public function setIdentity(?string $expiration = null): void
	{
		$this->setupSession();
		$time = $expiration !== null
			? strtotime('now + ' . $expiration)
			: strtotime('now + 14 days');

		$_SESSION[self::SESSION_KEY] = (int) $time;
	}


	public function logout(): void
	{
		$this->setupSession();
		if (isset($_SESSION[self::SESSION_KEY]) === true) {
			unset($_SESSION[self::SESSION_KEY]);
		}
	}


	private function setupSession(): void
	{
		if (PHP_SAPI === 'cli') {
			return;
		}
		if (headers_sent($file, $line) || ((int) ob_get_length()) > 0) {
			throw new \LogicException(
				self::class . ': Firewall has been called after some output has been sent.'
				. ($file ? ' Output started at ' . $file . ':' . $line . '.' : '')
			);
		}
		if (session_status() !== PHP_SESSION_ACTIVE) {
			ini_set('session.use_cookies', '1');
			ini_set('session.use_only_cookies', '1');
			ini_set('session.use_trans_sid', '0');
			ini_set('session.cookie_path', '/');
			ini_set('session.cookie_httponly', '1');
			session_start();
		}
	}
}
