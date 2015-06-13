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

$andamentoCollection= new Collection();
$andamentoCollection->setHandler(new AndamentoController());
$andamentoCollection->get('/andamento/{id:[0-9]+}', 'get');
$andamentoCollection->get('/causa/{idCausa:[0-9]+}/andamento', 'getByCausa');
$andamentoCollection->get('/andamento', 'getAll');
$andamentoCollection->post('/andamento', 'post');
$andamentoCollection->put('/andamento/{id:[0-9]+}', 'put');
$andamentoCollection->delete('/andamento/{id:[0-9]+}', 'delete');
$app->mount($andamentoCollection);



$assistidoCollection= new Collection();
$assistidoCollection->setHandler(new AssistidoController());
$assistidoCollection->setPrefix('/assistido');
$assistidoCollection->get('/{id:[0-9]+}', 'get');
$assistidoCollection->get('/', 'getAll');
$assistidoCollection->post('/', 'post');
$assistidoCollection->put('/{id:[0-9]+}', 'put');
$assistidoCollection->delete('/{id:[0-9]+}', 'delete');
$app->mount($assistidoCollection);



$parte_contrariaCollection= new Collection();
$parte_contrariaCollection->setHandler(new ParteContrariaController());
$parte_contrariaCollection->get('/partecontraria/{id:[0-9]+}', 'get');
$parte_contrariaCollection->get('/partecontraria', 'getAll');
$parte_contrariaCollection->post('/partecontraria', 'post');
$parte_contrariaCollection->put('/partecontraria/{id:[0-9]+}', 'put');
$parte_contrariaCollection->delete('/partecontraria/{id:[0-9]+}', 'delete');
$app->mount($parte_contrariaCollection);
