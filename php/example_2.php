<?php
require_once "modules/RuntimeTracker.php";
require_once "modules/TreeBuilder.php";
require_once "modules/Generator.php"; 

$data = generate_data(1000); // creates a file "tmp_generated_data.php" (random parent)

$rt = new RuntimeTracker;
$rt->start();

$menu = new TreeBuilder;
$menu->setData($data);

?>
<html>
<head>
<style>
ul {margin-bottom: 10px;}
.line {border-left: 1px dashed #ccc;}
.line:hover {border-left-color: red;}
</style>
</head>
<body>
<?php

    $menu->showTree();
    //print_r($menu->getTree());

    $rt->end();

?>
</body>
</html>