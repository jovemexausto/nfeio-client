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

namespace nfeio\v2;

use nfeio\v2\EventType;

/**
 * @property string $id
 * @property string $uri
 * @property string $secret
 * @property string $contentType
 * @property boolean $insecureSsl
 * @property boolean $isActive
 * @property array $filters
 * @property array $headers
 * @property array $properties
 */
class Webhook extends Model
{
    /**
     * Listar os Tipos de Eventos gerados pela plataforma.
     * @return EventType[]
     */
    public static function eventTypes()
    {
        $result = self::v2()->get('/v2/webhooks/eventTypes');

        return array_map(function ($item) {
            return new EventType($item);
        }, $result->eventTypes);
    }

    /**
     * Excluir Todos os Webhooks existentes.
     */
    public static function deleteAll()
    {
        self::v2()->delete('/v2/webhooks');
    }

    /**
     * Listar os Webhooks.
     * @return Webhook[]
     */
    public static function all()
    {
        $result = self::v2()->get('/v2/webhooks');

        return array_map(function ($item) {
            return new Webhook($item);
        }, $result->webHooks);
    }

    /**
     * Consultar um webhook existente
     * @param string $id
     * @return Webhook
     */
    public static function find($id)
    {
        $result = self::v2()->get("/v2/webhooks/{$id}");
        return new Webhook($result->webHook);
    }

    /**
     * Criar um Webhook através dos atributos.
     * @param mixed $attributes
     * @return mixed
     */
    public static function createByAttributes($attributes)
    {
        $result = self::v2()->post('/v2/webhooks', ['webHook' => $attributes]);
        return $result->webHook;
    }

    /**
     * Alterar um Webhook existente pelo ID.
     * @param string $id
     * @param mixed $attributes
     * @return mixed
     */
    public static function updateById($id, $attributes)
    {
        $result = self::v2()->put("/v2/webhooks/{$id}", ['webHook' => $attributes]);
        return $result->webHook;
    }

    /**
     * Excluir um Webhook existente.
     * @param string $id
     */
    public static function deleteById($id)
    {
        self::v2()->delete("/v2/webhooks/{$id}");
    }

    /**
     * Criar notificação para Testar um webhook.
     * @param string $id
     */
    public static function pingById($id)
    {
        self::v2()->put("/v2/webhooks/{$id}/pings");
    }

    /**
     * Criar um Webhook.
     * @return Webhook
     */
    public function create()
    {
        return $this->populate(self::createByAttributes($this));
    }

    /**
     * Alterar um Webhook existente.
     * @param array $attributes
     * @return Webhook
     */
    public function update()
    {
        return $this->populate(self::updateById($this->id, $this));
    }

    /**
     * Excluir um Webhook existente.
     */
    public function delete()
    {
        self::deleteById($this->id);
    }

    /**
     * Criar notificação para Testar um webhook.
     */
    public function ping()
    {
        self::pingById($this->id);
    }
}
