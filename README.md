# Claude PHP SDK

A PHP SDK for integrating with the Claude AI API, built with [Saloon](https://github.com/saloonphp/saloon) for robust HTTP client functionality.

## Installation

```bash
composer require your-vendor/claude-sdk
```

## Quick Start

### Basic Setup

```php
use Claude\Claude;
use Claude\Requests\CreateMessage;

// Initialize the Claude connector
$claude = new Claude('your-api-key-here');
```

### Simple Message

Send a basic message to Claude:

```php
// Create a simple message request
$request = CreateMessage::simple('claude-3-sonnet-20240229', 'Hello Claude!');

// Send the request
$response = $claude->send($request);

// Handle the response
if ($response->successful()) {
    $data = $response->json();
    echo $data['content'][0]['text'];
} else {
    echo "Error: " . $response->status();
}
```

### Conversation with System Prompt

```php
$request = CreateMessage::withSystem(
    model: 'claude-3-sonnet-20240229',
    system: 'You are a helpful coding assistant.',
    messages: [
        ['role' => 'user', 'content' => 'Explain PHP arrays']
    ],
    maxTokens: 1024
);

$response = $claude->send($request);
```

### Multi-turn Conversation

```php
$request = new CreateMessage(
    model: 'claude-3-sonnet-20240229',
    messages: [
        ['role' => 'user', 'content' => 'Hello'],
        ['role' => 'assistant', 'content' => 'Hi there! How can I help you?'],
        ['role' => 'user', 'content' => 'What is PHP?']
    ],
    maxTokens: 2048,
    temperature: 0.7
);

$response = $claude->send($request);
```

### Streaming Response

```php
$request = CreateMessage::streaming(
    model: 'claude-3-sonnet-20240229',
    messages: [
        ['role' => 'user', 'content' => 'Write a short story']
    ],
    maxTokens: 1024
);

$response = $claude->send($request);
// Handle streaming response...
```

## Available Models

- `claude-3-opus-20240229` - Most powerful model
- `claude-3-sonnet-20240229` - Balanced performance and speed
- `claude-3-haiku-20240307` - Fastest model

## Configuration Options

### CreateMessage Parameters

- `model` (required) - The Claude model to use
- `messages` (required) - Array of conversation messages
- `maxTokens` - Maximum tokens to generate (default: 1024)
- `system` - System prompt to set context
- `temperature` - Randomness in responses (0-1)
- `topP` - Nucleus sampling parameter
- `topK` - Top-k sampling parameter
- `stopSequences` - Array of sequences to stop generation
- `stream` - Enable streaming response
- `tools` - Available tools for the model
- `toolChoice` - Tool selection strategy

### Message Format

```php
[
    'role' => 'user|assistant', // Required
    'content' => 'Message text'  // Required
]
```

## Error Handling

```php
$response = $claude->send($request);

if ($response->failed()) {
    $error = $response->json();
    echo "Error: " . $error['error']['message'];
}
```

## Environment Variables

Set your API key as an environment variable:

```bash
CLAUDE_API_KEY=your-api-key-here
```

```php
$claude = new Claude($_ENV['CLAUDE_API_KEY']);
```

## Requirements

- PHP 8.1+
- SaloonPHP
- Valid Claude API key

## License

MIT License