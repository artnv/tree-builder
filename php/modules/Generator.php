<?php
function generate_data($max = 100) {

    $symb       = ',';
    $html       = '';

    for($i=1, $e=0; $i<=$max; $i++, $e++) {
        
        // random parent
        switch(mt_rand(1, 4)) {
        default:
        case 2:        
            $parent = ceil($e / 2);
        break;
        case 1:
            $parent = ceil($e / 3);
        break;
        case 3:
            $parent = ceil($e / 8);
        break;
        case 3:
            $parent = ceil($e / 10);
        break;
       }
        
        if($max === $i) {$symb = '';}
        
        $html .= "[\r\n'id' => $i,\r\n'title' => 'tree_$i',\r\n'parent' => $parent\r\n]$symb\r\n";
    }

    $html = '<?php'."\r\n".'$data = ['."\r\n$html];\r\n";
    file_put_contents('tmp_generated_data.php', $html);
}
?>