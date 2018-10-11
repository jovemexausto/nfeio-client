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

use nfeio\v2\Company;

/**
 * @property string $companyId
 * @property string $accountId
 * @property string $status
 * @property array $current
 * @property array $series
 * @property string $id
 * @property string $code
 * @property string $environmentType
 * @property string $taxNumber
 * @property string $specialTaxRegime
 * @property integer $serie
 * @property integer $number
 */
class StateTax extends Model
{
    /**
     * @var Company
     */
    public $company;

    /**
     * @inheritdoc
     */
    public function __construct(Company $company, array $attributes)
    {
        settype($attributes, 'object');

        $this->company = $company;

        parent::__construct($attributes);
    }

    /**
     * Listar as Inscrições Estaduais pelo ID da empresa.
     * @param string $company_id
     * @return mixed
     */
    public static function listById($company_id)
    {
        $result = self::v2()->get("/v2/companies/{$company_id}/statetaxes");
        return $result->stateTax;
    }

    /**
     * Consultar uma Inscrição Estadual pelo ID da empresa e da Inscrição Estadual.
     * @param string $company_id
     * @param string $statetax_id
     * @return mixed
     */
    public static function findById($company_id, $statetax_id)
    {
        $result = self::v2()->get("/v2/companies/{$company_id}/statetaxes/{$statetax_id}");
        return $result->stateTax;
    }

    /**
     * Criar uma Inscrição Estadual pelo ID da empresa.
     * @param string $company_id
     * @param mixed $attributes
     * @return mixed
     */
    public static function createById($company_id, $attributes)
    {
        $result = self::v2()->post("/v2/companies/{$company_id}/statetaxes", ['stateTax' => $attributes]);
        return $result->stateTax;
    }

    /**
     * Alterar uma Inscrição Estadual pelo ID da empresa e da Inscrição Estadual.
     * @param string $company_id
     * @param string $statetax_id
     * @param mixed $attributes
     * @return mixed
     */
    public static function updateById($company_id, $statetax_id, $attributes)
    {
        $result = self::v2()->put("/v2/companies/{$company_id}/statetaxes/{$statetax_id}", ['stateTax' => $attributes]);
        return $result->stateTax;
    }

    /**
     * Excluir uma Inscrição Estadual pelo ID da empresa e da Inscrição Estadual.
     * @param string $company_id
     * @param string $statetax_id
     */
    public static function deleteById($company_id, $statetax_id)
    {
        self::v2()->delete("/v2/companies/{$company_id}/statetaxes/{$statetax_id}");
    }

    /**
     * Listar as Inscrições Estaduais.
     * @param Company $company
     * @return \nfeio\v2\StateTax[]
     */
    public static function all(Company $company)
    {
        return [self::listById($company->id)];
    }

    /**
     * Consultar uma Inscrição Estadual pelo ID.
     * @param Company $company
     * @param string $id
     * @return \nfeio\v2\StateTax
     */
    public static function find(Company $company, $id)
    {
        return new StateTax($company, self::findById($company->id, $id));
    }

    /**
     * Criar uma Inscrição Estadual.
     * @return \nfeio\v2\StateTax
     */
    public function create()
    {
        return $this->populate(self::createById($this->company->id, $this));
    }

    /**
     * Alterar uma Inscrição Estadual pelo ID.
     * @return \nfeio\v2\StateTax
     */
    public function update()
    {
        return $this->populate(self::updateById($this->company->id, $this->id, $this));
    }

    /**
     * Excluir uma Inscrição Estadual pelo ID.
     */
    public function delete()
    {
        self::deleteById($this->company->id, $this->id);
    }
}
