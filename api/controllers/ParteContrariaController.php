<?php
use Phalcon\Mvc\Controller;

class ParteContrariaController extends Controller {

	public function get($id) {
		$this->response->setContentType("application/json");
		$parte_contraria = ParteContraria::find ( "id=" . $id )->getFirst ();
		if (! empty ( $parte_contraria ))
			$this->response->setContent ( json_encode ( $parte_contraria ) );
		else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function getAll() {
		$this->response->setContentType("application/json");
		$parte_contrarias = ParteContraria::find ();
		if (! empty ( $parte_contrarias->getFirst() )) {
			$data = array();
			foreach ( $parte_contrarias as $parte_contraria ) {
				$data [] = $parte_contraria;
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function post() {
		$this->response->setContentType("application/json");

		$parte_contraria = new ParteContraria();


		$json = $this->request->getJsonRawBody ();
		foreach ( $json as $key => $value ) {
			$parte_contraria->{$key} = $value;
		}
		if ($parte_contraria->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $parte_contraria->getMessages () as $message ) {
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
		$parte_contraria = ParteContraria::find ( "id=" . $id )->getFirst ();
		if (empty ( $parte_contraria ))
			$parte_contraria = new Questao ();
		foreach ( $json as $key => $value ) {
			$parte_contraria->{$key} = $value;
		}
		if ($parte_contraria->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $parte_contraria->getMessages () as $message ) {
				$data [++$i] = $message->getMessage ();
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else {
			if (! empty ( $parte_contraria ))
				$this->response->setStatusCode ( "204" );
			else
				$this->response->setStatusCode ( "201" );
		}
		return $this->response;
	}
	public function delete($id){
		$this->response->setContentType("application/json");
		$parte_contraria = ParteContraria::find ( "id=" . $id )->getFirst ();
		if (! empty ( $parte_contraria )) {
			try {
				$parte_contraria->delete ();
				$this->response->setStatusCode ( "204" );
			} catch ( Exception $e ) {
				$this->response->setStatusCode ( "409" );
				foreach ( $parte_contraria->getMessages () as $message ) {
					$data [++$i] = $message->getMessage ();
				}
				$this->response->setContent ( json_encode ( $data ) );
			}
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}
}
