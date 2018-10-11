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

use nfeio\v2\Model;
use nfeio\v2\item\tax\COFINS;
use nfeio\v2\item\tax\ICMS;
use nfeio\v2\item\tax\ICMSDestination;
use nfeio\v2\item\tax\II;
use nfeio\v2\item\tax\IPI;
use nfeio\v2\item\tax\PIS;

/**
 * @property float $totalTax
 * @property ICMS $icms
 * @property IPI $ipi
 * @property II $ii
 * @property PIS $pis
 * @property COFINS $cofins
 * @property ICMSDestination $icmsDestination
 */
class Tax extends Model
{
    /**
     * @inheritdoc
     */
    public function __construct($attributes)
    {
        settype($attributes, 'object');

        if (isset($attributes->icms)) {
            $attributes->icms = new ICMS($attributes->icms);
        }

        if (isset($attributes->ipi)) {
            $attributes->ipi = new IPI($attributes->ipi);
        }

        if (isset($attributes->ii)) {
            $attributes->ii = new II($attributes->ii);
        }

        if (isset($attributes->pis)) {
            $attributes->pis = new PIS($attributes->pis);
        }

        if (isset($attributes->cofins)) {
            $attributes->cofins = new COFINS($attributes->cofins);
        }

        if (isset($attributes->icmsDestination)) {
            $attributes->icmsDestination = new ICMSDestination($attributes->icmsDestination);
        }

        parent::__construct($attributes);
    }
}
