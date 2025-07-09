<?php

namespace Claude\Requests;

use Claude\Claude;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class CreateMessage extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $model,
        protected array $messages,
        protected int $maxTokens = 1024,
        protected ?string $system = null,
        protected ?array $metadata = null,
        protected ?array $stopSequences = null,
        protected bool $stream = false,
        protected ?float $temperature = null,
        protected ?float $topP = null,
        protected ?int $topK = null,
        protected ?array $tools = null,
        protected ?array $toolChoice = null
    ) {
        
    }

    /**
     * Resolve the endpoint for the request.
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return '/messages';
    }

    /**
     * Get the default body for the request.
     *
     * @return array
     */
    public function defaultBody(): array
    {
        $body = [
            'model' => $this->model,
            'messages' => $this->messages,
            'max_tokens' => $this->maxTokens,
            'stream' => $this->stream,
        ];

        if ($this->system !== null) {
            $body['system'] = $this->system;
        }

        if ($this->metadata !== null) {
            $body['metadata'] = $this->metadata;
        }

        if ($this->stopSequences !== null) {
            $body['stop_sequences'] = $this->stopSequences;
        }

        if ($this->temperature !== null) {
            $body['temperature'] = $this->temperature;
        }

        if ($this->topP !== null) {
            $body['top_p'] = $this->topP;
        }

        if ($this->topK !== null) {
            $body['top_k'] = $this->topK;
        }

        if ($this->tools !== null) {
            $body['tools'] = $this->tools;
        }

        if ($this->toolChoice !== null) {
            $body['tool_choice'] = $this->toolChoice;
        }

        return $body;
    }

    /**
     * Create a simple message request.
     *
     * @param string $model
     * @param string $message
     * @param integer $maxTokens
     * @return self
     */
    public static function simple(string $model, string $message, int $maxTokens = 1024): self
    {
        return new self(
            model: $model,
            messages: [
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ],
            maxTokens: $maxTokens
        );
    }

    /**
     * Create a message request with a system prompt.
     *
     * @param string $model
     * @param string $system
     * @param array $messages
     * @param integer $maxTokens
     * @return self
     */
    public static function withSystem(
        string $model, 
        string $system, 
        array $messages, 
        int $maxTokens = 1024
    ): self {
        return new self(
            model: $model,
            messages: $messages,
            maxTokens: $maxTokens,
            system: $system
        );
    }

    /**
     * Create a streaming message request.
     *
     * @param string $model
     * @param array $messages
     * @param integer $maxTokens
     * @return self
     */
    public static function streaming(
        string $model, 
        array $messages, 
        int $maxTokens = 1024
    ): self {
        return new self(
            model: $model,
            messages: $messages,
            maxTokens: $maxTokens,
            stream: true
        );
    }
}