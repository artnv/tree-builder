<?php
/*  

    https://github.com/artnv/TreeBuilder

    ------------------

    $tb = new TreeBuilder;

    $tb->setData($dataArr);     set array
    $tb->getTree();             return assoc array
    $tb->showTree();            echo html tree

*/

class TreeBuilder
{

    private $inputArr;
    private $inputArrLength;
    private $outputArr;
    private $html = '';

    // Строит html-дерево
    private function recursiveMakeVisualTree($arr)
    {
        $ln             = count($arr);
        $this->html     .= '<ul class="line">';

        while($ln--) {

            if(isset($arr[$ln]['child'])) {

                $this->html .= '<li>'.$arr[$ln]['title'].'</li>';
                $this->recursiveMakeVisualTree($arr[$ln]['child']);

            } else {
                $this->html .= '<li>'.$arr[$ln]['title'].'</li>';
            }

        }

        $this->html     .= '</ul>';
    }

    // Создание главных веток, у которых parent === 0
    private function makeMainTree()
    {
        $ln         = $this->inputArrLength;
        $inputArr   = $this->inputArr;
        
        while($ln--) {
           if($inputArr[$ln]['parent'] === 0) {
                $this->outputArr[] = $inputArr[$ln];
           }
        }

    }

    // Поиск дочерних элементов по общему массиву
    private function recursiveDeepSearch( & $outputArr)
    {

        $inputArr           = & $this->inputArr;
        $outputArrLength    = count($outputArr);

        // Пробегаемся по новому массиву $outputArr, по "родителям"
        while($outputArrLength--) {

            $inputArrLength = $this->inputArrLength;

            // Сравниваем с элементами из общего массива
            while($inputArrLength--) {

                if(isset($inputArr[$inputArrLength])) {

                    // Поиск дочерних элементов.
                    // После того как нашли потомка, добавляем его к родителю,
                    // далее переходим к найденному потомку и ищем уже его потомков в общем массиве
                    if($outputArr[$outputArrLength]['id'] === $inputArr[$inputArrLength]['parent']) {

                        $outputArr[$outputArrLength]['child'][] = $inputArr[$inputArrLength];
                        
                        unset($inputArr[$inputArrLength]);
  
                        $this->recursiveDeepSearch($outputArr[$outputArrLength]['child']);

                    }

                }

            }

        }

    }
    
    /* --------------------- public ---------------------- */

    public function setData($inputArr)
    {
        $this->inputArr          = $inputArr;
        $this->inputArrLength    = count($inputArr);
    }

    // Возвращает результат в виде массива
    // Если метод ранее вызывался, будет возвращать кешированный результат
    public function getTree()
    {

        if(isset($this->outputArr)) {

            return $this->outputArr;

        } else {

            $this->makeMainTree();
            $this->recursiveDeepSearch($this->outputArr);
            
            return $this->outputArr;

        }

    }

    // Возвращает html дерево с тегами
    public function showTree()
    {

        $this->recursiveMakeVisualTree(
            $this->getTree()
        );

        echo $this->html;

    }

}       
?>