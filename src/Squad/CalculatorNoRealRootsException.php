<?php

namespace Arif\SquadEquation\Squad;

use Exception;

class CalculatorNoRealRootsException extends Exception
{
    public $message = "No real roots";
}