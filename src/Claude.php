<?php

namespace Fkeenv\ClaudePhpSdk\Claude;

use Saloon\Http\Auth\QueryAuthenticator;
use Saloon\Http\Connector;

abstract class Claude extends Connector
{
    public function __construct(
        protected string $apiKey
    ) {  
    }

    /**
     * The base URL for the Claude API.
     *
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return 'https://api.anthropic.com/v1/';
    }

    /**
     * The default headers for the Claude API requests.
     *
     * @return array
     */
    public function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    protected function defaultAuth(): QueryAuthenticator
    {
        return new QueryAuthenticator('x-api-key', $this->apiKey);
    }
}