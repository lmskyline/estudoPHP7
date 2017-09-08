<?php
class Demo
{
    public function add($a, $b)
    {
        return $a + $b;
    }
    
    public function sub($a, $b)
    {
        return $a - $b;
    }
    
    public function mult($a, $b)
    {
        return $a * $b;
    }

    public function div($a, $b)
    {
        if ($b == 0) {
            return 0;
        } else {
            return $a / $b;
        }
    }

    /**
     * Builds an HTML table out of on array
     */

    public function table(array $a)
    {
        $table = '<table>';
        foreach ($a as $row) {
            $table .= '<tr><td>';
            $table .= implode('</td><td>', $row);
            $table .= '</td><tr>';
        }
        $table .= '</table>';
        return $table;
    }
}