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

class PlanController extends Controller
{
    /**
     * Cadastra um plano
     */
    public static function postPlan ($data)
    {
        $plano = ZSPayController::makeRequest('planos', 'post', $data);
        return $plano;
    }

    /**
     * Atualiza um plano
     */
    public static function updatePlan ($data, $planoId)
    {
        $plano = ZSPayController::makeRequest('planos/'.$planoId, 'put', $data);
        return $plano;
    }

    /**
     * Assina um plano
     */
    public static function signPlan ($data)
    {
        $assinatura = ZSPayController::makeRequest('planos/assinar', 'post', $data);
        return $assinatura;
    }
}
