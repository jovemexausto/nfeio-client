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

use nfeio\Client;

class NFeio
{
    /**
     * @var Client
     */
    private static $client;

    /**
     * Initializes the client.
     * @param string $api_key
     */
    public static function init($api_key)
    {
        Client::setApiKey($api_key);
        self::$client = Client::getInstance();
    }

    /**
     * @return Client
     * @throws Exception
     */
    public static function client()
    {
        if (null === self::$client) {
            throw new Exception('API client has not been initiated.');
        }
        return self::$client;
    }
}
