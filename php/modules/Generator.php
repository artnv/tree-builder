<?php

function generate_data($max = 100)
{
    $html = '';
    $parent = 0;

    for ($i = 1, $e = 0; $i <= $max; $i ++, $e ++) {

        // random parent
        switch (mt_rand(1, 4)) {
            default:
            case 1:
                $parent = 0;
                break;
            case 2:
                $parent = ceil($e / 2);
                break;
            case 3:
                $parent = ceil($e / 3);
                break;
            case 4:
                $parent = mt_rand(1, $max);
                break;
        }

        $html .= "[";
        $html .= "'id' => $i,";
        $html .= "'title' => 'tree_$i',";
        $html .= "'parent' => $parent";
        $html .= "],";
    }

    return ('<?php return [' . $html . '];');
}

?>