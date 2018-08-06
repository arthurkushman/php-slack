<?php namespace Slacky\Http;

use Frlnc\Slack\Http\SlackResponse;
use Slacky\Contracts\Http\Response;
use Slacky\Contracts\Http\ResponseFactory;

class SlackResponseFactory implements ResponseFactory {

    /**
     * {@inheritdoc}
     */
    public function build($body, array $headers, $statusCode): Response
    {
        return new SlackResponse($body, $headers, $statusCode);
    }

}
