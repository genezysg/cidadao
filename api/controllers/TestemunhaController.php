<?php
use Phalcon\Mvc\Controller;
class TestemunhaController extends Controller {
	public function get($id) {
		$this->response->setContentType("application/json");
		$testemunha = Testemunha::find ( "id=" . $id )->getFirst ();
		if (! empty ( $testemunha ))
			$this->response->setContent ( json_encode ( $testemunha ) );
		else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function getByCausa($idCausa){
		$this->response->setContentType("application/json");
		$testemunhas = Testemunha::find ( "idCausa=" . $idCausa );
		if (! empty ( $testemunhas->getFirst() )) {
			$data = array();
			foreach ( $testemunhas as $testemunha ) {
				$data [] = $testemunha;
			}
			$this->response->setContent ( json_encode ( $data ) );
		}
		else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function getAll() {
		$this->response->setContentType("application/json");
		$testemunhas = Testemunha::find ();
		if (! empty ( $testemunhas->getFirst() )) {
			$data = array();
			foreach ( $testemunhas as $testemunha ) {
				$data [] = $testemunha;
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function post() {
		$this->response->setContentType("application/json");
		$testemunha = new Testemunha();

		$json = $this->request->getJsonRawBody ();
		foreach ( $json as $key => $value ) {
			$testemunha->{$key} = $value;
		}
		if ($testemunha->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $testemunha->getMessages () as $message ) {
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
		$testemunha = Testemunha::find ( "id=" . $id )->getFirst ();
		if (empty ( $testemunha ))
			$testemunha = new Questao ();
		foreach ( $json as $key => $value ) {
			$testemunha->{$key} = $value;
		}
		if ($testemunha->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $testemunha->getMessages () as $message ) {
				$data [++$i] = $message->getMessage ();
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else {
			if (! empty ( $testemunha ))
				$this->response->setStatusCode ( "204" );
			else
				$this->response->setStatusCode ( "201" );
		}
		return $this->response;
	}

	public function delete($id){
		$this->response->setContentType("application/json");
		$testemunha = Testemunha::find ( "id=" . $id )->getFirst ();
		if (! empty ( $testemunha )) {
			try {
				$testemunha->delete ();
				$this->response->setStatusCode ( "204" );
			} catch ( Exception $e ) {
				$this->response->setStatusCode ( "409" );
				foreach ( $testemunha->getMessages () as $message ) {
					$data [++$i] = $message->getMessage ();
				}
				$this->response->setContent ( json_encode ( $data ) );
			}
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}
}