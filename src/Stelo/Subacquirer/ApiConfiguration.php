<?php

/**
 * Implements Singleton pattern
 */

namespace Stelo\Subacquirer;

class ApiConfiguration {
	const ENV_SANDBOX    = 'sandbox';
	const ENV_PRODUCTION = 'production';

	private static $instance;
	private $clientId;
	private $clientSecret;
	private $environment;
	private $endpoint;

	public static function getInstance() {
		if (is_null(self::$instance)) {
			throw new \RuntimeException('Você primeiro deve setar as configurações para acessar o objeto!');
		}

		return self::$instance;
	}

	/**
	 * Set as configurations for API access
	 */
	public static function setup($clientId, $clientSecret, $environment) {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		self::$instance->clientId     = $clientId;
		self::$instance->clientSecret = $clientSecret;
		self::$instance->environment  = $environment;

		if ($environment == self::ENV_SANDBOX) {
			self::$instance->endpoint = 'https://apic1.hml.stelo.com.br';
		} elseif ($environment == self::ENV_PRODUCTION) {
			self::$instance->endpoint = 'https://api.stelo.com.br';
		} else {
			throw new \InvalidArgumentException('O ambiente informado não existe!');
		}
		
	}

	public function getClientId() {
		return $this->clientId;
	}

	public function getClientSecret() {
		return $this->clientSecret;
	}

	public function getEnvironment() {
		return $this->environment;
	}

	public function getEndpoint() {
		return $this->endpoint;
	}
}