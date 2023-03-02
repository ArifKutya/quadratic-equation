<?php

namespace Arif\SquadEquation\Squad;

class Calculator
{
    /**
     * @param string $equation
     * @return array|string
     * @throws CalculatorParseEquationException
     */
    public function parseEquation(string $equation): array|string
    {
        if (!preg_match('/(?P<a>-?\d+)?x\S2[+]?(?P<b>-?\d+)?x+?(?P<c>-?\d+)?x?=?/', $equation, $matches)) {
            throw new CalculatorParseEquationException ('Невалиден формат');
        }

        return [$matches['a'], $matches['b'], $matches['c']];
    }

    /**
     * @param $a
     * @param $b
     * @param $c
     * @return float[]|int[]
     * @throws CalculatorDiscriminantException
     */
    public function findDiscriminant($a, $b, $c): array
    {
        $discriminant = $b * $b - 4 * $a * $c;
        if ($discriminant < 0) {
            throw new CalculatorDiscriminantException("Няма реални корени");
        }
        $x1 = (-$b + sqrt($discriminant)) / (2 * $a);
        $x2 = (-$b - sqrt($discriminant)) / (2 * $a);
        return [$x1, $x2];
    }
}



