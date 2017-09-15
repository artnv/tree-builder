<?php
require_once "modules/RuntimeTracker.php";
require_once "modules/TreeBuilder.php";
require_once "modules/Generator.php"; 

generate_data(5000); // creates a file "tmp_generated_data.php" (random parent)

if(file_exists('tmp_generated_data.php'))
{
    include "tmp_generated_data.php";
} else die('File include error');


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
<?php $menu->showTree(); ?>
<?php //print_r($menu->getTree()); ?>
</body>
</html>
<?php $rt->end(); ?>