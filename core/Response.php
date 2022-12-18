<?php

namespace Core;

use JetBrains\PhpStorm\Pure;

class Response
{
    private string $body = '';
    private int $statusCode = 200;

    #[Pure] public static function make(): static
    {
        return new static();
    }

    public function setStatusCode(int $statusCode): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setBody($body): static
    {
        if (is_array($body)) {
            header('Content-Type: application/json');
            $body = json_encode($body);
        }

        $this->body = $body;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
