<?php
require_once "../vendor/autoload.php";
require_once "modules/RuntimeTracker.php";
require_once "modules/Generator.php";

use TreeBuilder\TreeBuilder;

$maxItems = 500;
$data = generate_data($maxItems);
file_put_contents('example_data/tmp_random.php', $data);
$data = include_once "example_data/tmp_random.php";

$rt = new RuntimeTracker();
$rt->start();

?>
<!DOCTYPE html>
<html>
<head>
<style rel="stylesheet">
.tree {
	font-size: 14px;
	font-family: sans-serif;
}

.tree ul {
	white-space: nowrap;
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
	position: relative;
	border-top: 1px dashed #ccc;
	width: 15px;
	height: 1px;
	content: "";
	display: inline-block;
	margin: 0px 5px 4px -18px;
}
</style>
</head>
<body>

Random items: <?=$maxItems;?>
<div class="tree">
<?php
$tb = TreeBuilder::create($data, [], [], false);
echo $tb->showTree();

$rt->end();
?>
</div>

</body>
</html>