<?php
require_once 'Bootstrap.php';

$data = array(
    array('user' => 'widmogrod', 'age' => 10,),
    array('user' => 'widmogrod2', 'age' => 11,),
    array('user' => 'widmogrod3', 'age' => 12,),
    array('user' => 'widmogrod4', 'age' => 13,),
    array('user' => 'widmogrod5', 'age' => 14),
    array('user' => 'widmogrod6', 'age' => 15,),
);
$grid = new \DataGrid\DataGrid($data);
$grid->setRenderer(new \DataGrid\Renderer\HtmlTable());
$grid->setSpecialColumn('user', array(
    'actions' => array(
        'order' => 'desc'
    ),
));
echo $grid->render();