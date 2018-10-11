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

use nfeio\common\Address;

/**
 * @property string $id
 * @property array $stateTaxes
 * @property string $name
 * @property string $tradeName
 * @property string $federalTaxNumber
 * @property string $taxRegime
 * @property Address $address
 */
class Company extends Model
{
    /**
     * @inheritdoc
     */
    public function __construct($attributes)
    {
        settype($attributes, 'object');

        if (isset($attributes->address)) {
            $attributes->address = new Address($attributes->address);
        }

        parent::__construct($attributes);
    }

    /**
     * Consultar uma Empresa pelo ID.
     * @param string $id
     * @return \nfeio\v2\Company
     */
    public static function find($id)
    {
        $result = self::v2()->get("/v2/companies/{$id}");
        return new Company($result->company);
    }

    /**
     * Criar uma empresa através dos atributos.
     * @param mixed $attributes
     * @return mixed
     */
    public static function createByAttributes($attributes)
    {
        $result = self::v2()->post('/v2/companies', ['company' => $attributes]);
        return $result->company;
    }

    /**
     * Alterar uma Empresa pelo ID.
     * @param string $id
     * @param mixed $attributes
     * @return mixed
     */
    public static function updateById($id, $attributes)
    {
        $result = self::v2()->put("/v2/companies/{$id}", ['company' => $attributes]);
        return $result->company;
    }

    /**
     * Excluir uma Empresa por ID.
     * @param string $id
     */
    public static function deleteById($id)
    {
        self::v2()->delete("/v2/companies/{$id}");
    }

    /**
     * Criar uma Empresa.
     * @return \nfeio\v2\Company
     */
    public function create()
    {
        return $this->populate(self::createByAttributes($this));
    }

    /**
     * Alterar uma Empresa pelo ID.
     * @return \nfeio\v2\Company
     */
    public function update()
    {
        return $this->populate(self::updateById($this->id, $this));
    }

    /**
     * Excluir uma Empresa por ID.
     */
    public function delete()
    {
        self::deleteById($this->id);
    }

    /**
     * Upload de um Certificado.
     * @param string $filepath
     * @param string $password
     * @return Certificate
     */
    public function upload($filepath, $password)
    {
        return Certificate::upload($this, $filepath, $password);
    }

    /**
     * Listar as Inscrições Estaduais.
     * @return StateTax[]
     */
    public function stateTaxes()
    {
        return StateTax::all($this);
    }

    /**
     * Listar as Notas Fiscais Eletrônicas (NFE).
     * @return ProductInvoice[]
     */
    public function productInvoices()
    {
        return ProductInvoice::all($this);
    }

    /**
     * Emitir uma Nota Fiscal Eletrônica (NFE).
     * @param mixed $attributes
     * @return ProductInvoice
     */
    public function issue($attributes)
    {
        return (new ProductInvoice($this, $attributes))->create();
    }

    /**
     * Consultar por ID uma Nota Fiscal Eletrônica (NFE).
     * @param string $id
     * @return ProductInvoice
     */
    public function findInvoice($id)
    {
        return ProductInvoice::find($this, $id);
    }
}
