<?php
require_once 'Bootstrap.php';

$data = array(
    array('user' => 'widmogrod'),
    array('user' => 'widmogrod2'),
    array('user' => 'widmogrod3'),
);
$grid = new \DataGrid\DataGrid($data);
$grid->setRenderer(new \DataGrid\Renderer\HtmlTable());

// new column - action
$grid->setSpecialColumn('length', function ($row) {
    return strlen($row['user']);
});
// overwrite column - user
$grid->setSpecialColumn('user', function ($row) {
    return strtoupper($row['user']);
});

echo $grid->render();