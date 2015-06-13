<?php


use Phalcon\Mvc\Micro\Collection;

//Input the Causa Controller
$causaCollection= new Collection();

$causaCollection->setHandler(new CausaController());

$causaCollection->setPrefix('/causa');

//Agrupar por rota "/"
$causaCollection->get('/', 'getAll');

$causaCollection->post('/', 'post');

$causaCollection->options('/', 'getAll');

//Agrupar por rota "/{id}"
$causaCollection->get('/{id}', 'getOne');


$app->mount($causaCollection);
//Finish the causa controller routers


$assistidoCollection= new Collection();

$assistidoCollection->setHandler(new AssistidoController());
$assistidoCollection->setPrefix('/assistido');

$assistidoCollection->get('/{id:[0-9]+}', 'get');
$assistidoCollection->get('/', 'getAll');
$assistidoCollection->post('/', 'post');
$assistidoCollection->put('/{id:[0-9]+}', 'put');
$assistidoCollection->delete('/{id:[0-9]+}', 'delete');

$app->mount($assistidoCollection);
