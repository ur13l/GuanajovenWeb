<?php

namespace App\Soap;
/**
 * Created by IntelliJ IDEA.
 * User: Uriel
 * Date: 15/05/2017
 * Time: 03:02 PM
 */
class ConsultaPorCurp
{

    protected $curp;


    public function __construct($curp)
    {
        $this->curp = $curp;
    }

    public function getCurp() {
        return $this->curp;
    }
}
