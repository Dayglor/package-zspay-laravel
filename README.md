# Pacote de integração com o sistema de pagamentos ZSPAY
##

## Esse pacote vai possibilitar a integração com as ferramentas de recorrência (assinaturas e planos e checkout transparent) via API.
##
##

### Para baixar o pacote utilize o comando "composer require dayglor/zspay:dev-master"
##
##

# Para Laravel
### No arquivo ./config/app.php precisamos definir um novo provider, no caso precisamos adicionar Dayglor\ZSpay\ZSPayServiceProvider::class no array que define os providers
##
##
## 

### Depois disso, para utilizar o package basta chamar o arquivo "use Dayglor\ZSPay\Http\Controllers\ZSPayController as ZSPay;"
##
##

#  Exemplos de chamadas:
#
### ZSPay::searchClientByDocument($data)
### ZSPay::postClient($data); 
### ZSPay::postCard($data); 
### ZSPay::postSaleTicket($data);  - Venda no boleto
### ZSPay::postSaleCredit($data);  - Venda no cartão de crédito
### ZSPay::reverseSale($data); 
### ZSPay::postPlan($data); 
### ZSPay::updatePlan($data); 
### ZSPay::signPlan($data); 
### ZSPay::suspendSubscription($data); 
### ZSPay::activeSubscription($data); 
### ZSPay::removeSubscription($data); 
### ZSPay::updateSubscription($data); 
