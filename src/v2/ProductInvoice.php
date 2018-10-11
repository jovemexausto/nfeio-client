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

use nfeio\v2\Company;
use nfeio\v2\Billing;
use nfeio\v2\Buyer;
use nfeio\v2\Event;
use nfeio\v2\Issuer;
use nfeio\v2\Item;
use nfeio\v2\Payment;
use nfeio\v2\Transport;

/**
 * @property string $id
 * @property string $status
 * @property string $operationNature
 * @property integer $serie
 * @property integer $number
 * @property string $operationType
 * @property string $environmentType
 * @property string $purposeType
 * @property Issuer $issuer
 * @property Buyer $buyer
 * @property Totals $totals
 * @property mixed $additionalInformation
 * @property Transport $transport
 * @property Billing $billing
 * @property Payment $payment
 */
class ProductInvoice extends Model
{
    /**
     * @var Company
     */
    public $company;

    /**
     * @inheritdoc
     */
    public function __construct(Company $company, array $attributes)
    {
        settype($attributes, 'object');

        $this->company = $company;

        if (isset($attributes->issuer)) {
            $attributes->issuer = new Issuer($attributes->issuer);
        }

        if (isset($attributes->buyer)) {
            $attributes->buyer = new Issuer($attributes->buyer);
        }

        if (isset($attributes->totals)) {
            $attributes->totals = new Totals($attributes->totals);
        }

        if (isset($attributes->transport)) {
            $attributes->transport = new Transport($attributes->transport);
        }

        if (isset($attributes->billing)) {
            $attributes->billing = new Billing($attributes->billing);
        }

        if (isset($attributes->payment)) {
            $payments = [];
            foreach ($attributes->payment as $payment) {
                $payments[] = new Payment($payment);
            }
            $attributes->payment = $payments;
        }

        parent::__construct($attributes);
    }

    /**
     * Listar as Notas Fiscais Eletrônicas (NFE) pelo ID da empresa.
     * @param string $company_id
     * @return mixed
     */
    public static function listById($company_id)
    {
        $result = self::v2()->get("/v2/companies/{$company_id}/productinvoices");
        return $result->productInvoices;
    }

    /**
     * Consultar por ID uma Nota Fiscal Eletrônica (NFE) pelo ID da empresa e da NFE.
     * @param string $company_id
     * @param string $id
     * @return mixed
     */
    public static function findById($company_id, $id)
    {
        return self::v2()->get("/v2/companies/{$company_id}/productinvoices/{$id}");
    }
    /**
     * Emitir uma Nota Fiscal Eletrônica (NFE) pelo ID da empresa.
     * @return mixed
     */
    public static function createById($company_id, $attributes)
    {
        return self::v2()->post("/v2/companies/{$company_id}/productinvoices", $attributes);
    }

    /**
     * Cancelar uma Nota Fiscal Eletrônica (NFE) pelo ID da empresa e da NFE.
     * @return array
     */
    public static function deleteById($company_id, $id)
    {
        return self::v2()->delete("/v2/companies/{$company_id}/productinvoices/{$id}");
    }

    /**
     * Consultar os produtos por ID uma Nota Fiscal Eletrônica (NFE).
     * @param string $company_id
     * @param string $id
     * @param integer $limit
     * @param integer $startingAfter
     * @return array
     */
    public static function itemsById($company_id, $id, $limit = null, $startingAfter = null)
    {
        $result = self::v2()->get("/v2/companies/{$company_id}/productinvoices/{$id}/items", [
            'limit' => $limit,
            'startingAfter' => $startingAfter,
        ]);
        return $result;
    }

    /**
     * Consultar eventos por ID uma Nota Fiscal Eletrônica (NFE) pelo ID da empresa e da NFE.
     * @param string $company_id
     * @param string $id
     * @param integer $limit
     * @param integer $startingAfter
     * @return array
     */
    public static function eventsById($company_id, $id, $limit = null, $startingAfter = null)
    {
        $result = self::v2()->get("/v2/companies/{$company_id}/productinvoices/{$id}/events", [
            'limit' => $limit,
            'startingAfter' => $startingAfter,
        ]);
        return $result->events;
    }

    /**
     * Consultar PDF do Documento Auxiliar da Nota Fiscal Eletrônica (DANFE) pelo ID da empresa e da NFE.
     * @param string $company_id
     * @param string $id
     * @return mixed
     */
    public static function pdfById($company_id, $id)
    {
        $result = self::v2()->get("/v2/companies/{$company_id}/productinvoices/{$id}/pdf");
        if (isset($result->uri)) {
            if (filter_var($result->uri, FILTER_VALIDATE_URL)) {
                return file_get_contents($result->uri);
            }
        }
        return false;
    }

    /**
     * Consultar XML da Nota Fiscal Eletrônica (NFE) pelo ID da empresa e da NFE.
     * @param string $company_id
     * @param string $id
     * @return mixed
     */
    public static function xmlById($company_id, $id)
    {
        $result = self::v2()->get("/v2/companies/{$company_id}/productinvoices/{$id}/xml");
        if (isset($result->uri)) {
            if (filter_var($result->uri, FILTER_VALIDATE_URL)) {
                return file_get_contents($result->uri);
            }
        }
        return false;
    }

    /**
     * Consultar XML de rejeição da Nota Fiscal Eletrônica (NFE) pelo ID da empresa e da NFE.
     * @param string $company_id
     * @param string $id
     * @return mixed
     */
    public static function rejectionXmlById($company_id, $id)
    {
        $result = self::v2()->get("/v2/companies/{$company_id}/productinvoices/{$id}/xml/rejection");
        if (isset($result->uri)) {
            if (filter_var($result->uri, FILTER_VALIDATE_URL)) {
                return file_get_contents($result->uri);
            }
        }
        return false;
    }

    /**
     * Listar as Notas Fiscais Eletrônicas (NFE).
     * @param Company $company
     * @return ProductInvoice
     */
    public static function all(Company $company)
    {
        $result = self::listById($company->id);

        return array_map(function ($item) use ($company) {
            return new ProductInvoice($company, $item);
        }, $result);
    }

    /**
     * Consultar por ID uma Nota Fiscal Eletrônica (NFE).
     * @param Company $company
     * @param string $id
     * @return ProductInvoice
     */
    public static function find(Company $company, $id)
    {
        return new ProductInvoice($company, self::findById($company->id, $id));
    }

    /**
     * Emitir uma Nota Fiscal Eletrônica (NFE).
     * @return ProductInvoice
     */
    public function create()
    {
        return $this->populate(self::createById($this->company->id, $this));
    }

    /**
     * Cancelar uma Nota Fiscal Eletrônica (NFE).
     * @return array
     */
    public function delete()
    {
        return self::deleteById($this->company->id, $this->id);
    }

    /**
     * Consultar os produtos por ID uma Nota Fiscal Eletrônica (NFE).
     * @param integer $limit
     * @param integer $startingAfter
     * @return array
     */
    public function items($limit = null, $startingAfter = null)
    {
        $result = self::itemsById($this->company->id, $this->id, $limit, $startingAfter);

        return array_map(function ($item) {
            return new Item($item);
        }, $result);
    }

    /**
     * Consultar eventos por ID uma Nota Fiscal Eletrônica (NFE).
     * @param integer $limit
     * @param integer $startingAfter
     * @return array
     */
    public function events($limit = null, $startingAfter = null)
    {
        $result = self::eventsById($this->company->id, $this->id, $limit, $startingAfter);

        return array_map(function ($event) {
            return new Event($event);
        }, $result);
    }

    /**
     * Consultar PDF do Documento Auxiliar da Nota Fiscal Eletrônica (DANFE).
     * @return mixed
     */
    public function pdf()
    {
        return self::pdfById($this->company->id, $this->id);
    }

    /**
     * Consultar XML da Nota Fiscal Eletrônica (NFE).
     * @return mixed
     */
    public function xml()
    {
        return self::xmlById($this->company->id, $this->id);
    }

    /**
     * Consultar XML de rejeição da Nota Fiscal Eletrônica (NFE).
     * @return mixed
     */
    public function rejectionXml()
    {
        return self::rejectionXmlById($this->company->id, $this->id);
    }
}
