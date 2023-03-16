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
        $pattern = '/(?P<a>[+-]?\d*x)\^2\s*?(?P<b>[+-]?\s*?\d*)x?\s*(?P<c>[+-]?\s*\d*)\s*/';

        if (!preg_match($pattern, $equation, $matches)) {
            throw new CalculatorParseEquationException ('Невалиден формат');
        }
        $a = $matches['a'];
        $b = (int)filter_var($matches['b'], FILTER_SANITIZE_NUMBER_INT);
        $c = (int)filter_var($matches['c'], FILTER_SANITIZE_NUMBER_INT);

        if ($a == '-x' || $a == 'x') {
            $a = -1 || 1;
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

$test = new Calculator();
$test->quad('x^2');
print_r($test);



