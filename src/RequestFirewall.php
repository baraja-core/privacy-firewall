<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


use Baraja\Lock\Lock;
use Baraja\Url\Url;

final class RequestFirewall
{
	private LoginForm $loginForm;

	private CredentialStorage $storage;

	private RequestFirewallAuthorizator $authorization;


	public function __construct(
		?CredentialStorage $storage = null,
		?RequestFirewallAuthorizator $authorizator = null,
	) {
		$this->loginForm = new LoginForm;
		$this->storage = $storage ?? new SessionStorage;
		$this->authorization = $authorizator ?? new DefaultSimpleAuthorizator;
	}


	public function run(): void
	{
		if ($this->storage->isLoggedIn()) {
			return;
		}

		$credential = $this->loginForm->getCredential();
		if ($credential !== null) {
			Lock::wait('request-firewall-auth');
			Lock::startTransaction('request-firewall-auth');
		}
		if ($credential !== null && $this->authorization->auth($credential)) {
			$this->storage->setIdentity();
			header('Location: ' . Url::get()->getCurrentUrl());
		} else {
			$this->loginForm->render();
		}
		die;
	}
}
