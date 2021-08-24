<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


use Baraja\Url\Url;

final class RequestFirewall
{
	private CredentialStorage $storage;

	private RequestFirewallAuthorization $authorization;


	public function __construct(
		private LoginForm $loginForm,
		?CredentialStorage $storage = null,
		?RequestFirewallAuthorization $authorization = null,
	) {
		$this->storage = $storage ?? new SessionStorage;
		$this->authorization = $authorization ?? new DefaultAuthorization;
	}


	public function run(): void
	{
		if ($this->storage->isLoggedIn()) {
			return;
		}

		$credential = $this->loginForm->getCredential();
		if ($credential !== null && $this->authorization->auth($credential)) {
			$this->storage->setIdentity();
			header('Location: ' . Url::get()->getCurrentUrl());
			die;
		}

		$this->loginForm->render();
	}
}
