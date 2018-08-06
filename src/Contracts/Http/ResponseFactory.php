<?php namespace Slacky\Contracts\Http;

interface ResponseFactory {

    /**
     * Builds the response.
     *
     * @param  string  $body
     * @param  array   $headers
     * @param  integer $statusCode
     * @return \Slacky\Contracts\Http\Response
     */
    public function build($body, array $headers, $statusCode): Response;

}
