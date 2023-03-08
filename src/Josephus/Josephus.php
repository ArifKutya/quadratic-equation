<?php

namespace Arif\SquadEquation\Josephus;

class Josephus
{
    public function josephus($n): int
    {
        $result = 0;
        for ($i = 2; $i <= $n; $i++) {
            $result = ($result + 3) % $i;
        }
        return $result +1;
    }

}
$josepshus_position = new Josephus();
$josepshus_position = $josepshus_position->josephus('4');
echo $josepshus_position;

