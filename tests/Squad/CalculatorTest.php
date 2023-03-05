<?php

namespace Squad;

use Arif\SquadEquation\Squad\Calculator;
use Arif\SquadEquation\Squad\CalculatorDiscriminantException;
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
     * @throws CalculatorDiscriminantException
     * @throws CalculatorParseEquationException
     */
    public function testParseValidEquation($equation, $expected): void
    {
        $calculator = new Calculator();
        $result = $calculator->quad($equation);
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
            array('x^2+7x-6', array(0.7720018726587652, -7.772001872658765)),
        ];
    }

    /**
     * @dataProvider invalidEquationsProvider
     * @param $equation
     * @param $expectedMessage
     * @return void
     * @throws CalculatorDiscriminantException
     * @throws CalculatorParseEquationException
     */
    public function testParseInvalidEquation($equation, $expectedMessage): void
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
            array('3x^3-7x', 'Невалиден формат')
        ];
    }

    /**
     * @dataProvider noRealRootsProvider
     * @param $equation
     * @param $expectedMessage
     * @return void
     * @throws CalculatorDiscriminantException
     * @throws CalculatorParseEquationException
     */
    public function testNoRealRoots($equation, $expectedMessage): void
    {
        $this->expectException(CalculatorDiscriminantException::class);
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
