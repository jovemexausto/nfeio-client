# Cliente alternativo para o NFe.io (não oficial)

## Instalação via [Composer](http://getcomposer.org/)

  ```bash
  composer require ledat/nfeio-client
  ```

  Para usar a biblioteca, use o [Composer autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

  ```php
  require_once('vendor/autoload.php');
  ```
> **Observação**: A versão do PHP deverá ser 5.6 ou superior.

## Exemplos

### Cadastro de Empresa

```php
use nfeio\NFeio;
use nfeio\v1\Company;

require_once('vendor/autoload.php');

NFeio::init('YOUR API KEY'); // sua chave de API

$company = new Company([
    'name' => 'BANCO DO BRASIL SA',
    'tradeName' => 'BANCO DO BRASIL',
    'federalTaxNumber' => '00000000000191',
    'email' => 'nfe@mailinator.com',
    'address' => [
        'country' => 'BRA',
        'postalCode' => '70040912',
        'street' => 'Quadra SAUN',
        'number' => 'S/N',
        'additionalInformation' => 'Quadra 5 Lote B',
        'district' => 'Asa Norte',
        'city' => [
            'code' => '5300108',
            'name' => 'Brasilia',
        ],
        'state' => 'DF',
    ],
    'openningDate' => '1966-08-01',
]);
$company->create();

echo $company->id;
```

### Upload de Certificado Digital
```php
use nfeio\NFeio;
use nfeio\v1\Company;

require_once('vendor/autoload.php');

NFeio::init('YOUR API KEY');

$company = Company::find('COMPANY ID');
$company->upload('/path/to/cert.pfx', 'CERTIFICATE PASSWORD');
```

### Emissão de Nota Fiscal de Serviço
```php
use nfeio\NFeio;
use nfeio\v1\Company;
use nfeio\v1\ServiceInvoice;

require_once('vendor/autoload.php');

NFeio::init('YOUR API KEY');

$company = Company::find('COMPANY ID');
$invoice = new ServiceInvoice($company, [
    'borrower' => [
        'name' => 'BANCO DO BRASIL SA',
        'federalTaxNumber' => '00000000000191',
        'email' => 'nfe@mailinator.com',
        'address' =>  [
            'country' => 'BRA',
            'postalCode' => '70040912',
            'street' => 'Quadra SAUN',
            'number' => 'S/N',
            'additionalInformation' => 'Quadra 5 Lote B',
            'district' => 'Asa Norte',
            'city' => [
                'code' => '5300108',
                'name' => 'Brasilia',
            ],
            'state' => 'DF',
        ],
    ],
    'cityServiceCode' => '2690',
    'description' => 'TESTE EMISSAO',
    'servicesAmount' => 0.01,
]);
$invoice->create();

echo $invoice->id;
```

### Download dos arquivos XML e PDF
```php
use nfeio\NFeio;
use nfeio\v1\Company;
use nfeio\v1\ServiceInvoice;

require_once('vendor/autoload.php');

NFeio::init('YOUR API KEY');

$company = Company::find('COMPANY ID');
$invoice = ServiceInvoice::find($company, 'NFSE ID');
$pdf = $invoice->pdf();
$xml = $invoice->xml();

file_put_contents('./invoice.pdf', $pdf);
file_put_contents('./invoice.xml', $xml);
```

### Cancelamento de Nota Fiscal de Serviço
```php
use nfeio\NFeio;
use nfeio\v1\Company;
use nfeio\v1\ServiceInvoice;

require_once('vendor/autoload.php');

NFeio::init('YOUR API KEY');

$company = Company::find('COMPANY ID');
$invoice = ServiceInvoice::find($company, 'NFSE ID');
if ($invoice->status == 'Issued') {
    $invoice->delete();
}
```
