# Pacote de integração com o sistema de pagamentos ZSPAY

## Esse pacote vai possibilitar a integração com as ferramentas de recorrência (assinaturas e planos) via API.


### Para baixar o pacote utilize o comando "composer require dayglor/zspay:dev-master"
### Para Laravel: No arquivo ./config/app.php precisamos definir um novo provider, no caso: Dayglor\ZSpay\ZSPayServiceProvider::class,



### Para utilizar o package basta chamar "use Dayglor\ZSPay\Http\Controllers\ZSPayController as ZSPay";
### ZSPay::postClient($dataClient);