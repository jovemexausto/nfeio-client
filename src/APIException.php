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

use Unirest\Response;

class APIException extends \Unirest\Exception
{
    /**
     * @var Response
     */
    public $response;

    /**
     * @inheritdoc
     */
    public function __construct(Response $response, $previous = null)
    {
        $this->response = $response;
        parent::__construct($this->formatMessage(), $response->code, $previous);
    }

    /**
     * Formats the error message.
     * @return string
     */
    private function formatMessage()
    {
        $response = $this->response;
        $message = $response->headers[0];
        if (isset($response->body->message)) {
            $message .= ": {$response->body->message}";
        } elseif (isset($response->body->errors[0]->message)) {
            $message .= ": {$response->body->errors[0]->message}";
        }
        return $message;
    }
}
