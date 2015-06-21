<?php

use Phalcon\Mvc\Micro\Collection;


//Input the Causa Controller
$causaCollection= new Collection();

$causaCollection->setHandler(new CausaController());

$causaCollection->setPrefix('/causa');

//Agrupar por rota "/"
$causaCollection->get('/{id:[0-9]+}', 'get');
$causaCollection->get('/', 'getAll');

$causaCollection->post('/', 'post');
$causaCollection->put('/{id:[0-9]+}', 'put');
$causaCollection->delete('/{id:[0-9]+}', 'delete');
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

$areaAtendimentoCollection= new Collection();
$areaAtendimentoCollection->setHandler(new AreaAtendimentoController());
$areaAtendimentoCollection->setPrefix('/area_atendimento');
$areaAtendimentoCollection->get('/{id:[0-9]+}', 'get');
$areaAtendimentoCollection->get('/', 'getAll');
$areaAtendimentoCollection->post('/', 'post');
$areaAtendimentoCollection->put('/{id:[0-9]+}', 'put');
$areaAtendimentoCollection->delete('/{id:[0-9]+}', 'delete');
$app->mount($areaAtendimentoCollection);


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
$parte_contrariaCollection->setPrefix('/partecontraria');
$parte_contrariaCollection->get('/{id:[0-9]+}', 'get');
$parte_contrariaCollection->get('/', 'getAll');
$parte_contrariaCollection->post('/', 'post');
$parte_contrariaCollection->put('/{id:[0-9]+}', 'put');
$parte_contrariaCollection->delete('/{id:[0-9]+}', 'delete');
$app->mount($parte_contrariaCollection);


$testemunhaCollection= new Collection();
$testemunhaCollection->setHandler(new AssistidoController());
$testemunhaCollection->setPrefix('/testemunha');
$testemunhaCollection->get('/{id:[0-9]+}', 'get');
$testemunhaCollection->get('/', 'getAll');
$testemunhaCollection->post('/', 'post');
$testemunhaCollection->put('/{id:[0-9]+}', 'put');
$testemunhaCollection->delete('/{id:[0-9]+}', 'delete');
$app->mount($testemunhaCollection);


$relatorios = new Collection();
$relatorios->setHandler(new RelatorioController());
//$relatorios->get('/causa/{id:[0-9]+}/fichaPrimeiroAtendimento', 'getFichaAtendimento');
$relatorios->get('/causa/{id:[0-9]+}/relatorio/andamento', 'getAndamentoDaCausa');
$relatorios->get('/causa/relatorio/filtrarArea/{idArea:[0-9]+}', 'relatorioCausasPorArea');
$relatorios->get('/causa/relatorio/arquivadas', 'causasArquivadas');
$relatorios->get('/causa/relatorio/andamento', 'causasEmAndamento');
$app->mount($relatorios);
