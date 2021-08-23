<?php

namespace Baraja\PrivacyFirewall;

interface CredentialStorage
{
	public function isLoggedIn(): bool;

	public function setIdentity(?string $expiration = null): void;

	public function logout(): void;
}
