# DataGrid [![Build Status](https://secure.travis-ci.org/widmogrod/data-grid.png?branch=master)](https://travis-ci.org/widmogrod/data-grid)
## Introduction

DataGrid is simple library for presentation different kinds of tabular data.
Is written in PHP5.3 and is still in development process.

If you wish to help me with this project or correct my english description - your help will be more than appreciated  :)

## Project road map

  * Features:
    * pagination
    * ordering
    * filters
    * translations
  * Documentation
  * Tests

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
### with Doctrine 2

```php
// select
$dql = 'SELECT q FROM Question q JOIN q.answers';
/* @var $q \Doctrine\ORM\Query */
$q = $em->createQuery($dql);

$grid = DataGrid($q);
$grid->setRenderer(new Renderer\HtmlTable());
echo $grid->render();
```

### with ArrayObject, array

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

### with your own adapter

To provide unknown adapter for new data types not supported by default in DataGrid
you should use one of following setups:

```php
$options = array(
    'dataTypesToAdapter' => array('Zend\Db\ResultSet\ResultSet' => 'My\DataGrid\Adapter\ResultSet'),
);
// or
$options = array(
    'dataTypesToAdapter' => array('Zend\Db\ResultSet\ResultSet' => 'ZendDbResultSet'),
    'invokableAdapters' => array('ZendDbResultSet' => 'My\DataGrid\Adapter\ResultSet')
);

// fetch result set
/** @var $resultSet \Zend\Db\ResultSet\ResultSet */
$resultSet = $this->select();

$grid = new DataGrid($resultSet, $options);
$grid->setRenderer(new Renderer\HtmlTable());
echo $grid->render();
```