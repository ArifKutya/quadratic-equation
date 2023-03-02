<?php

namespace Squad;

use Arif\SquadEquation\Squad\Calculator;
use Exception;
use PhpParser\Builder\Class_;
use PHPUnit\Framework\TestCase;

class SquadEquationTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testQuad()
    {
        $calculator = new Calculator();
        $equation = this->qu;
        $expected1 = array(0.5, -2);

        $this->assertEquals($expected1, Calculator::quad($equation));

        // Test a quadratic equation with no real solutions
        $equation2 = "x^2 + 2x + 5 = 0";

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("No real solution");

        $result2 = Calculator::quad($equation2);
    }
}
