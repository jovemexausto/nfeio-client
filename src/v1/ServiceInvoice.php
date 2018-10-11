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
use nfeio\v1\ApproximateTax;
use nfeio\v1\Company;
use nfeio\v1\LegalPeople;
use nfeio\v1\NaturalPeople;

/**
 * @property string $id
 * @property string $environment
 * @property string $flowStatus
 * @property string $flowMessage
 * @property LegalPeople|NaturalPeople $provider
 * @property LegalPeople|NaturalPeople $borrower
 * @property integer $batchNumber
 * @property string $batchCheckNumber
 * @property integer $number
 * @property string $checkCode
 * @property string $status
 * @property string $rpsType
 * @property string $rpsStatus
 * @property string $taxationType
 * @property DateTime $issuedOn
 * @property DateTime $cancelledOn
 * @property string $rpsSerialNumber
 * @property integer $rpsNumber
 * @property string $cityServiceCode
 * @property string $federalServiceCode
 * @property string $description
 * @property float $ervicesAmount
 * @property float $deductionsAmount
 * @property float $discountUnconditionedAmount
 * @property float $discountConditionedAmount
 * @property float $baseTaxAmount
 * @property float $issRate
 * @property float $issTaxAmount
 * @property float $irAmountWithheld
 * @property float $pisAmountWithheld
 * @property float $cofinsAmountWithheld
 * @property float $csllAmountWithheld
 * @property float $inssAmountWithheld
 * @property float $issAmountWithheld
 * @property float $othersAmountWithheld
 * @property float $amountWithheld
 * @property float $amountNet
 * @property ApproximateTax $approximateTax
 * @property string $additionalInformation
 * @property DateTime $createdOn
 * @property DateTime $modifiedOn
 */
class ServiceInvoice extends Model
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

        if (isset($attributes->provider)) {
            settype($attributes->provider, 'object');

            if (strlen($attributes->provider->federalTaxNumber) === 11) {
                $attributes->provider = new NaturalPeople($attributes->provider);
            } else {
                $attributes->provider = new LegalPeople($attributes->provider);
            }
        }

        if (isset($attributes->borrower)) {
            settype($attributes->borrower, 'object');

            if (strlen($attributes->borrower->federalTaxNumber) === 11) {
                $attributes->borrower = new NaturalPeople($attributes->borrower);
            } else {
                $attributes->borrower = new LegalPeople($attributes->borrower);
            }
        }

        if (isset($attributes->issuedOn)) {
            $attributes->issuedOn = new DateTime($attributes->issuedOn);
        }

        if (isset($attributes->cancelledOn)) {
            $attributes->cancelledOn = new DateTime($attributes->cancelledOn);
        }

        if (isset($attributes->approximateTax)) {
            $attributes->approximateTax = new ApproximateTax($attributes->approximateTax);
        }

        if (isset($attributes->createdOn)) {
            $attributes->createdOn = new DateTime($attributes->createdOn);
        }

        if (isset($attributes->modifiedOn)) {
            $attributes->modifiedOn = new DateTime($attributes->modifiedOn);
        }

        parent::__construct($attributes);
    }

    /**
     * Listar as Notas Fiscais de Serviço (NFSE) pelo ID da empresa.
     * @param string $company_id
     * @param integer $count
     * @param integer $index
     * @return mixed
     */
    public static function listById($company_id, $count = null, $index = null)
    {
        $result = self::v1()->get("/v1/companies/{$company_id}/serviceinvoices", [
            'pageCount' => $count,
            'pageIndex' => $index,
        ]);
        return $result->serviceInvoices;
    }

    /**
     * Obter os detalhes de uma Nota Fiscal de Serviço (NFSE) pelo ID da empresa e da NFSE.
     * @param string $company_id
     * @param string $id
     * @return mixed
     */
    public static function findById($company_id, $id)
    {
        return self::v1()->get("/v1/companies/{$company_id}/serviceinvoices/{$id}");
    }

    /**
     * Emitir uma Nota Fiscal de Serviço (NFSE) pelo ID da empresa.
     * @param string $company_id
     * @param mixed $attributes
     * @return mixed
     */
    public static function createById($company_id, $attributes)
    {
        return self::v1()->post("/v1/companies/{$company_id}/serviceinvoices", $attributes);
    }

    /**
     * Cancelar uma Nota Fiscal de Serviços (NFSE) pelo ID da empresa e da NFSE.
     * @param string $company_id
     * @param string $id
     */
    public static function deleteById($company_id, $id)
    {
        self::v1()->delete("/v1/companies/{$company_id}/serviceinvoices/{$id}");
    }

    /**
     * Enviar email para o Tomador com a Nota Fiscal de Serviço (NFSE) pelo ID da empresa e da NFSE.
     * @param string $company_id
     * @param string $id
     */
    public static function mailById($company_id, $id)
    {
        self::v1()->put("/v1/companies/{$company_id}/serviceinvoices/{$id}/sendemail");
    }

    /**
     * Download do PDF da Nota Fiscal de Serviço (NFSE) pelo ID da empresa e da NFSE.
     * @param string $company_id
     * @param string $id
     * @return mixed
     */
    public static function pdfById($company_id, $id)
    {
        $url = self::v1()->get("/v1/companies/{$company_id}/serviceinvoices/{$id}/pdf");
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return file_get_contents($url);
        }
        return false;
    }

    /**
     * Download do XML da Nota Fiscal de Serviço (NFSE) pelo ID da empresa e da NFSE.
     * @param string $company_id
     * @param string $id
     * @return mixed
     */
    public static function xmlById($company_id, $id)
    {
        $url = self::v1()->get("/v1/companies/{$company_id}/serviceinvoices/{$id}/xml");
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return file_get_contents($url);
        }
        return false;
    }

    /**
     * Listar as Notas Fiscais de Serviço (NFSE).
     * @param \nfeio\v1\Company $company
     * @param integer $count
     * @param integer $index
     * @return ServiceInvoice[]
     */
    public static function all(Company $company, $count = null, $index = null)
    {
        $result = self::listById($company->id, $count, $index);

        return array_map(function ($item) use ($company) {
            return new ServiceInvoice($company, $item);
        }, $result);
    }

    /**
     * Obter os detalhes de uma Nota Fiscal de Serviço (NFSE).
     * @param \nfeio\v1\Company $company
     * @param string $id
     * @return ServiceInvoice
     */
    public static function find(Company $company, $id)
    {
        return new ServiceInvoice($company, self::findById($company->id, $id));
    }

    /**
     * Emitir uma Nota Fiscal de Serviço (NFSE).
     * @param \nfeio\v1\Company $company
     * @return ServiceInvoice
     */
    public function create()
    {
        return $this->populate(self::createById($this->company->id, $this));
    }

    /**
     * Cancelar uma Nota Fiscal de Serviços (NFSE).
     */
    public function delete()
    {
        self::deleteById($this->company->id, $this->id);
    }

    /**
     * Enviar email para o Tomador com a Nota Fiscal de Serviço (NFSE).
     */
    public function mail()
    {
        self::mailById($this->company->id, $this->id);
    }

    /**
     * Download do PDF da Nota Fiscal de Serviço (NFSE).
     * @return mixed
     */
    public function pdf()
    {
        return self::pdfById($this->company->id, $this->id);
    }

    /**
     * Download do XML da Nota Fiscal de Serviço (NFSE).
     * @return mixed
     */
    public function xml()
    {
        return self::xmlById($this->company->id, $this->id);
    }
}
