<?php

use Phalcon\Mvc\Micro\Collection;

//Input the Causa Controller
$causaCollection= new Collection();

$causaCollection->setHandler(new CausaController());

$causaCollection->setPrefix('/causa');

$causaCollection->get('/', 'getAll');

$app->mount($causaCollection);
//Finish the causa controller routers
