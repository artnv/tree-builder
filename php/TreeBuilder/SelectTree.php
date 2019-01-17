<?php
namespace TreeBuilder;

class SelectTree extends TreeBuilder implements TreeBuilderInterface
{

    public function rootNode($nodes, $firstStart, $userParams)
    {
        $selectMenu = '';

        if ($firstStart) {

            $selectMenu .= '<select name="select-tree">';
            $selectMenu .= $nodes;
            $selectMenu .= '</select>';

            return $selectMenu;
        }

        return $nodes;
    }

    private function getLineIcon($nestingLevel = 0)
    {
        if ($nestingLevel == 0) {
            $line = '╋';
        } else {
            $line = '┣';
        }

        while ($nestingLevel --) {
            $line .= '━';
        }

        return $line;
    }

    private function getSelectedElement($userParams, $id)
    {
        if (isset($userParams['selected'])) {
            if ($userParams['selected'] == $id) {
                return 'selected';
            }
        }

        return '';
    }

    public function childNode($item, $childNodes, $aliases, $nestingLevel, $userParams)
    {
        $id = $item[$aliases['id']];
        $title = $item[$aliases['title']];

        $lineIcon = $this->getLineIcon($nestingLevel);
        $selectedElement = $this->getSelectedElement($userParams, $id);

        // html
        $html = '';
        $html .= '<option ' . $selectedElement . ' value="' . $id . '">' . $lineIcon . ' ' . $title . '</option>';
        $html .= $childNodes;

        return $html;
    }
}

