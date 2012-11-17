# DataGrid [![Build Status](https://secure.travis-ci.org/widmogrod/data-grid.png?branch=master)](https://travis-ci.org/widmogrod/data-grid)
## Introduction

DataGrid is simple library for presentation different kinds of tabular data.
Is written in PHP5.3 and is still in development process.

## Installation
### Composer

  1. `cd my/project/directory`
  2. Create a `composer.json` file with following content:

     ```json
     {
         "require": {
             "widmogrod/data-grid": "dev-master"
         }
     }
     ```
  3. Run `php composer.phar install`


## How to use
### Doctrine 2

```php
// select
$dql = 'SELECT q FROM Question q JOIN q.answers';
/* @var $q \Doctrine\ORM\Query */
$q = $em->createQuery($dql);

$grid = DataGrid($q);
$grid->setRenderer(new Renderer\HtmlTable());
echo $grid->render();
```

### ArrayObject, array

```php
$data = array(
    array('user' => 'widmogrod'),
    array('user' => 'jhone'),
    array('user' => 'jim'),
);
$grid = new DataGrid($data);
$grid->setRenderer(new Renderer\HtmlTable());
echo $grid->render();
```
