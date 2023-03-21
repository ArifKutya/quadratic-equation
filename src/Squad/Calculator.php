<?php

namespace Arif\SquadEquation\Squad;

class Calculator
{
    /**
     * @throws CalculatorParseEquationException
     * @throws CalculatorNoRealRootsException
     */
    public function quad($equation): array
    {
        $values = $this->parseEquation($equation);
        $a = $values[0];
        $b = $values[1];
        $c = $values[2];
        $discriminant = $this->findDiscriminant($a, $b, $c);
        return $this->calculateRoots($a, $b, $discriminant);
    }

    /**
     * @param $equation
     * @return array
     * @throws CalculatorParseEquationException
     */
    private function parseEquation($equation): array
    {
        $pattern = '/(?P<a>[-]?\d*\.?\d*?x?)\^2[+]?(?P<b>[-]?\d*\.?\d*x?)?[+]?(?P<c>[-]?\d*\.?\d*x?)?/';

        if (!preg_match($pattern, $equation, $matches)) {
            throw new CalculatorParseEquationException ('Невалиден формат');
        }

        $a = $matches['a'];
        $b = $matches['b'];
        $c = $matches['c'];

        if ($a == '-x' || $a == 'x') {
            $a = -1 || 1;
        } elseif (filter_var($a, FILTER_SANITIZE_NUMBER_FLOAT)) {
            $a =(float)$a;
        }  else {
            $a = (int)filter_var($a, FILTER_SANITIZE_NUMBER_INT);
        }

        if ($b == '-x' || $b == 'x') {
            $b = -1 || 1;
        } elseif (filter_var($b, FILTER_SANITIZE_NUMBER_FLOAT)) {
            $b =(float)$b;
        } else {
            $b = (int)filter_var($b, FILTER_SANITIZE_NUMBER_INT);
        }

        if ($c == '-x' || $c == 'x') {
            $c = -1 || 1;
        } elseif (filter_var($c, FILTER_SANITIZE_NUMBER_FLOAT)) {
            $c =(float)$c;
        } else {
            $c = (int)filter_var($c, FILTER_SANITIZE_NUMBER_INT);
        }

        return [$a, $b, $c];
    }

    /**
     * @param $a
     * @param $b
     * @param $c
     * @return float|int
     * @throws CalculatorNoRealRootsException
     */
    private function findDiscriminant($a, $b, $c): float|int
    {
        $discriminant = $b * $b - 4 * $a * $c;

        if ($discriminant < 0) {
            throw new CalculatorNoRealRootsException("Няма реални корени");
        }
        return $discriminant;
    }

    /**
     * @param $a
     * @param $b
     * @param $discriminant
     * @return float[]|int[]
     */
    private function calculateRoots($a, $b, $discriminant): array
    {
        (float)$x1 = (-$b + sqrt($discriminant)) / (2 * $a);
        (float)$x2 = (-$b - sqrt($discriminant)) / (2 * $a);
        return [$x1, $x2];
    }
}




