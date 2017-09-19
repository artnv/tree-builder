<?php
require_once "modules/RuntimeTracker.php";
require_once "modules/TreeBuilder.php";
require_once "modules/Generator.php"; 

$data   = generate_data(1000); // creates a file "tmp_generated_data.php" (random parent)

$rt     = new RuntimeTracker;
$rt->start();

$menu   = new TreeBuilder;
$menu->setData($data);

?>
<html>
<head>
<style>
.tree {
    font-size: 14px;
    font-family: sans-serif;
}
.tree ul {
    border-left: 1px dashed #ccc;
    padding-left: 10px;
    margin-left: 12px;
    margin-bottom: 10px;
    color: #0262f9;
}
.tree ul li {
    list-style: none;
    padding-left: 10px;
    margin-bottom: 3px;
}
.tree ul li:before {
    position: absolute;
    border-top: 1px dashed #ccc;
    width: 15px;
    height: 1px;
    content: "";
    margin: 7px 0px 0px -18px;
}
</style>
</head>
<body>

Random generated:
<div class="tree">
<?php

    echo $menu->showTree();
    //print_r($menu->getTree());

    $rt->end();

?>
</div>

</body>
</html>