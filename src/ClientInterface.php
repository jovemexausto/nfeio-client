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

/**
 * nfeio\ClientInterface.
 */
interface ClientInterface
{
    /**
     * Sends a GET request to a URL.
     * @param string $url
     * @param mixed $parameters
     * @return mixed
     */
    public function get($url, $parameters = null);

    /**
     * Sends POST request to a URL.
     * @param string $url
     * @param mixed $body
     * @return mixed
     */
    public function post($url, $body = null);

    /**
     * Sends a multipart/form-data upload request to a URL.
     * @param string $url
     * @param array $files
     * @param mixed $body
     * @return mixed
     */
    public function upload($url, array $files, $body = null);

    /**
     * Sends DELETE request to a URL.
     * @param string $url
     * @return mixed
     */
    public function delete($url);

    /**
     * Sends PUT request to a URL.
     * @param string $url
     * @param mixed $body
     * @return mixed
     */
    public function put($url, $body = null);

    /**
     * Sends PATCH request to a URL.
     * @param string $url
     * @param mixed $body
     * @return mixed
     */
    public function patch($url, $body = null);
}
