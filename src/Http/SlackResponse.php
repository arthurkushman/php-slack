<?php namespace Frlnc\Slack\Http;

use Slacky\Contracts\Http\Response;

/**
 * Class SlackResponse
 * @package Frlnc\Slack\Http
 */
class SlackResponse implements Response, \JsonSerializable {

    /**
     * The response body.
     *
     * @var string
     */
    protected $body;

    /**
     * The response headers.
     *
     * @var array
     */
    protected $headers;

    /**
     * The response status code.
     *
     * @var integer
     */
    protected $statusCode;

    /**
     * @param string  $body
     * @param array   $headers
     * @param integer $statusCode
     */
    public function __construct($body, array $headers = [], $statusCode = 404)
    {
        $this->body = json_decode($body, true);
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Converts the response to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'status_code' => $this->getStatusCode(),
            'headers'     => $this->getHeaders(),
            'body'        => $this->getBody()
        ];
    }

}
