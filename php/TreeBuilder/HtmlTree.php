<?php
namespace TreeBuilder;

class HtmlTree extends TreeBuilder implements TreeBuilderInterface
{

    public function rootNode($nodes, $firstStart, $userParams)
    {
        $options = $firstStart ? 'class="tree-root"' : 'class="tree-child"';

        return ('<ul " ' . $options . '>' . $nodes . '</ul>');
    }

    public function childNode($item, $childNodes, $aliases, $nestingLevel, $userParams)
    {
        $id = $item[$aliases['id']];
        $parent = $item[$aliases['parent']];
        $title = $item[$aliases['title']];

        // html
        $html = '';
        $html .= '<li class="tree-item">';
        $html .= ('<a href="#id_' . $id . '+parent_' . $parent . '" title="id: ' . $id . ', parent: ' . $parent . '">' . $title . '</a>');
        $html .= $childNodes;
        $html .= '</li>';

        return $html;
    }
}

