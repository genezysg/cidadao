<?php
use Phalcon\Mvc\Controller;
class AndamentoController extends Controller {
	public function get($id) {
		$this->response->setContentType("application/json");
		$andamento = Andamento::find ( "id=" . $id )->getFirst ();
		if (! empty ( $andamento ))
			$this->response->setContent ( json_encode ( $andamento ) );
		else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function getByCausa($idCausa){
		$this->response->setContentType("application/json");
		$andamento = Andamento::find ( "idCausa=" . $idCausa )->getFirst ();
		if (! empty ( $andamento ))
			$this->response->setContent ( json_encode ( $andamento ) );
		else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function getAll() {
		$this->response->setContentType("application/json");
		$andamentos = Andamento::find ();
		if (! empty ( $andamentos->getFirst() )) {
			$data = array();
			foreach ( $andamentos as $andamento ) {
				$data [] = $andamento;
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function post() {
		$this->response->setContentType("application/json");
		$andamento = new Andamento();

		$json = $this->request->getJsonRawBody ();
		foreach ( $json as $key => $value ) {
			$andamento->{$key} = $value;
		}
		if ($andamento->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $andamento->getMessages () as $message ) {
				$data [++$i] = $message->getMessage ();
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else
			$this->response->setStatusCode ( "204" );

		return $this->response;
	}

	public function put($id){
		$this->response->setContentType("application/json");
		$json = $this->request->getJsonRawBody ();
		$andamento = Andamento::find ( "id=" . $id )->getFirst ();
		if (empty ( $andamento ))
			$andamento = new Questao ();
		foreach ( $json as $key => $value ) {
			$andamento->{$key} = $value;
		}
		if ($andamento->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $andamento->getMessages () as $message ) {
				$data [++$i] = $message->getMessage ();
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else {
			if (! empty ( $andamento ))
				$this->response->setStatusCode ( "204" );
			else
				$this->response->setStatusCode ( "201" );
		}
		return $this->response;
	}

	public function delete($id){
		$this->response->setContentType("application/json");
		$andamento = Andamento::find ( "id=" . $id )->getFirst ();
		if (! empty ( $andamento )) {
			try {
				$andamento->delete ();
				$this->response->setStatusCode ( "204" );
			} catch ( Exception $e ) {
				$this->response->setStatusCode ( "409" );
				foreach ( $andamento->getMessages () as $message ) {
					$data [++$i] = $message->getMessage ();
				}
				$this->response->setContent ( json_encode ( $data ) );
			}
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}
}