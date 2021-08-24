<?php

declare(strict_types=1);

namespace Baraja\PrivacyFirewall;


use Baraja\AdminBar\AdminBar;
use Tracy\Debugger;

final class LoginForm
{
	public static function escapeHtmlAttr(string $s): string
	{
		if (str_contains($s, '`') && strpbrk($s, ' <>"\'') === false) {
			$s .= ' '; // protection against innerHTML mXSS vulnerability nette/nette#1496
		}

		return htmlspecialchars($s, ENT_QUOTES | ENT_HTML5 | ENT_SUBSTITUTE, 'UTF-8');
	}


	public function render(): void
	{
		$this->processBridge();
		require_once __DIR__ . '/assets/authForm.phtml';
	}


	public function getCredential(): ?string
	{
		$password = trim($_POST['password'] ?? '');

		return $password !== '' ? $password : null;
	}


	private function processBridge(): void
	{
		if (class_exists(AdminBar::class)) {
			AdminBar::enable(false);
		}
		if (class_exists(Debugger::class)) {
			Debugger::enable(true);
		}
	}
}
