<?php

namespace Squad;

use Arif\SquadEquation\Squad\Calculator;
use Arif\SquadEquation\Squad\CalculatorDiscriminantException;
use Arif\SquadEquation\Squad\CalculatorParseEquationException;
use PHPUnit\Framework\TestCase;

class SquadEquationTest extends TestCase
{
    private Calculator $parser;

    protected function setUp(): void
    {
        $this->parser = new Calculator();
    }

    /**
     * @dataProvider validEquationsProvider
     * @throws CalculatorParseEquationException
     */
    public function testParseEquationValid($equation, $expected): void
    {
        $actual = $this->parser->parseEquation($equation);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array[]
     */
    public function validEquationsProvider(): array
    {
        return [
            // Da vzima minus pri otricatelno chislo
            ['2x^2-3x-4=0', [2, -3, -4]],
            // Da vzima 1 samo kogato ima x
            ['x^2+2x+1=0', [1, 2, 1]],
            // Da vzima minus
            ['3x^2+7x-6=0', [3, 7, -6]],
        ];
    }

    /**
     * @dataProvider invalidEquationsProvider
     */
    public function testParseEquationInvalid($equation, $expectedMessage): void
    {
        $this->expectException(CalculatorParseEquationException::class);
        $this->expectExceptionMessage($expectedMessage);
        $this->parser->parseEquation($equation);
    }

    /**
     * @return array[]
     */
    public function invalidEquationsProvider(): array
    {
        return [
            ['2x+3x-4=0', 'Невалиден формат'],
            ['x^3+2x+1=0', 'Невалиден формат'],
            ['3x^3-7x', 'Невалиден формат'],
        ];
    }

    /**
     * @dataProvider discriminantProvider
     * @param $a
     * @param $b
     * @param $c
     * @param $expected
     * @return void
     * @throws CalculatorDiscriminantException
     */
    public function testFindDiscriminant(
        $a,
        $b,
        $c,
        $expected
    ): void {
        $discriminant = $this->parser->findDiscriminant($a, $b, $c);
        $this->assertEquals($expected, $discriminant);
    }

    public function discriminantProvider(): array
    {
        return [
            [2, -3, -4, [2.350781059358212, -0.8507810593582121]],
            [3, 3, -4, [0.7583057392117917, -1.7583057392117916]],
        ];
    }

    /**
     * @dataProvider noRealRootsProvider
     * @param $a
     * @param $b
     * @param $c
     * @param $expectedMessage
     * @return void
     * @throws CalculatorDiscriminantException
     */
    public function testFindDiscriminantNoRealRoots(
        $a,
        $b,
        $c,
        $expectedMessage
    ): void {
        $this->expectException(CalculatorDiscriminantException::class);
        $this->expectExceptionMessage($expectedMessage);
        $this->parser->findDiscriminant($a, $b, $c);
    }

    /**
     * @return array[]
     */
    public function noRealRootsProvider(): array
    {
        return [
            ['1', '2', '3', 'Няма реални корени'],
            ['1', '2', '4', 'Няма реални корени'],
            ['1', '3', '4', 'Няма реални корени']
        ];
    }
}
