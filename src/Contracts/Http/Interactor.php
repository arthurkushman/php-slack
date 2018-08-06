<?php namespace Slacky\Contracts\Http;

interface Interactor {

    /**
     * Send a get request to a URL.
     *
     * @param  string $url
     * @param  array  $parameters
     * @param  array  $headers
     * @return \Slacky\Contracts\Http\Response
     */
    public function get(string $url, array $parameters = [], array $headers = []): Response;

    /**
     * Send a post request to a URL.
     *
     * @param  string $url
     * @param  array  $postParameters
     * @param  array  $headers
     * @return \Slacky\Contracts\Http\Response
     */
    public function post(string $url, array $postParameters = [], array $headers = []): Response;

    /**
     * Sets the response factory to use.
     *
     * @param  \Slacky\Contracts\Http\ResponseFactory $factory
     * @return void
     */
    public function setResponseFactory(ResponseFactory $factory): void;

}
