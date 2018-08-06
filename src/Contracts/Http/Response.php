<?php namespace Slacky\Contracts\Http;

interface Response
{

    /**
     * Gets the body of the response.
     *
     * @return string
     */
    public function getBody() : string;

    /**
     * Gets the headers of the response.
     *
     * @return array
     */
    public function getHeaders() : array;

    /**
     * Gets the status code of the response.
     *
     * @return integer
     */
    public function getStatusCode() : int;

}
