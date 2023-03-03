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

        if ($matches['a'] && $matches['b'] && $matches['c'] == null || '' ) {
            return 1;
        }

        return [$matches['a'], $matches['b'], $matches['c']];
    }

    /**
     * @param $a
     * @param $b
     * @param $c
     * @return array
     * @throws CalculatorDiscriminantException
     */
    public function findDiscriminant($a, $b, $c): array
    {
        $discriminant = $b * $b - 4 * $a * $c;
        if ($discriminant < 0) {
            throw new CalculatorDiscriminantException("Няма реални корени");
        }
        (float)$x1 = (-$b + sqrt($discriminant)) / (2 * $a);
        (float)$x2 = (-$b - sqrt($discriminant)) / (2 * $a);
        return [$x1, $x2];
    }
}



