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
$grid->setStateStorage(new StateStorage\Get('namespace'));

$_GET = array(
    'namespace' => array(
        'columns' => array(
            'name' => array(
                'actions' => array(
                    'order' => 'desc',
                    'like' => '%a%',
                    'hide' => true,
                )
            )
        ),
        'page' => 1,
        'limit' => 10,
    )
);

$c->getActionsForColumn($columnName);
$c->getPage();
$c->getLimit();

$columnInfo->setName('name');
$columnInfo->getOption('');

$grid->getAdapter()->action($action, $column, $value);
$grid->getAdapter()->limit(3);
$grid->getAdapter()->page(1);

echo $grid->render();

// ->
$this->trigger('render.pre');
$adapter->changeLimit($e); // 1
$adapter->changePage($e); // 1
$adapter->changeOrder($e); // 1
