<?php namespace Slacky\Http;

use Slacky\Contracts\Http\Interactor;
use Slacky\Contracts\Http\Response;
use Slacky\Contracts\Http\ResponseFactory;

class CurlInteractor implements Interactor
{

    /**
     * The response factory to use.
     *
     * @var \Slacky\Contracts\Http\ResponseFactory
     */
    protected $factory;

    /**
     * {@inheritdoc}
     */
    public function get(string $url, array $parameters = [], array $headers = []) : Response
    {
        return $this->executeRequest(static::prepareRequest($url, $parameters, $headers));
    }

    /**
     * {@inheritdoc}
     */
    public function post(string $url, array $postParameters = [], array $headers = []) : Response
    {
        $request = static::prepareRequest($url, [], $headers);

        curl_setopt($request, CURLOPT_POST, count($postParameters));
        curl_setopt($request, CURLOPT_POSTFIELDS, http_build_query($postParameters));

        return $this->executeRequest($request);
    }

    /**
     * Prepares a request using curl.
     *
     * @param  string $url [description]
     * @param  array $parameters [description]
     * @param  array $headers [description]
     * @return resource
     */
    protected static function prepareRequest(string $url, array $parameters = [], array $headers = [])
    {
        $request = curl_init();

        if (!empty($parameters) && $query = http_build_query($parameters)) {
            $url .= '?' . $query;
        }

        curl_setopt($request, CURLOPT_URL, $url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($request, CURLINFO_HEADER_OUT, true);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);

        return $request;
    }

    /**
     * Executes a curl request.
     *
     * @param  resource $request
     * @return Response
     */
    public function executeRequest($request) : Response
    {
        $body = curl_exec($request);
        $info = curl_getinfo($request);

        curl_close($request);

        $statusCode = $info['http_code'];
        $headers    = $info['request_header'];

        if (function_exists('http_parse_headers')) {
            $headers = http_parse_headers($headers);
        } else {
            $header_text = substr($headers, 0, strpos($headers, "\r\n\r\n"));
            $headers     = [];

            foreach (explode("\r\n", $header_text) as $i => $line) {
                if ($i === 0) {
                    continue;
                }

                [$key, $value] = explode(': ', $line);
                $headers[$key] = $value;
            }
        }

        return $this->factory->build($body, $headers, $statusCode);
    }

    /**
     * {@inheritdoc}
     */
    public function setResponseFactory(ResponseFactory $factory) : void
    {
        $this->factory = $factory;
    }

}
