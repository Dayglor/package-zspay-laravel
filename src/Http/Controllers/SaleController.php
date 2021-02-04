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

        $validator = Validator::make($data, [
            'valor' => 'required',
            'parcelas' => 'required',
            'clientId' => 'required',
            'cartaoId' => 'required',
        ]);

        if ($validator->fails()) 
        {
            throw new \Exception($validator->errors()->all()[0]);
        }

        $data['tipoPagamentoId'] = 1;
        $venda = ZSPayController::makeRequest('vendas', 'post', $data);
        return $venda;
    }

    /**
     * Realiza uma venda por cartão de crédito
     */
    public static function postSaleCredit ($data)
    {   

        $validator = Validator::make($data, [
            'valor' => 'required',
            'parcelas' => 'required',
            'clientId' => 'required',
            'cartaoId' => 'required',
        ]);

        if ($validator->fails()) 
        {
            throw new \Exception($validator->errors()->all()[0]);
        }

        $data['tipoPagamentoId'] = 3;
        $venda = ZSPayController::makeRequest('vendas', 'post', $data);
        return $venda;
    }

    /**
     * Realiza o estorno de uma venda
     */
    public static function reverseSale ($vendaId)
    {
        if (!$vendaId) 
        {
            throw new \Exception('Informe o ID da venda');
        }

        $estorno = ZSPayController::makeRequest('vendas/'.$vendaId.'/estornar', 'post');
        return $estorno;
    }

}
