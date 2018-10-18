# TreeBuilder
```
php v0.2
js  v0.1.1
```

Библиотека для построения вложенных списков по типу родитель-потомок (Adjacency list).
Можно применять для создания меню, списка категорий, вложенных комментариев, хлебных крошек и т.д.

Возможности:
* **Уровень вложенности не ограничен**
* **Элементы в массиве могут идти непоследовательно, т.е. Потомок может быть выше или ниже родителя**
* **Библиотека доступна в двух версиях, для PHP и для Javascript**

Пример: https://artnv.github.io/tree-builder/index.html
**Еще больше примеров вы найдете в директории /php**

### PHP

```php
$tb = TreeBuilder::create($dataArr, null, null, false);
// create($inputArr, $aliases = null, $userParams = [], $sort_enabled = true);
```

**Входные данные для построения дерева**  
Обязательные поля: `id`, `parent`, `title` и `position` (если используется сортировка)

```php
$dataArr = [
    'id' => 1
    'parent_id' => 0
    'img' => '123.jpg'
    'name' => 'Category #1'
    'keywords' => ''
    'description' => ''
    'position' => 2
];
```

**Алиасы**  
Данные из разных источников емеют разное название полей, чтобы их не менять, просто укажите их в качестве значений у ключей.  
Если алиасы не переданы в качестве аргумента, то используются по умолчанию:

```php
$aliases = [
    'id' => 'id',
    'parent' => 'parent',
    'title' => 'title',
    'child' => 'child',
    'position' => 'position',
];
```

**Параметры пользователя**  
Будут доступны в шаблонных методах rootNode и childNode

```php
$userParams = [];
```

**Сортировка**  
```php
$sort_enabled = true;
```
По умолчанию - true. В массиве должен быть ключ `['position']` чтобы сортировка работала, если его нет, отключите сортировку.  
Для каждого узла с одним родителем `['parent_id']` позиция начинается с нуля и сортирует от большего числа к меньшему.

**Шаблоны оформления дерева**  
В директории уже есть готовые примеры `HtmlTree.php` и `SelectTree.php`, а если вам нужен свой шаблон, то отнаследуйтесь от TreeBuilder и реализуйте интерфейс TreeBuilderInterface с двумя методами:  

Дочерние узлы  
```php
childNode($item, $childNodes, $aliases, $nestingLevel, $userParams);
```
* `$item` - текущий элемент массива
* `$childNodes` - дочерние узлы текущего элемента-родителя
* `$aliases` - алиасы
* `$nestingLevel` - уровень вложенности (на основе этого значения можно добавлять линию для визуального оформления)
* `$userParams` - параметры пользователя

Корневой узел  
```php
rootNode($nodes, $firstStart);
```
* `$nodes` - это данные из childNode()
* `$firstStart` - true, при первом запуске

**Примеры использования**  

```php
$node_1 = ['parent' => 24];
$node_2 = ['id' => 888];
```
* `$tb->getTree()` - возвращает ассоциативный массив
* `$tb->showTree()` - возвращает html дерево на основе шаблона
* `$tb->getParents($node_1)` - возвращает ассоциативный массив с цепочкой родительских узлов типа "хлебных крошек"
* `$tb->getChilds($node_2)` - возвращает ассоциативный массив с потомками конкретного узла



### JavaScript

- `var tb = new TreeBuilder();` - Вызов конструктора
- `tb.setData(data);` - Установка массива с данными
- `tb.getTree();` - Возвращает новый массив с объектами
- `tb.showTree();` - Создает дерево в формате html (ul -> li), из массива с объектами

```js

    tb = new TreeBuilder();

    tb.setData([
        {
            id        : 1,
            title     : 'Electronics',
            parent    : 0
        },    
        {
            id        : 2,
            title     : 'Audio',
            parent    : 1
        } 
    ]);

    console.log( tb.getTree() );        // array
    document.write( tb.showTree() );    // <ul><li>Electronics</li><ul><li>Audio</li></ul></ul>

```
