<?php

namespace Arif\SquadEquation\Squad;

class Calculator
{
    /**
     * @throws CalculatorParseEquationException
     * @throws CalculatorDiscriminantException
     */
    public function quad($equation): array
    {
        $values = $this->parseEquation($equation);
        $a = $values[0];
        $b = $values[1];
        $c = $values[2];
        $discriminant = $this->findDiscriminant($a, $b, $c);
        if ($discriminant >= 0) {
            $roots = $this->findRealRoots($a, $b, $discriminant);
        } else {
            throw new CalculatorDiscriminantException("Няма реални корени");
        }
        return $roots;
    }

    /**
     * @param $equation
     * @return array|string
     * @throws CalculatorParseEquationException
     */
    private function parseEquation($equation): array|string
    {
        $pattern = '/(?P<a>-?\d+)?x\S2[+]?(?P<b>-?\d+)?x+?(?P<c>-?\d+)?x?=?/';
        if (preg_match($pattern, $equation, $matches)) {
            $a = !empty(trim($matches[1])) ? floatval($matches[1]) : 1;
            $b = !empty(trim($matches[2])) ? floatval($matches[2]) : 1;
            $c = !empty(trim($matches[3])) ? floatval($matches[3]) : 1;
            return array($a, $b, $c);
        } else {
           return throw new CalculatorParseEquationException ('Невалиден формат');
        }
    }

    /**
     * @param $a
     * @param $b
     * @param $c
     * @return float|int
     */
    private function findDiscriminant($a, $b, $c): float|int
    {
        return $b * $b - 4 * $a * $c;
    }

    /**
     * @param $a
     * @param $b
     * @param $discriminant
     * @return float[]|int[]
     */
    private function findRealRoots($a, $b, $discriminant): array
    {
        (float)$x1 = (-$b + sqrt($discriminant)) / (2 * $a);
        (float)$x2 = (-$b - sqrt($discriminant)) / (2 * $a);
        return [$x1, $x2];
    }
}



