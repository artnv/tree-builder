<?php
namespace TreeBuilder;

interface TreeBuilderInterface
{

    public function rootNode($nodes, $firstStart, $userParams);

    public function childNode($item, $childNodes, $aliases, $nestingLevel, $userParams);
}