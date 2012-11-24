<?php
require_once 'Bootstrap.php';

$data = array(
    array('user' => 'widmogrod'),
    array('user' => 'widmogrod2'),
    array('user' => 'widmogrod3'),
);
$grid = new \DataGrid\DataGrid($data);
$grid->setRenderer(new \DataGrid\Renderer\HtmlTable());
echo $grid->render();