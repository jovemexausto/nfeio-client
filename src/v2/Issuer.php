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
use nfeio\common\DateTime;
use nfeio\common\EconomicAtivities;
use nfeio\v2\Model;

/**
 * @property string $iest
 * @property string $tradeName
 * @property DateTime $openningDate
 * @property string $taxRegime
 * @property string $specialTaxRegime
 * @property string $legalNature
 * @property EconomicAtivities $economicActivities
 * @property string $companyRegistryNumber
 * @property string $regionalTaxNumber
 * @property string $regionalSTTaxNumber
 * @property string $municipalTaxNumber
 * @property string $name
 * @property string $federalTaxNumber
 * @property string $email
 * @property Address $address
 * @property string $type
 */
class Issuer extends Model
{
    /**
     * @inheritdoc
     */
    public function __construct($attributes)
    {
        settype($attributes, 'object');

        if (isset($attributes->openningDate)) {
            $attributes->openningDate = new DateTime($attributes->openningDate);
        }

        if (isset($attributes->economicActivities)) {
            $activites = [];
            foreach ($attributes->economicActivities as $activity) {
                $activites[] = new EconomicAtivities($activity);
            }
            $attributes->economicActivities = $activites;
        }

        if (isset($attributes->address)) {
            $attributes->address = new Address($attributes->address);
        }

        parent::__construct($attributes);
    }
}
