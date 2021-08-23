<?php

namespace Baraja\PrivacyFirewall;


class RequestFirewall
{
	private CredentialStorage $storage;

	private RequestFirewallAuthorization $authorization;


	public function __construct(
		private LoginForm $loginForm,
		?CredentialStorage $storage = null,
		?RequestFirewallAuthorization $authorization = null,
	) {
		if ($storage === null) {
			$storage = new SessionStorage();
		}
		if ($authorization === null) {
			$authorization = new DefaultAuthorization();
		}

		$this->storage = $storage;
		$this->authorization = $authorization;
	}


	public function run(): void
	{
		if ($this->storage->isLoggedIn()) {
			return;
		}

		$credential = $this->loginForm->getCredential();
		if ($credential !== null) {
			if ($this->authorization->auth($credential)) {
				$this->storage->setIdentity();
				header('Location: '.$_SERVER['PHP_SELF']);
				die;
			}
		}

		$this->loginForm->render();
	}
}
