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

use nfeio\common\Address;
use nfeio\common\DateTime;
use nfeio\common\EconomicAtivities;
use nfeio\v1\Certificate;

/**
 * @property string $id
 * @property string $name
 * @property string $tradeName
 * @property string $federalTaxNumber
 * @property string $email
 * @property Address $address
 * @property DateTime $openningDate
 * @property string $taxRegime
 * @property string $specialTaxRegime
 * @property string $legalNature
 * @property EconomicAtivities economicActivities
 * @property string $companyRegistryNumber
 * @property string $regionalTaxNumber
 * @property string $municipalTaxNumber
 * @property string $rpsSerialNumber
 * @property integer $rpsNumber
 * @property string $environment
 * @property string $fiscalStatus
 * @property Certificate $certificate
 * @property DateTime $createdOn
 * @property DateTime $modifiedOn
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

        if (isset($attributes->openningDate)) {
            $attributes->openningDate = new DateTime($attributes->openningDate);
        }

        if (isset($attributes->certificate)) {
            $attributes->certificate = new Certificate($attributes->certificate);
        }

        if (isset($attributes->createdOn)) {
            $attributes->createdOn = new DateTime($attributes->createdOn);
        }

        if (isset($attributes->modifiedOn)) {
            $attributes->modifiedOn = new DateTime($attributes->modifiedOn);
        }

        if (isset($attributes->economicActivities)) {
            $activites = [];
            foreach ($attributes->economicActivities as $activity) {
                $activites[] = new EconomicAtivities($activity);
            }
            $attributes->economicActivities = $activites;
        }

        parent::__construct($attributes);
    }

    /**
     * Listar as empresas ativas de uma conta.
     * @param integer $count
     * @param integer $index
     * @return Company[]
     */
    public static function all($count = null, $index = null)
    {
        $result = self::v1()->get('/v1/companies', [
            'pageCount' => $count,
            'pageIndex' => $index,
        ]);

        return array_map(function ($item) {
            return new Company($item);
        }, $result->companies);
    }

    /**
     * Obter os detalhes de uma empresa.
     * @param string $id
     * @return Company
     */
    public static function find($id)
    {
        $result = self::v1()->get("/v1/companies/{$id}");
        return new Company($result->companies);
    }

    /**
     * Criar uma empresa através dos atributos.
     * @param mixed $attributes
     * @return mixed
     */
    public static function createByAttributes($attributes)
    {
        $result = self::v1()->post('/v1/companies', $attributes);
        return $result->companies;
    }

    /**
     * Atualizar uma empresa pelo ID.
     * @param string $id
     * @param mixed $attributes
     * @return mixed
     */
    public static function updateById($id, $attributes)
    {
        $result = self::v1()->put("/v1/companies/{$id}", $attributes);
        return $result->companies;
    }

    /**
     * Excluir uma empresa pelo ID.
     */
    public static function deleteById($id)
    {
        self::v1()->delete("/v1/companies/{$id}");
    }

    /**
     * Criar uma empresa.
     * @return Company
     */
    public function create()
    {
        return $this->populate(self::createByAttributes($this));
    }

    /**
     * Atualizar uma empresa.
     * @return Company
     */
    public function update()
    {
        return $this->populate(self::updateById($this->id, $this));
    }

    /**
     * Excluir uma empresa.
     */
    public function delete()
    {
        self::deleteById($this->id);
    }

    /**
     * Upload do certificado digital da empresa.
     * @param string $filepath
     * @param string $password
     */
    public function upload($filepath, $password)
    {
        Certificate::upload($this, $filepath, $password);
    }

    /**
     * Listar as pessoas jurídicas ativas.
     * Nota: endpoint está na documentação, mas não existe (HTTP 404).
     * @return LegalPeople[]
     */
    public function legalPeople()
    {
        return LegalPeople::all($this);
    }

    /**
     * Listar as pessoas físicas ativas.
     * Nota: endpoint está na documentação, mas não existe (HTTP 404).
     * @return NaturalPeople[]
     */
    public function naturalPeople()
    {
        return NaturalPeople::all($this);
    }

    /**
     * Listar as Notas Fiscais de Serviço (NFSE).
     * @param integer $count
     * @param integer $index
     * @return ServiceInvoice[]
     */
    public function serviceInvoices($count = null, $index = null)
    {
        return ServiceInvoice::all($this, $count, $index);
    }

    /**
     * Emitir uma Nota Fiscal de Serviço (NFSE).
     * @param mixed $attributes
     * @return ServiceInvoice
     */
    public function issue($attributes)
    {
        return (new ServiceInvoice($this, $attributes))->create();
    }

    /**
     * Obter os detalhes de uma Nota Fiscal de Serviço (NFSE).
     * @param string $id
     * @return ServiceInvoice
     */
    public function findInvoice($id)
    {
        return ServiceInvoice::find($this, $id);
    }
}
