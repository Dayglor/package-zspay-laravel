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

class SubscriptionController extends Controller
{
    /**
     * Assina um plano
     */
    public static function signPlan ($data)
    {
        $assinatura = ZSPayController::makeRequest('planos/assinar', 'post', $data);
        return $assinatura;
    }

    /**
     * Suspender uma assinatura
     */
    public static function suspendSubscription ($data)
    {
        $assinatura = ZSPayController::makeRequest('planos/assinatura/suspender', 'post', $data);
        return $assinatura;
    }

    /**
     * Reativar uma assinatura
     */
    public static function activeSubscription ($data)
    {
        $assinatura = ZSPayController::makeRequest('planos/assinatura/reativar', 'post', $data);
        return $assinatura;
    }

    /**
     * Remover uma assinatura
     */
    public static function removeSubscription ($assinaturaId)
    {
        $assinatura = ZSPayController::makeRequest('planos/assinatura/'.$assinaturaId, 'delete');
        return $assinatura;
    }

    /**
     * Atualizar uma assinatura
     */
    public static function updateSubscription ($data, $assinaturaId)
    {
        $assinatura = ZSPayController::makeRequest('planos/assinatura/'.$assinaturaId, 'put', $data);
        return $assinatura;
    }
}
