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
use nfeio\v1\Company;

/**
 * @property string $thumbprint
 * @property DateTime $modifiedOn
 * @property DateTime $expiresOn
 * @property string $status
 */
class Certificate extends Model
{
    /**
     * @inheritdoc
     */
    public function __construct($attributes)
    {
        settype($attributes, 'object');

        if (isset($attributes->modifiedOn)) {
            $attributes->modifiedOn = new DateTime($attributes->modifiedOn);
        }

        if (isset($attributes->expiresOn)) {
            $attributes->expiresOn = new DateTime($attributes->expiresOn);
        }

        parent::__construct($attributes);
    }

    /**
     * Upload do certificado digital pelo ID da empresa.
     * @param string $id
     * @param string $filepath
     * @param string $password
     */
    public static function uploadById($id, $filepath, $password)
    {
        $file = ['file' => $filepath];
        $body = ['password' => $password];
        self::v1()->upload("/v1/companies/{$id}/certificate", $file, $body);
    }

    /**
     * Upload do certificado digital da empresa.
     * @param Company $company
     * @param string $filepath
     * @param string $password
     */
    public static function upload(Company $company, $filepath, $password)
    {
        self::uploadById($company->id, $filepath, $password);
    }
}
