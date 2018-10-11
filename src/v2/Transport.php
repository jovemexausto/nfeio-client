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

use nfeio\v2\Model;
use nfeio\v2\transport\Reboque;
use nfeio\v2\transport\TransportGroup;
use nfeio\v2\transport\TransportRate;
use nfeio\v2\transport\TransportVehicle;
use nfeio\v2\transport\Volume;

/**
 * @property string $freightModality
 * @property TransportGroup $transportGroup
 * @property Reboque $reboque
 * @property Volume $volume
 * @property TransportVehicle $transportVehicle
 * @property string $sealNumber
 * @property TransportRate $transpRate
 */
class Transport extends Model
{
    /**
     * @inheritdoc
     */
    public function __construct($attributes)
    {
        settype($attributes, 'object');

        if (isset($attributes->transportGroup)) {
            $attributes->transportGroup = new TransportGroup($attributes->transportGroup);
        }

        if (isset($attributes->reboque)) {
            $attributes->reboque = new Reboque($attributes->reboque);
        }

        if (isset($attributes->volume)) {
            $attributes->volume = new Volume($attributes->volume);
        }

        if (isset($attributes->transportVehicle)) {
            $attributes->transportVehicle = new TransportVehicle($attributes->transportVehicle);
        }

        if (isset($attributes->transpRate)) {
            $attributes->transpRate = new TransportRate($attributes->transpRate);
        }

        parent::__construct($attributes);
    }
}
