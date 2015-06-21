<?php
use Phalcon\Mvc\Controller;

class CausaController extends Controller {
	public function get($id) {
		$this->response->setContentType("application/json");
		$causa = Causa::find ( "id=" . $id )->getFirst ();
		if (! empty ( $causa ))
			$this->response->setContent ( json_encode ( $causa ) );
		else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function getAll() {
		$this->response->setContentType("application/json");
		$causas = Causa::find ();
		if (! empty ( $causas->getFirst() )) {
			$data = array();
			foreach ( $causas as $causa ) {
				$data [] = $causa;
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function post() {
		$this->response->setContentType("application/json");
		$causa = new Causa();
		$json = $this->request->getJsonRawBody ();
		foreach ( $json as $key => $value ) {
			$causa->{$key} = $value;
		}
		if ($causa->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $causa->getMessages () as $message ) {
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
		$causa = Causa::find ( "id=" . $id )->getFirst ();
		if (empty ( $causa ))
			$causa = new Questao ();
		foreach ( $json as $key => $value ) {
			$causa->{$key} = $value;
		}
		if ($causa->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $causa->getMessages () as $message ) {
				$data [++$i] = $message->getMessage ();
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else {
			if (! empty ( $causa ))
				$this->response->setStatusCode ( "204" );
			else
				$this->response->setStatusCode ( "201" );
		}
		return $this->response;
	}
	public function delete($id){
		$this->response->setContentType("application/json");
		$causa = Causa::find ( "id=" . $id )->getFirst ();
		if (! empty ( $causa )) {
			try {
				$causa->delete ();
				$this->response->setStatusCode ( "204" );
			} catch ( Exception $e ) {
				$this->response->setStatusCode ( "409" );
				foreach ( $causa->getMessages () as $message ) {
					$data [++$i] = $message->getMessage ();
				}
				$this->response->setContent ( json_encode ( $data ) );
			}
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}
}
