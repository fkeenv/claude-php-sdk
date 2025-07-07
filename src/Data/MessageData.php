<?php

namespace Claude\Data;

use Carbon\Carbon;
use Saloon\Contracts\DataObjects\WithResponse;
use Saloon\Http\Response;
use Saloon\Traits\Responses\HasResponse;

readonly class MessageData implements WithResponse
{
    use HasResponse;

    public function __construct(
        public string $id,
        public string $type,
        public string $role,
        public array $content,
        public string $model,
        public string $stopReason,
        public ?string $stopSequence,
        // public UsageData $usage, - TO DO: implement UsageData
        public Carbon $createdAt,
        public ?Response $response = null
    ) {
        //
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json();

        return new self(
            id: $data['id'],
            type: $data['type'],
            role: $data['role'],
            content: $data['content'],
            model: $data['model'],
            stopReason: $data['stop_reason'],
            stopSequence: $data['stop_sequence'] ?? null,
            // usage: UsageData::fromResponse($data['usage']), - TO DO: implement UsageData
            createdAt: Carbon::parse($data['created_at']),
            response: $response
        );
    }
}