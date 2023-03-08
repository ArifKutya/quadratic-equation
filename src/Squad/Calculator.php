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
     * @return array|string
     * @throws CalculatorParseEquationException
     */
    private function parseEquation($equation): array|string
    {
        $pattern = '/^(?P<a>[-]?(x)?([0-9]+)?x)\^2[+]?((?P<b>([-]?[0-9]+)?(x)?))?[+]?((?P<c>[-]?([0-9]+)?(x)?))?/';

        if (preg_match($pattern, $equation, $matches)) {

            $a = $matches['a'] === '-x' ? -1 : ($matches['a'] === '' || $matches['a'] === null
            || $matches['a'] === 'x' ? 1 : (int)$matches['a']);

            $b = $matches['b'] === '-x' ? -1 : ($matches['b'] === '' || $matches['b'] === null
            || $matches['b'] === 'x' ? 1 : (int)$matches['b']);

            $c = $matches['c'] === '-x' ? -1 : ($matches['c'] === '' || $matches['c'] === null
            || $matches['c'] === 'x' ? 1 : (int)$matches['c']);

            return array($a, $b, $c);
        } else {
            throw new CalculatorParseEquationException ('Невалиден формат');
        }
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



