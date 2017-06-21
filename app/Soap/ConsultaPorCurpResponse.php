<?php

namespace App\Soap;
/**
 * Created by IntelliJ IDEA.
 * User: Uriel
 * Date: 15/05/2017
 * Time: 03:04 PM
 */
class ConsultaPorCurpResponse
{
    protected $ConsultaPorCurpResult;

    public function __construct($ConsultaPorCurpResult)
    {
        $this->ConsultaPorCurpResult = $ConsultaPorCurpResult;
    }

    public function getConsultaPorCurpResult() {
        return $this->ConsultaPorCurpResult;
    }

}
