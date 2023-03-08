<?php

namespace Squad;

use Arif\SquadEquation\Squad\Calculator;
use Arif\SquadEquation\Squad\CalculatorNoRealRootsException;
use Arif\SquadEquation\Squad\CalculatorParseEquationException;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    /**
     * @return array[]
     */
    public function validEquationsProvider(): array
    {
        return [
            ['2x^2-3x-4=0', [2.350781059358212, -0.8507810593582121]],
            ['x^2+2x+1=0', [-1.0, -1.0]],
            ['x^2+x-6', [2.0, -3.0]],
            ['x^2+23x-x', [0.043396380615195795, -23.043396380615196]],
            ['x^2+7x-6', [0.7720018726587652, -7.772001872658765]],
            ['-30x^2', [-0.16666666666666666, 0.2]],
            ['1x^2+x-10x', [2.7015621187164243, -3.7015621187164243]],
            ['-x^2+20', [-0.049875621120889946, 20.04987562112089]],
        ];
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

    /**
     * @return array[]
     */
    public function invalidEquationsProvider(): array
    {
        return [
            array('2x+3y-4=0', 'Невалиден формат'),
            array('x^3+2x+1=0', 'Невалиден формат'),
            array('3x^3-7y', 'Невалиден формат'),

        ];
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

        $result = $this->calculator->quad($equation);
        $this->assertEquals($expected, $result);
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
        $this->calculator->quad($equation);
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
        $this->calculator->quad($equation);
    }

}
