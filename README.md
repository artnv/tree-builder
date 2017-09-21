# TreeBuilder
```
php v0.1.1
js  v0.1.1
```

Библиотека для построения вложенных списков по типу родитель-потомок.
Можно применять для создания меню, списка категорий, вложенных комментариев и т.д.

Возможности:
* **Уровень вложенности не ограничен**
* **Элементы в массиве могут идти непоследовательно, т.е. Потомок может быть выше или ниже родителя**
* **Библиотека доступна в двух версиях, для PHP и для Javascript**

Пример: https://artnv.github.io/TreeBuilder/index.html

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

### PHP

- `$tb = new TreeBuilder;` - Новый экземпляр
- `$tb->setData($dataArr);` - Установка массива с данными
- `$tb->getTree();` - Возвращает новый ассоциативный массив
- `$tb->showTree();` - Создает дерево в формате html (ul -> li), из массива

```php

    $tb = new TreeBuilder;

    $tb->setData([
        [
            'id'        => 1,
            'title'     => 'Electronics',
            'parent'    => 0
        ],    
        [
            'id'        => 2,
            'title'     => 'Audio',
            'parent'    => 1
        ]
    ]);

    print_r( $tb->getTree() );      // assoc array list
    echo $tb->showTree();           // <ul><li>Electronics</li><ul><li>Audio</li></ul></ul>

```
