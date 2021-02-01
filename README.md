# Pacote de integração com o sistema de pagamentos ZSPAY
###

## Esse pacote vai possibilitar a integração com as ferramentas de recorrência (assinaturas e planos e checkout transparent) via API.
###

###

### Para baixar o pacote utilize o comando "composer require dayglor/zspay:dev-master"
###

###

# Para Laravel
### No arquivo ./config/app.php precisamos definir um novo provider, no caso precisamos adicionar Dayglor\ZSpay\ZSPayServiceProvider::class no array que define os providers
###

###

###

### Depois disso, para utilizar o package basta chamar o arquivo "use Dayglor\ZSPay\Http\Controllers\ClientController;"
###

###

#  Exemplos de chamadas:
###

#### ClientController::searchClientByDocument($data)
#### ClientController::postClient($data); 
#### ClientController::postCard($data); 
