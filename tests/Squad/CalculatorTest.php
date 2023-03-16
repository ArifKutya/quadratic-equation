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
            ['x^2 = 25', [0.0, 0.0]],
            ['2x^2-5x+1', [2.2807764064044154, 0.21922359359558485]],
            ['-3x^2-2x = 0', [-0.6666666666666666, -0]],
            ['4x^2+4=0', [0.0, -1.0]],
            ['x^2+4x-5=0', [1.0, -5.0]],
            ['-6x^2=0', [-0, -0]],
            ['5x^2-2x-8=0', [1.4806248474865698, -1.0806248474865696]],
            ['x^2-4=0', [4.0, 0.0]],
            ['-x^2+20', [0.0, -20]],
            ['-x^2', [0.0, 0.0]],
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
