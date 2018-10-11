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

use nfeio\v2\Model;

/**
 * @property float $baseTax
 * @property float $icmsAmount
 * @property float $icmsExemptAmount
 * @property float $stCalculationBasisAmount
 * @property float $stAmount
 * @property float $productAmount
 * @property float $freightAmount
 * @property float $insuranceAmount
 * @property float $discountAmount
 * @property float $iiAmount
 * @property float $ipiAmount
 * @property float $pisAmount
 * @property float $cofinsAmount
 * @property float $othersAmount
 * @property float $invoiceAmount
 * @property float $fcpufDestinationAmount
 * @property float $icmsufDestinationAmount
 * @property float $icmsufSenderAmount
 * @property float $federalTaxesAmount
 * @property float $fcpAmount
 * @property float $fcpstAmount
 * @property float $fcpstRetAmount
 */
class ICMS extends Model
{
    // pass
}
