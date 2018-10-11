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

/**
 * @property string $id
 * @property string $name
 * @property string $tradeName
 * @property string $federalTaxNumber
 * @property string $email
 * @property Address $address
 * @property DateTime $openningDate
 * @property string $taxRegime
 * @property string $legalNature
 * @property EconomicAtivities $economicActivities
 * @property string $companyRegistryNumber
 * @property string $regionalTaxNumber
 * @property string $municipalTaxNumber
 * @property string $status
 * @property DateTime $createdOn
 * @property DateTime $modifiedOn
 */
class LegalPeople extends Model
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
     * Listar as pessoas jurídicas ativas pelo ID da empresa.
     * Nota: endpoint está na documentação, mas não existe (HTTP 404).
     * @param string $company_id
     * @return mixed
     */
    public static function listById($company_id)
    {
        return self::v1()->get("/v1/companies/{$company_id}/legalpeople");
    }

    /**
     * Obter os detalhes de uma pessoa jurídica pelo ID da empresa e da pessoa jurídica.
     * Nota: endpoint está na documentação, mas não existe (HTTP 404).
     * @param string $company_id
     * @param string $id
     * @return mixed
     */
    public static function findById($company_id, $id)
    {
        $result = self::v1()->get("/v1/companies/{$company_id}/legalpeople/{$id}");
        return $result->legalPeople;
    }

    /**
     * Listar as pessoas jurídicas ativas.
     * Nota: endpoint está na documentação, mas não existe (HTTP 404).
     * @param \nfeio\v1\Company $company
     * @return \nfeio\v1\LegalPeople[]
     */
    public static function all(Company $company)
    {
        return [new LegalPeople(self::listById($company->id))];
    }

    /**
     * Obter os detalhes de uma pessoa jurídica.
     * Nota: endpoint está na documentação, mas não existe (HTTP 404).
     * @param \nfeio\v1\Company $company
     * @param string $id
     * @return \nfeio\v1\LegalPeople
     */
    public static function find(Company $company, $id)
    {
        return new LegalPeople(self::findById($company->id, $id));
    }
}
