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

namespace nfeio\v1;

use nfeio\common\DateTime;

/**
 * @property string $id
 * @property string $url
 * @property string $contentType
 * @property string $secret
 * @property array $events
 * @property string $status
 * @property DateTime $createdOn
 * @property DateTime $modifiedOn
 */
class Webhook extends Model
{
    /**
     * @inheritdoc
     */
    public function __construct(array $attributes)
    {
        settype($attributes, 'object');

        if (isset($attributes->createdOn)) {
            $attributes->createdOn = new DateTime($attributes->createdOn);
        }

        if (isset($attributes->modifiedOn)) {
            $attributes->modifiedOn = new DateTime($attributes->modifiedOn);
        }

        parent::__construct($attributes);
    }

    /**
     * Listar os webhooks da conta.
     * @return Webhook[]
     */
    public static function all()
    {
        $result = self::v1()->get('/v1/hooks');

        return array_map(function ($item) {
            return new Webhook($item);
        }, $result->hooks);
    }

    /**
     * Obter os detalhes de um webhook da conta.
     * @param string $id
     * @return \nfeio\v1\Webhook
     */
    public static function find($id)
    {
        $result = self::v1()->get("/v1/hooks/{$id}");
        return new Webhook($result->hooks);
    }

    /**
     * Criar um webhook da conta pelos atributos.
     * @return mixed
     */
    public static function createByAttributes($attributes)
    {
        $result = self::v1()->post('/v1/hooks', $attributes);
        return $result->hooks;
    }

    /**
     * Atualizar um webhook da conta pelo ID do webhook.
     * @return mixed
     */
    public static function updateById($id, $attributes)
    {
        $result = self::v1()->put("/v1/hooks/{$id}", $attributes);
        return $result->hooks;
    }

    /**
     * Excluir um webhook da conta pelo ID do webhook.
     */
    public static function deleteById($id)
    {
        self::v1()->delete("/v1/hooks/{$id}");
    }

    /**
     * Criar um webhook da conta.
     * @return \nfeio\v1\Webhook
     */
    public function create()
    {
        return $this->populate(self::createByAttributes($this));
    }

    /**
     * Atualizar um webhook da conta.
     * @return \nfeio\v1\Webhook
     */
    public function update()
    {
        return $this->populate(self::updateById($this->id, $this));
    }

    /**
     * Excluir um webhook da conta.
     */
    public function delete()
    {
        self::deleteById($this->id);
    }
}
