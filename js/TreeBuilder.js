/*

    https://github.com/artnv/TreeBuilder

    v: 0.1.1
    ----------

    var x   = new TreeBuilder();

    x.setData(data);
    x.getTree();            // return array of objects
    x.showTree();           // return html tree
   

*/

var TreeBuilder = (function() {

    var
        TB;
    // --

    TB = function() {

        // Если конструктор вызван без new, возвращаем с new
        if (!(this instanceof TB)) {
            return new TB();
        }

        this.stateMap    = {
            inputArr        : undefined,
            inputArrLength  : undefined,
            outputArr       : []
        };

        this.html = '';

    };

    // Создание главных веток, у которых parent == 0
    TB.prototype._makeMainTree = function() {

        var
            ln          = this.stateMap.inputArrLength,
            inputArr    = this.stateMap.inputArr,
            outputArr   = this.stateMap.outputArr;
        // --

        while(ln--) {
           if(inputArr[ln].parent == 0) {
                outputArr.push(inputArr[ln]);
           }
        }

    };

    // Строит html-дерево
    TB.prototype._recursiveMakeVisualTree = function(arr) {

        var
            ln  = arr.length;
        // --

        this.html    += '<ul>';

        while(ln--) {

            if(arr[ln].child) {

                this.html += '<li>' + arr[ln].title + '</li>';
                this._recursiveMakeVisualTree(arr[ln].child);

            } else {
                this.html += '<li>' + arr[ln].title + '</li>';
            }

        }

        this.html += '</ul>';
    };

    // Рекурсивный поиск дочерних элементов по общему массиву
    TB.prototype._recursiveDeepSearch = function(outputArr) {

        var
            inputArr            = this.stateMap.inputArr,
            outputArrLength     = outputArr.length,
            inputArrLength;
        // --

        // Пробегаемся по новому массиву outputArr, по "родителям"
        while(outputArrLength--) {

            inputArrLength      = this.stateMap.inputArrLength;

            // Сравниваем с элементами из общего массива
            while(inputArrLength--) {

                if(inputArr[inputArrLength]) {

                    /* 
                        Поиск дочерних элементов.
                        После того как нашли потомка, добавляем его к родителю,
                        далее переходим к найденному потомку и ищем уже его потомков в общем массиве 
                    */
                    if(outputArr[outputArrLength].id == inputArr[inputArrLength].parent) {

                        if(!outputArr[outputArrLength].child) {
                            outputArr[outputArrLength].child = [];
                        }

                        // Добавляем потомка в новый массив, к его родителю
                        outputArr[outputArrLength].child.push(inputArr[inputArrLength]);

                        // Удаляем чтобы повторно с ним не работать
                        delete inputArr[inputArrLength];
                        
                        // Ищем потомков у найденного потомка
                        this._recursiveDeepSearch(outputArr[outputArrLength].child);

                    }

                }

            }

        }

    };

    TB.prototype.setData = function(arr) {

        this.html                       = '';
        this.stateMap.outputArr         = [];

        this.stateMap.inputArr          = JSON.parse(JSON.stringify(arr)); // Копирование массива
        this.stateMap.inputArrLength    = arr.length;

    };

    // Возвращает результат в виде массива
    // Если метод ранее вызывался, будет возвращать кешированный результат
    TB.prototype.getTree =  function () {

        var 
            outputArr = this.stateMap.outputArr;
        // --

        if(outputArr.length > 0) {

            return outputArr;

        } else {

            this._makeMainTree();
            this._recursiveDeepSearch(outputArr);

            return outputArr;

        }

    };

    // Возвращает html дерево с тегами
    // Если метод ранее вызывался, будет возвращать кешированный результат    
    TB.prototype.showTree = function() {

        if(this.html) {

            return this.html;

        } else {

            this._recursiveMakeVisualTree(
                this.getTree()
            );

            return this.html;

        }

    };

    return TB;

}());