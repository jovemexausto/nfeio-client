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

namespace nfeio\v2\totals;

use nfeio\common\DateTime;
use nfeio\v2\Model;

/**
 * @property float $totalServiceNotTaxedICMS
 * @property float $baseRateISS
 * @property float $totalISS
 * @property float $valueServicePIS
 * @property float $valueServiceCOFINS
 * @property DateTime $provisionService
 * @property float $deductionReductionBC
 * @property float $valueOtherRetention
 * @property float $discountUnconditional
 * @property float $discountConditioning
 * @property float $totalRetentionISS
 * @property float $codeTaxRegime
 */
class ISSQN extends Model
{
    /**
     * @inheritdoc
     */
    public function __construct($attributes)
    {
        settype($attributes, 'object');

        if (isset($attributes->provisionService)) {
            $attributes->provisionService = new DateTime($attributes->provisionService);
        }

        parent::__construct($attributes);
    }
}
