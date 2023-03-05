<?php

namespace Arif\SquadEquation\Squad;

use Exception;

class CalculatorDiscriminantException extends Exception
{
    public $message = "No real roots";
}