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

use nfeio\v2\payment\PaymentDetail;

/**
 * @property PaymentDetail[] $paymentDetail
 * @property float $payBack
 */
class Payment extends Model
{
    /**
     * @inheritdoc
     */
    public function __construct($attributes)
    {
        settype($attributes, 'object');

        if (isset($attributes->paymentDetail)) {
            $details = [];
            foreach ($attributes->paymentDetail as $detail) {
                $details[] = new PaymentDetail($detail);
            }
            $attributes->paymentDetail = $details;
        }

        parent::__construct($attributes);
    }
}
