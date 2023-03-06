<?php

namespace Squad;

use Arif\SquadEquation\Squad\Calculator;
use Arif\SquadEquation\Squad\CalculatorNoRealRootsException;
use Arif\SquadEquation\Squad\CalculatorParseEquationException;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private Calculator $parser;

    protected function setUp(): void
    {
        $this->parser = new Calculator();
    }

    /**
     * @dataProvider validEquationsProvider
     * @param $equation
     * @param $expected
     * @throws CalculatorNoRealRootsException
     * @throws CalculatorParseEquationException
     */
    public function testParseValidEquation($equation, $expected): void
    {

        $result = $this->parser->quad($equation);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function validEquationsProvider(): array
    {
        return [
            array('2x^2-3x-4=0', array(2.350781059358212, -0.8507810593582121)),
            array('x^2+2x+1=0', array(-1.0, -1.0)),
            array('x^2+x-6', array(2.0, -3.0)),
            array('x^2+23x-x', array(-0.04356076261040087, -22.9564392373896)),
            array('x^2+7x-6', array(0.7720018726587652, -7.772001872658765)),
            array('-11x^2+x-x', array(-0.2594638151136077, 0.3503729060226986)),
        ];
    }

    /**
     * @dataProvider invalidEquationsProvider
     * @param $equation
     * @param $expectedMessage
     * @return void
     * @throws CalculatorNoRealRootsException
     * @throws CalculatorParseEquationException
     */
    public function testParseInvalidException($equation, $expectedMessage): void
    {
        $this->expectException(CalculatorParseEquationException::class);
        $this->expectExceptionMessage($expectedMessage);
        $this->parser->quad($equation);
    }

    /**
     * @return array[]
     */
    public function invalidEquationsProvider(): array
    {
        return [
            array('2x+3y-4=0', 'Невалиден формат'),
            array('x^3+2x+1=0', 'Невалиден формат'),
            array('3x^3-7x', 'Невалиден формат'),

        ];
    }

    /**
     * @dataProvider noRealRootsProvider
     * @param $equation
     * @param $expectedMessage
     * @return void
     * @throws CalculatorNoRealRootsException
     * @throws CalculatorParseEquationException
     */
    public function testNoRealRootsException($equation, $expectedMessage): void
    {
        $this->expectException(CalculatorNoRealRootsException::class);
        $this->expectExceptionMessage($expectedMessage);
        $this->parser->quad($equation);
    }
    /**
     * @return array[]
     */
    public function noRealRootsProvider(): array
    {
        return [
            array('2x^2+1x+3', 'Няма реални корени'),
            array('x^2+1x+3', 'Няма реални корени'),
            array('1x^2+1x+1x', 'Няма реални корени')
        ];
    }
}
