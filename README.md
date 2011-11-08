# Introduction

DataGrid is simple library for presentation different kinds of tabular data.
Is writen in PHP5.3 and is still in development.

# How to use

```
$dql = 'SELECT q FROM Question q JOIN q.answers';
/* @var $q \Doctrine\ORM\Query */
$q = $em->createQuery($dql);
$grid = DataGrid::factory($q);
$grid->setRenderer(new HtmlTable());
echo $grid->toString();
```

P.S. Sory for my english.
