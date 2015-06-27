<?php
use Phalcon\Mvc\Controller;

class AreaAtendimentoController extends Controller {
	public function get($id) {
		$this->response->setContentType("application/json");
		$AreaAtendimento = AreaAtendimento::find ( "id=" . $id )->getFirst ();
		if (! empty ( $AreaAtendimento ))
			$this->response->setContent ( json_encode ( $AreaAtendimento ) );
		else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function getAll() {
		$this->response->setContentType("application/json");
		$AreaAtendimentos = AreaAtendimento::find ();
		if (! empty ( $AreaAtendimentos->getFirst() )) {
			$data = array();
			foreach ( $AreaAtendimentos as $AreaAtendimento ) {
				$data [] = $AreaAtendimento;
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}

	public function post() {
		$this->response->setContentType("application/json");
		$AreaAtendimento = new AreaAtendimento();
		$json = $this->request->getJsonRawBody ();
		foreach ( $json as $key => $value ) {
			$AreaAtendimento->{$key} = $value;
		}
		if ($AreaAtendimento->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $AreaAtendimento->getMessages () as $message ) {
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
		$AreaAtendimento = AreaAtendimento::find ( "id=" . $id )->getFirst ();
		if (empty ( $AreaAtendimento ))
			$AreaAtendimento = new Questao ();
		foreach ( $json as $key => $value ) {
			$AreaAtendimento->{$key} = $value;
		}
		if ($AreaAtendimento->save () == false) {
			$i = 0;
			$this->response->setStatusCode ( "409" );
			foreach ( $AreaAtendimento->getMessages () as $message ) {
				$data [++$i] = $message->getMessage ();
			}
			$this->response->setContent ( json_encode ( $data ) );
		} else {
			if (! empty ( $AreaAtendimento ))
				$this->response->setStatusCode ( "204" );
			else
				$this->response->setStatusCode ( "201" );
		}
		return $this->response;
	}
	public function delete($id){
		$this->response->setContentType("application/json");
		$AreaAtendimento = AreaAtendimento::find ( "id=" . $id )->getFirst ();
		if (! empty ( $AreaAtendimento )) {
			try {
				$AreaAtendimento->delete ();
				$this->response->setStatusCode ( "204" );
			} catch ( Exception $e ) {
				$this->response->setStatusCode ( "409" );
				foreach ( $AreaAtendimento->getMessages () as $message ) {
					$data [++$i] = $message->getMessage ();
				}
				$this->response->setContent ( json_encode ( $data ) );
			}
		} else
			$this->response->setStatusCode ( "404" );
		return $this->response;
	}
}
