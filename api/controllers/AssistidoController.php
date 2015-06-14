<?php
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
class AssistidoController extends Controller {
	public function get($id) {
		$this->response->setContentType("application/json");
		$assistido = Assistido::find ( "id=" . $id )->getFirst ();
		if (! empty ( $assistido ))
			$this->response->setContent ( json_encode ( $assistido ) );
		else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}
	
	public function getAll() {
		$this->response->setContentType("application/json");
		$assistidos = Assistido::find ();
		if (! empty ( $assistidos->getFirst() )) {
			$data = array();
			foreach ( $assistidos as $assistido ) {
				$data [] = $assistido;
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;		
	}
	
	public function post() {
		$this->response->setContentType("application/json");
		$assistido = new Assistido();
		
		$json = $this->request->getJsonRawBody ();
		foreach ( $json as $key => $value ) {
			$assistido->{$key} = $value;
		}
		if ($assistido->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $assistido->getMessages () as $message ) {
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
		$assistido = Assistido::find ( "id=" . $id )->getFirst ();
		if (empty ( $assistido ))
			$assistido = new Questao ();
		foreach ( $json as $key => $value ) {
			$assistido->{$key} = $value;
		}
		if ($assistido->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $assistido->getMessages () as $message ) {
				$data [++$i] = $message->getMessage ();
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else {
			if (! empty ( $assistido ))
				$this->response->setStatusCode ( "204" );
			else
				$this->response->setStatusCode ( "201" );
		}
		return $this->response;
	}
	public function delete($id){
		$this->response->setContentType("application/json");
		$assistido = Assistido::find ( "id=" . $id )->getFirst ();
		if (! empty ( $assistido )) {
			try {
				$assistido->delete ();
				$this->response->setStatusCode ( "204" );
			} catch ( Exception $e ) {
				$this->response->setStatusCode ( "409" );
				foreach ( $assistido->getMessages () as $message ) {
					$data [++$i] = $message->getMessage ();
				}
				$this->response->setContent ( json_encode ( $data ) );
			}
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}
}