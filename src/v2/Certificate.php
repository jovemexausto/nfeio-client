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

use nfeio\common\DateTime;
use nfeio\v2\Company;

/**
 * @property string $subject
 * @property DateTime $validUntil
 * @property string $thumbprint
 * @property string $federalTaxNumber
 * @property DateTime $modifiedOn
 * @property string $status
 */
class Certificate extends Model
{
    /**
     * @var Company
     */
    public $company;

    /**
     * @inheritdoc
     */
    public function __construct(Company $company, $attributes)
    {
        settype($attributes, 'object');

        $this->company = $company;

        if (isset($attributes->validUntil)) {
            $attributes->validUntil = new DateTime($attributes->validUntil);
        }

        if (isset($attributes->modifiedOn)) {
            $attributes->modifiedOn = new DateTime($attributes->modifiedOn);
        }

        parent::__construct($attributes);
    }

    /**
     * Upload de um Certificado pelo ID da empresa.
     * @param string $company_id
     * @param string $filepath
     * @param string $password
     * @return mixed
     */
    public static function uploadById($company_id, $filepath, $password)
    {
        $file = ['file' => $filepath];
        $body = ['password' => $password];
        $response = self::v2()->upload("/v2/companies/{$company_id}/certificates", $file, $body);
        return $response->certificate;
    }

    /**
     * Consultar um Certificado por sua impressão digital e pelo ID da empresa.
     * @param string $company_id
     * @param string $thumbprint
     * @return mixed
     */
    public static function findById($company_id, $thumbprint)
    {
        $response = self::v2()->get("/v2/companies/{$company_id}/certificates/{$thumbprint}");
        return $response->certificate;
    }

    /**
     * Excluir um Certificado por sua impressão digital e pelo ID da empresa.
     * @param string $company_id
     * @param string $thumbprint
     */
    public static function deleteById($company_id, $thumbprint)
    {
        self::v2()->delete("/v2/companies/{$company_id}/certificates/{$thumbprint}");
    }

    /**
     * Upload de um Certificado.
     * @param Company $company
     * @param string $filepath
     * @param string $password
     * @return \nfeio\v2\Certificate
     */
    public static function upload(Company $company, $filepath, $password)
    {
        return new Certificate($company, self::uploadById($company->id, $filepath, $password));
    }

    /**
     * Consultar um Certificado por sua impressão digital.
     * @param Company $company
     * @param string $thumbprint
     * @return \nfeio\v2\Certificate
     */
    public static function find(Company $company, $thumbprint)
    {
        return new Certificate($company, self::findById($company->id, $thumbprint));
    }

    /**
     * Excluir um Certificado por sua impressão digital.
     */
    public function delete()
    {
        self::deleteById($this->company->id, $this->thumbprint);
    }
}
