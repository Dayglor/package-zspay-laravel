<?php

/**
 * @docs https://docs.zspay.com.br/
 * @docs Plano - https://docs.zspay.com.br/#plans
 * @docs Assinatura - https://docs.zspay.com.br/#subscription
 * @docs Cliente - https://docs.zspay.com.br/#client
 */

namespace Dayglor\ZSPay\Http\Controllers;
use App\Http\Controllers\Controller;
use Dayglor\ZSPay\Models\ZSPay;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Dayglor\ZSPay\Http\Controllers\ZSPayController;

class SaleController extends Controller
{
    /**
     * Realiza uma venda por boleto
     */
    public static function postSaleTicket( $data )
    {
        $data['tipoPagamentoId'] = 1;
        $venda = ZSPayController::makeRequest('vendas', 'post', $data);
        return $venda;
    }

    /**
     * Realiza uma venda por cartão de crédito
     */
    public static function postSaleCredit ($data)
    {   
        $data['tipoPagamentoId'] = 3;
        $venda = ZSPayController::makeRequest('vendas', 'post', $data);
        return $venda;
    }

    /**
     * Realiza o estorno de uma venda
     */
    public static function reverseSale ($vendaId)
    {
        $estorno = ZSPayController::makeRequest('vendas/'.$vendaId.'/estornar', 'post');
        return $estorno;
    }

}
