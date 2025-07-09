<?php

namespace Claude;

use Saloon\Http\Auth\QueryAuthenticator;
use Saloon\Http\Connector;
use Saloon\Http\PendingRequest;
use Saloon\Http\Response;

class Claude extends Connector
{
    public function __construct(
        protected string $apiKey,
        protected string $anthropicVersion = '2023-06-01'
    ) {
        //  
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
            'Content-Type' => 'application/json',
            'x-api-key' => $this->apiKey,
            'anthropic-version' => $this->anthropicVersion,
        ];
    }

    /**
     * Boot method to configure the connector.
     */
    public function boot(PendingRequest $pendingRequest): void
    {
        // Add any global request modifications here
        // For example, you could add retry logic, logging, etc.
    }

    /**
     * Handle the response and provide custom error handling.
     */
    public function handleResponse(Response $response): Response
    {
        // You can add custom error handling here
        if ($response->failed()) {
            // Log errors, transform error responses, etc.
        }

        return $response;
    }

    /**
     * Get the API key (useful for testing or debugging).
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Get the Anthropic API version.
     */
    public function getAnthropicVersion(): string
    {
        return $this->anthropicVersion;
    }
}