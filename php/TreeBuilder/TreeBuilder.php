<?php

/*  

    https://github.com/artnv/TreeBuilder
    
    v: 0.2
    ------------------
    
    $tb = TreeBuilder::create($dataArr, null, null, false);
        create($inputArr, $aliases = null, $userParams = [], $sort_enabled = true);
    
    Входные данные для построения дерева.
    Обязательные поля: id, parent, title и position (если используется сортировка)
    
    $dataArr = [
        'id' => 1
        'parent_id' => 0
        'img' => '123.jpg'
        'name' => 'Category #1'
        'keywords' => ''
        'description' => ''
        'position' => 2
    ];
    
    
    Алиасы.
    Данные из разных источников емеют разное название полей, чтобы их не менять, просто укажите их в качестве значений у ключей.
    Если алиасы не переданы в качестве аргумента, то используются по умолчанию:
    
    $aliases = [
        'id' => 'id',
        'parent' => 'parent',
        'title' => 'title',
        'child' => 'child',
        'position' => 'position',
    ];

    Параметры пользователя.
    Будут доступны в шаблонных методах rootNode и childNode
    $userParams = [];
    
    Сортировка.
    По умолчанию $sort_enabled = true;
    Во массиве должен быть ключ ['position'] чтобы сортировка работала, если его нет, отключите сортировку.
    Для каждого узла с одним родителем ['parent_id'] позиция начинается с нуля и сортирует от большего числа к меньшему.

    Примеры использования:
    $tb->getTree(); - возвращает ассоциативный массив
    $tb->showTree(); - возвращает html дерево на основе шаблона
    $tb->getParents($node); - возвращает ассоциативный массив с цепочкой родительских узлов типа "хлебных крошек"
    $tb->getChilds($node); - возвращает ассоциативный массив с потомками конкретного узла
    
    Шаблона оформления дерева.
    В директории уже есть готовые примеры HtmlTree.php и SelectTree.php, а если вам нужен свой шаблон, то отнаследуйтесь от TreeBuilder и реализуйте интерфейс TreeBuilderInterface с двумя методами:
    
    Дочерние узлы - childNode($item, $childNodes, $aliases, $nestingLevel, $userParams);
        $item - текущий элемент массива
        $childNodes - дочерние узлы текущего родителя
        $aliases - алиасы
        $nestingLevel - уровень вложенности (на основе этого значения можно добавлять линию для визуального оформления)
        $userParams - параметры пользователя
        
    Корневой узел - rootNode($nodes, $firstStart)
        $nodes это данные из childNode.
        $firstStart = true, при первом запуске
    

*/
include_once "TreeBuilderInterface.php";

class TreeBuilder implements TreeBuilderInterface
{

    private $inputArr;
    private $inputTmpArr;
    private $inputArrLength;
    private $outputArr;
    private $parentsArr;
    private $childsArr;
    private $html;
    private $userParams;
    private $sort_enabled;
    private $nestingLevel = 0;
    private $aliases = [
        'id' => 'id',
        'parent' => 'parent',
        'title' => 'title',
        'child' => 'child',
        'position' => 'position',
    ];

    public function rootNode($nodes, $firstStart, $userParams)
    {
        $options = $firstStart ? 'class="tree-root"' : 'class="tree-child"';

        return ('<ul " '.$options.'>'.$nodes.'</ul>');
    }

    public function childNode($item, $childNodes, $aliases, $nestingLevel, $userParams)
    {
        $linkHref = '#';
        $title = $item[$aliases['title']];

        // html
        $html = '';
        $html .= '<li class="tree-item">';
        $html .= ('<a href="'.$linkHref.'">'.$title.'</a>'); 
        $html .= $childNodes;
        $html .= '</li>';

        return $html;
    }

    // Строит html-дерево
    private function makeRecursiveVisualTree($arr, $firstStart = null, $nestingLevel = 0)
    {
        $nodes = '';
        $ln = count($arr);

        while ($ln--) {

            $childNodes = null;

            if (isset($arr[$ln][$this->aliases['child']])) {
                $this->nestingLevel++;
                $childNodes = $this->makeRecursiveVisualTree($arr[$ln][$this->aliases['child']], false, $this->nestingLevel);
            }

            $nodes .= $this->childNode($arr[$ln], $childNodes, $this->aliases, $nestingLevel, $this->userParams);
        }
        
        $this->nestingLevel = 0;
        $this->html = $this->rootNode($nodes, $firstStart, $this->userParams);

        return $this->html;
    }

    // Создание главных веток, у которых parent == 0
    private function makeMainTree()
    {

        $ln = $this->inputArrLength;
        $inputTmpArr = &$this->inputTmpArr;

        while ($ln--) {
           if ($inputTmpArr[$ln][$this->aliases['parent']] == 0) {
                $this->outputArr[] = $inputTmpArr[$ln];
                unset($inputTmpArr[$ln]); // Удаляем родительские узлы с parent = 0;
           }
        }

        $this->outputArr = $this->sort($this->outputArr);
    }

    // Рекурсивный поиск дочерних элементов по общему массиву
    private function recursiveSearch(&$outputArr)
    {
        $aliases = $this->aliases;
        $outputArrLength = count($outputArr);

        // Пробегаемся по новому массиву $outputArr, по "родителям"
        while ($outputArrLength--) {

            $inputArrLength = $this->inputArrLength;

            // Сравниваем с элементами из общего массива
            while ($inputArrLength--) {

                if (isset($this->inputTmpArr[$inputArrLength])) {

                    /* 
                        Поиск дочерних элементов.
                        После того как нашли потомка, добавляем его к родителю,
                        далее переходим к найденному потомку и ищем уже его потомков в общем массиве 
                    */
                    if ($outputArr[$outputArrLength][$aliases['id']] == $this->inputTmpArr[$inputArrLength][$aliases['parent']]) {

                        if(!isset($outputArr[$outputArrLength][$aliases['child']])) {
                            $outputArr[$outputArrLength][$aliases['child']] = [];
                        }
                        
                        // Добавляем потомка в новый массив, к его родителю
                        $outputArr[$outputArrLength][$aliases['child']][] = $this->inputTmpArr[$inputArrLength];

                        // Удаляем чтобы повторно с ним не работать
                        unset($this->inputTmpArr[$inputArrLength]);
                        
                        // Ищем потомков у найденного потомка
                        $this->recursiveSearch($outputArr[$outputArrLength][$aliases['child']]);

                    }

                }

            }

            // Сортируем потомков
            if (isset($outputArr[$outputArrLength][$aliases['child']])) {
                $outputArr[$outputArrLength][$aliases['child']] = $this->sort($outputArr[$outputArrLength][$aliases['child']]);
            }
        }

    }

    public function resetTmpData()
    {
        $this->inputTmpArr = $this->inputArr;
    }

    public static function create($inputArr, $aliases = null, $userParams = [], $sort_enabled = true)
    {
        $tb = new static();
        $tb->setData($inputArr, $aliases, $userParams, $sort_enabled);
        return $tb;
    }

    public function setData($inputArr, $aliases = null, $userParams = [], $sort_enabled = true)
    {
        $this->html = '';
        $this->outputArr = [];
        $this->userParams = $userParams;
        $this->inputArr = $inputArr;
        $this->inputArrLength = count($inputArr);
        $this->sort_enabled = $sort_enabled;
        
        // Псевдонимы входных данных
        if ($aliases) {
            foreach ($aliases as $alias => $val) {
                if ($this->aliases[$alias]) {
                    $this->aliases[$alias] = $val;
                } 
            }
        }

    }

    // Возвращает результат в виде массива
    // Если метод ранее вызывался, будет возвращать кешированный результат
    public function getTree()
    {
        if ($this->outputArr) {
            return $this->outputArr;
        } else {
            $this->resetTmpData();
            $this->makeMainTree();
            $this->recursiveSearch($this->outputArr);
            
            return $this->outputArr;
        }
    }

    // Возвращает html дерево с тегами
    // Если метод ранее вызывался, будет возвращать кешированный результат
    public function showTree()
    {
        if ($this->html) {
            return $this->html;
        } else {
            return $this->makeRecursiveVisualTree($this->getTree(), true);
        }
    }

    // Поиск родительских узлов, (например для хлебных крошек)
    private function recursiveParentSearch($node)
    {
        $i = $this->inputArrLength;
        $inputTmpArr = $this->inputTmpArr;
        
        while ($i--) {
            if ($inputTmpArr[$i][$this->aliases['id']] == $node[$this->aliases['parent']]) {
               $this->parentsArr[] = $inputTmpArr[$i];
               $this->recursiveParentSearch($inputTmpArr[$i]);
            }
        }
    }    

    // Поиск дочерних узлов
    private function childSearch($node)
    {
        $i = $this->inputArrLength;
        $inputTmpArr = $this->inputTmpArr;
        
        while ($i--) {
            if ($inputTmpArr[$i][$this->aliases['parent']] == $node[$this->aliases['id']]) {
               $this->childsArr[] = $inputTmpArr[$i];
            }
        }
    }

    protected function sort($arr)
    {
        if (!$this->sort_enabled) {
            return $arr;
        }

        if ($arr && count($arr) >= 1) {

            usort($arr, function($a, $b){
                return ($a[$this->aliases['position']] - $b[$this->aliases['position']]);
            });
        }

        return $arr;
    }

    // Возвращает массив с цепочкой родительских узлов
    public function getParents($node)
    {
        $this->parentsArr = [];
        $this->parentsArr[] = $node;
        $this->resetTmpData();
        $this->recursiveParentSearch($node);
        
        return $this->parentsArr;
    }

    // Возвращает дочерние узлы (не рекурсивный, не ищет потомков у найденных потомков)
    public function getChilds($node)
    {
        $this->childsArr = [];
        $this->resetTmpData();
        $this->childSearch($node);
        
        return $this->childsArr;
    }
}       
?>