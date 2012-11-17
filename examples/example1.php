<?php
require_once 'Bootstrap.php';

$data = array(
    array('user' => 'widmogrod'),
    array('user' => 'widmogrod2'),
    array('user' => 'widmogrod3'),
);

//$options = array(
//    'dataTypesToAdapter' => array('array' => 'ArrayObject'),
//    'invokableAdapters' => array('ArrayObject' => 'DataGrid\Adapter\ArrayObject')
//);
$options = array();
$grid = new \DataGrid\DataGrid($data, $options);
$grid->setRenderer(new \DataGrid\Renderer\HtmlTable());
echo $grid->render();