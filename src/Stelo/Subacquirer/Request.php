<?php

namespace Stelo\Subacquirer;

class Request {
	private $options;

	public function __construct(array $options) {
		$this->validateOptions($options);
		$this->options = $options;
	}

	private function validateOptions(array $options) {
		if (!isset($options['url']) || empty($options['url'])) {
			throw new \DomainException('A url da requisição é obrigatória!');
		}

		if (!isset($options['method']) || empty($options['method'])) {
			throw new \DomainException('O método HTTP da requisição é obrigatório!');
		}

		if (!isset($options['headers']) || empty($options['headers'])) {
			throw new \DomainException('Os header da requisição é obrigatório!');
		}
	}

	/**
	 * Send the current request
	 * @throws \Exception | SteloException
	 * @return $response
	 */
	public function send() {
        $curl = curl_init(ApiConfiguration::getInstance()->getEndpoint() . $this->options['url']);
        
        curl_setopt($curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->options['headers']);
        
        switch ($this->options['method']) {
            case 'GET':
                break;
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                if (isset($this->options['post_fields']) && !empty($this->options['post_fields'])) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $this->options['post_fields']);
                }

                break;
            default:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->options['method']);
        }
        
        $response   = json_decode(curl_exec($curl));
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $exception = null;
        if ($statusCode >= 400) {
            $exception = $this->createSteloException($statusCode, $response);
        }
        
        if (curl_errno($curl)) {
            $exception = new \Exception('Curl error: ' . curl_error($curl));
        }
        
        curl_close($curl);

        if (!is_null($exception)) {
            throw $exception;
        }

        return $response;
	}

	private function createSteloException($statusCode, $response) {
        $steloError = new SteloError($response->errorCode ?: $statusCode, $response->errorMessage ?: '');

        if (is_object($response->detail) && is_array($response->detail->message)) {
            foreach ($response->detail->message as $message) {
                $steloError->addDetail($message);
            }
        } else {
            if (isset($response->detail)) {
                $steloError->addDetail($response->detail);
            }
        }
        
        $exception = new SteloException($response->errorMessage ?: '');
        $exception->setSteloError($steloError);

        return $exception;
    }	
}