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

namespace nfeio\v2\item;

use nfeio\common\DateTime;
use nfeio\v2\Model;

/**
 * @property string $batchId
 * @property integer $batchQuantity
 * @property DateTime $manufactureOn
 * @property DateTime $expireOn
 * @property float $maximumPrice
 */
class MedicineDetail extends Model
{
    /**
     * @inheritdoc
     */
    public function __construct($attributes)
    {
        settype($attributes, 'object');

        if (isset($attributes->manufactureOn)) {
            $attributes->manufactureOn = new DateTime($attributes->manufactureOn);
        }

        if (isset($attributes->expireOn)) {
            $attributes->expireOn = new DateTime($attributes->expireOn);
        }

        parent::__construct($attributes);
    }
}
