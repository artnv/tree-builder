<?php
include_once "modules/RuntimeTracker.php";
include_once "TreeBuilder/HtmlTree.php";
include_once "TreeBuilder/SelectTree.php";

$data = include "example_data/shop.php";

$rt = new RuntimeTracker;
$rt->start();

$selectTree = SelectTree::create($data, [], ['selected' => 2], false)->showTree();

$htmlTreeWithSort = HtmlTree::create($data, [], [])->showTree();

$_htmlTree = HtmlTree::create($data, [], [], false);
$htmlTree = $_htmlTree->showTree();

$parents = $_htmlTree->getParents(['id' => 777, 'title' => 'this', 'parent' => 24]);
$childs = $_htmlTree->getChilds(['id' => 56]);

function getBreadcrumbs($arr) {
    $ln = count($arr);
    $tmp = '';
    while($ln--) {
        $tmp .= (' > ' . '<strong>'. $arr[$ln]['title'] . '</strong>');
    }
    return ('Main page' . $tmp);
}
?>
<!DOCTYPE html>
<html>
<head>
<style rel="stylesheet">
.main {
    font-size: 14px;
    font-family: sans-serif;
    width: 960px;
    margin: 0 auto 100px auto;
}
.result {
    padding: 10px;
    border: 1px dashed #333;
    background-color: #f1f1f1;
    margin-bottom: 40px;
}
.result select {
 
    height: 30px;
}
.main ul {
    white-space: nowrap;
    border-left: 1px dashed #ccc;
    padding-left: 10px;
    margin-left: 12px;
    margin-bottom: 10px;
    color: #0262f9;
}
.main ul li {
    list-style: none;
    padding-left: 10px;
    margin-bottom: 3px;
}
.main ul li:before {
    position: relative;
    border-top: 1px dashed #ccc;
    width: 15px;
    height: 1px;
    content: "";
    display: inline-block;
    margin: 0px 5px 4px -18px;
}
.pull-right {
    float: right;
    width: 50%;
}
.pull-left {
    float: left;
    width: 50%;
}
.clear {
    clear: both;
}
</style>
</head>
<body>
<div class="main">

<h2>(HtmlTree.php)->showTree()</h2>
<div class="result">
    <div class="pull-right"><p><strong>Sort with ['position']</strong></p><?=$htmlTreeWithSort;?></div>
    <div class="pull-left"><p><strong>Default</strong></p><?=$htmlTree;?></div>
    <div class="clear"></div>
</div>

<h2>(SelectTree.php)->showTree()</h2>
<div class="result"><?=$selectTree;?> $userParams['selected' => 2]</div>

<h2>->getParents(['parent' => 24])</h2>
<div class="result">
    <p>As breadcrumbs:<br> <?=getBreadcrumbs($parents);?></p>
    <pre><?=print_r($parents);?></pre>
</div>

<h2>->getChilds(['id' => 56])</h2>
<div class="result">
    <pre><?=print_r($childs);?></pre>
</div>

<?php
    // RuntimeTracker 
    $rt->end();
?>
</div><!--/.main-->
</body>
</html>