<?php
function generate_data($max = 100) {

    $data       = [];
    $parent     = 0;
    
    for($i=1, $e=0; $i<=$max; $i++, $e++) {

        // random parent
        switch(mt_rand(1, 4)) {
        case 1:        
            $parent = ceil($e / 2);
        break;
        case 2:
            $parent = ceil($e / 3);
        break;
        case 3:
            $parent = ceil($e / 8);
        break;
        case 4:
            $parent = ceil($e / 10);
        break;
       }

        $data[] = [
            'id'        => $i,
            'title'     => "tree_$i",
            'parent'    => $parent
        ];

    }

    return $data;
}

?>