<?php

/*
 * Copyright (C) 2018 Leda Ferreira
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace nfeio;

use Unirest\Request;
use Unirest\Response;
use nfeio\ClientInterface;

/**
 * nfeio\Client.
 */
class Client implements ClientInterface
{
    /**
     * @var string
     */
    private static $api_key;

    /**
     * @var Client
     */
    private static $instance;

    /**
     * @var string
     */
    private $base_url;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var Response
     */
    private $last_response;

    /**
     * Declared as protected to prevent creating a new instance
     * outside of the class via the new operator.
     */
    protected function __construct()
    {
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Accept-Charset' => 'UTF-8',
            'User-Agent' => 'NFe.io-client PHP Library',
            'Accept-Language' => 'pt-br;q=0.9,pt-BR',
        ];
    }

    /**
     * Declared as private to prevent cloning of an instance
     * of the class via the clone operator.
     */
    private function __clone()
    {
        // pass
    }

    /**
     * Declared as private to prevent unserializing of an instance
     * of the class via the global function unserialize() .
     */
    public function __wakeup()
    {
        // pass
    }

    /**
     * Gets the API key.
     * @return string
     * @throws Exception if the API key isn't defined.
     */
    public static function getApiKey()
    {
        if (null === self::$api_key) {
            throw new Exception("API key isn't defined.");
        }
        return self::$api_key;
    }

    /**
     * Sets the API key.
     * @param string $api_key
     */
    public static function setApiKey($api_key)
    {
        self::$api_key = $api_key;
    }

    /**
     * A new instance is created via late static binding in the
     * static creation method getInstance() with the keyword static.
     * @return Client
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    /**
     * Sets the base url.
     * @param string $base_url
     * @return $this
     */
    public function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;
        return $this;
    }

    /**
     * Gets the base URL.
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * Returns the authorization header.
     * @return array
     */
    private function getAuthorizationHeader()
    {
        return ['Authorization' => 'Basic ' . self::getApiKey()];
    }

    /**
     * Returns all headers, including the authorization header.
     * @return array
     */
    private function getHeaders()
    {
        return array_merge($this->getAuthorizationHeader(), $this->headers);
    }

    /**
     * Prepends the base url to the given path.
     * @param string $url
     * @return string
     */
    protected function url($url)
    {
        if ($url[0] !== '/') {
            $url = "/{$url}";
        }
        return $this->base_url . $url;
    }

    /**
     * Returns the last API Response.
     * @return Response
     */
    public function getLastResponse()
    {
        return $this->last_response;
    }

    /**
     * Sends a GET request to a URL.
     * @param string $url
     * @param mixed $parameters
     * @return mixed
     */
    public function get($url, $parameters = null)
    {
        $response = Request::get(
            $this->url($url),
            $this->getHeaders(),
            $parameters
        );

        return $this->process($response);
    }

    /**
     * Sends POST request to a URL.
     * @param string $url
     * @param mixed $body
     * @return mixed
     */
    public function post($url, $body = null)
    {
        $response = Request::post(
            $this->url($url),
            $this->getHeaders(),
            Request\Body::Json($body)
        );

        return $this->process($response);
    }

    /**
     * Sends a multipart/form-data upload request to a URL.
     * @param string $url
     * @param array $files
     * @param mixed $body
     * @return mixed
     */
    public function upload($url, array $files, $body = null)
    {
        $headers = $this->getHeaders();
        $headers['Content-Type'] = 'multipart/form-data';

        $response = Request::post(
            $this->url($url),
            $headers,
            Request\Body::multipart($body, $files)
        );

        return $this->process($response);
    }

    /**
     * Sends DELETE request to a URL.
     * @param string $url
     * @return mixed
     */
    public function delete($url)
    {
        $response = Request::delete(
            $this->url($url),
            $this->getHeaders()
        );

        return $this->process($response);
    }

    /**
     * Sends PUT request to a URL.
     * @param string $url
     * @param mixed $body
     * @return mixed
     */
    public function put($url, $body = null)
    {
        $response = Request::put(
            $this->url($url),
            $this->getHeaders(),
            Request\Body::Json($body)
        );

        return $this->process($response);
    }

    /**
     * Sends PATCH request to a URL.
     * @param string $url
     * @param mixed $body
     * @return mixed
     */
    public function patch($url, $body = null)
    {
        $response = Request::patch(
            $this->url($url),
            $this->getHeaders(),
            Request\Body::Json($body)
        );

        return $this->process($response);
    }

    /**
     * Checks the webservice response for errors.
     * @param Response $response
     * @return mixed
     * @throws Exception
     */
    private function process(Response $response)
    {
        $this->last_response = $response;
        if (intval($response->code / 200) !== 1) {
            throw new APIException($response);
        }
        return $response->body;
    }
}
