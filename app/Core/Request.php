<?php

namespace Core;

class Request
{
    protected string $method;

    protected string $uri;

    protected array $headers;

    protected array $body;

    /**
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param array $body
     */
    public function __construct(string $method, string $uri, array $headers, array $body)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): array
    {
        return $this->body;
    }

}