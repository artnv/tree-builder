<?php
require_once "modules/RuntimeTracker.php";
require_once "modules/TreeBuilder.php";

$rt = new RuntimeTracker;
$rt->start();

$data = [
    [
        'id'        => 1,
        'title'     => 'Electronics',
        'parent'    => 0
    ],    
    [
        'id'        => 2,
        'title'     => 'Audio',
        'parent'    => 1
    ],   
    [
        'id'        => 3,
        'title'     => 'Photographic equipment',
        'parent'    => 1
    ],    
    [
        'id'        => 4,
        'title'     => 'DSLR',
        'parent'    => 3
    ],    
    [
        'id'        => 5,
        'title'     => 'Laptops',
        'parent'    => 1
    ],    
    [
        'id'        => 7,
        'title'     => 'Tablet PC',
        'parent'    => 1
    ],    
    [
        'id'        => 8,
        'title'     => 'E-books',
        'parent'    => 1
    ],    
    [
        'id'        => 9,
        'title'     => 'Accessories',
        'parent'    => 1
    ],    
    [
        'id'        => 10,
        'title'     => 'Netbooks',
        'parent'    => 5
    ],    
    [
        'id'        => 11,
        'title'     => 'Ultrabooks',
        'parent'    => 5
    ],    
    [
        'id'        => 12,
        'title'     => 'Gaming laptops',
        'parent'    => 5
    ],    
    [
        'id'        => 13,
        'title'     => '4Good',
        'parent'    => 7
    ],    
    [
        'id'        => 14,
        'title'     => 'Apple',
        'parent'    => 7
    ],    
    [
        'id'        => 15,
        'title'     => 'Asus',
        'parent'    => 7
    ],    
    [
        'id'        => 16,
        'title'     => 'Dexp',
        'parent'    => 7
    ],    
    [
        'id'        => 17,
        'title'     => '7 inches',
        'parent'    => 14
    ],    
    [
        'id'        => 18,
        'title'     => '9 inches',
        'parent'    => 14
    ],    
    [
        'id'        => 19,
        'title'     => '10.1 inches',
        'parent'    => 14
    ],    
    [
        'id'        => 20,
        'title'     => 'Charging device',
        'parent'    => 1
    ],    
    [
        'id'        => 21,
        'title'     => 'Headphones',
        'parent'    => 2
    ],    
    [
        'id'        => 22,
        'title'     => 'In-Ear Headphones',
        'parent'    => 21
    ],    
    [
        'id'        => 23,
        'title'     => 'Gaming headsets',
        'parent'    => 21
    ],    
    [
        'id'        => 24,
        'title'     => 'Wireless headphones',
        'parent'    => 21
    ],    
    [
        'id'        => 25,
        'title'     => 'Bluetooh',
        'parent'    => 24
    ],    
    [
        'id'        => 26,
        'title'     => 'Wi-fi',
        'parent'    => 24
    ],    
    [
        'id'        => 27,
        'title'     => 'Behind-the-Head Headphones',
        'parent'    => 26
    ],    
    [
        'id'        => 28,
        'title'     => 'Classics',
        'parent'    => 26
    ],    
    [
        'id'        => 29,
        'title'     => 'Sony',
        'parent'    => 27
    ],    
    [
        'id'        => 30,
        'title'     => 'Yamaha',
        'parent'    => 27
    ],    
    [
        'id'        => 31,
        'title'     => 'Sven',
        'parent'    => 27
    ],    
    [
        'id'        => 32,
        'title'     => '2017',
        'parent'    => 31
    ],    
    [
        'id'        => 33,
        'title'     => '2016',
        'parent'    => 31
    ],    
    [
        'id'        => 34,
        'title'     => '2015',
        'parent'    => 31
    ],    
    [
        'id'        => 35,
        'title'     => '2014',
        'parent'    => 31
    ],    
    [
        'id'        => 36,
        'title'     => 'Red',
        'parent'    => 49
    ],    
    [
        'id'        => 37,
        'title'     => 'White',
        'parent'    => 49
    ],    
    [
        'id'        => 38,
        'title'     => 'Black',
        'parent'    => 49
    ],    
    [
        'id'        => 39,
        'title'     => 'Blue',
        'parent'    => 49
    ],    
    [
        'id'        => 40,
        'title'     => 'Compact cameras',
        'parent'    => 3
    ],    
    [
        'id'        => 41,
        'title'     => 'Nikon',
        'parent'    => 4
    ],    
    [
        'id'        => 42,
        'title'     => 'Canon',
        'parent'    => 4
    ],    
    [
        'id'        => 43,
        'title'     => 'Sony',
        'parent'    => 40
    ],    
    [
        'id'        => 44,
        'title'     => 'Pentax',
        'parent'    => 4
    ],    
    [
        'id'        => 45,
        'title'     => 'Samsung',
        'parent'    => 40
    ],    
    [
        'id'        => 46,
        'title'     => 'D750',
        'parent'    => 41
    ],    
    [
        'id'        => 47,
        'title'     => 'D810',
        'parent'    => 41
    ],    
    [
        'id'        => 48,
        'title'     => 'D3300',
        'parent'    => 41
    ],    
    [
        'id'        => 49,
        'title'     => 'Colors',
        'parent'    => 35
    ],    
    [
        'id'        => 50,
        'title'     => 'Small',
        'parent'    => 39
    ],    
    [
        'id'        => 51,
        'title'     => 'Big',
        'parent'    => 39
    ],    
    [
        'id'        => 52,
        'title'     => 'Batteries',
        'parent'    => 51
    ],    
    [
        'id'        => 53,
        'title'     => 'Accu',
        'parent'    => 51
    ],    
    [
        'id'        => 54,
        'title'     => 'NiCd',
        'parent'    => 57
    ],    
    [
        'id'        => 55,
        'title'     => 'Ni-MH',
        'parent'    => 57
    ],    
    [
        'id'        => 56,
        'title'     => 'New',
        'parent'    => 53
    ],    
    [
        'id'        => 57,
        'title'     => 'Old',
        'parent'    => 53
    ],    
    [
        'id'        => 58,
        'title'     => 'Li-ion',
        'parent'    => 56
    ],    
    [
        'id'        => 59,
        'title'     => 'Li-ion polymer',
        'parent'    => 56
    ],    
    [
        'id'        => 60,
        'title'     => 'LSD NiMH',
        'parent'    => 56
    ]
];

$menu = new TreeBuilder;
$menu->setData($data);

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

<div class="tree">
<?php

    echo $menu->showTree();
    //print_r($menu->getTree());

    $rt->end();
 
?>
</div>

</body>
</html>
