<?php
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
include __DIR__ . "/../library/fpdf17/fpdf.php";
class RelatorioController extends Controller{
	private function call($url){
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($curl);
		curl_close($curl);		 
		return json_decode($result); 
	}
	public function getFichaAtendimento($id){
// 		$causas = $this->call('http://localhost/av2/api/cidadao/causa/'.$id);
// 		$this->response->setContentType("application/pdf");
// 		$pdf = new FPDF('L');
// 		$pdf->AddPage();
// 		$pdf->SetFont('Arial','B',16);
// 		$pdf->Cell(0,10,'Causas Aquivadas',0,1,'C');
// 		$pdf->SetFont('Arial','B',12);
// 		$pdf->Cell(80,5,'Relato',1,0);
// 		$pdf->Cell(50,5,'Prazo Decadencial',1,0);
// 		$pdf->Cell(50,5,'Prazo Drescricional',1,0);
// 		$pdf->Cell(50,5,'Tipo de Ação',1,0);
// 		$pdf->Cell(50,5,'Assistido',1,1);
// 		$pdf->SetFont('Arial','',12);
// 		for ($i = 0; $i < count($causas); $i++) {
// 			if ($causas[$i]->aquivado){
// 				$pdf->Cell(80,5,$causas[$i]->relato,1,0);
// 				$pdf->Cell(50,5,$causas[$i]->prazoDecadencial,1,0);
// 				$pdf->Cell(50,5,$causas[$i]->prazoDrescricional,1,0);
// 				$pdf->Cell(50,5,$causas[$i]->tipoAcao,1,0);
// 				$assistido = $this->call('http://localhost/av2/api/cidadao/assistido/'.$causas[$i]->idAssistido);
// 				$pdf->Cell(50,5,$assistido->nome,1,1);
// 			}
// 		}
// 		echo $pdf->Output();
	}
	public function getAndamentoDaCausa($id){
		$causa = $this->call('http://localhost/av2/api/cidadao/causa/'.$id);
		$andamentos = $this->call('http://localhost/av2/api/cidadao/causa/'.$id.'/andamento');
		$this->response->setContentType("application/pdf");
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Andamento do Processo '.$id,0,1,'C');
		$pdf->Cell(0,20,'',0,1);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(19,5,'Arquivado: ',0,0);
		if ($causa->aquivado)
			$pdf->Cell(17,5,'Sim',0,1);
		else
			$pdf->Cell(17,5,'Não',0,1);
		$pdf->Cell(13,5,'Status: ',0,0);
		$pdf->Cell(80,5,$causa->status,0,1);
		$pdf->Cell(0,10,'',0,1);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,5,'Histórico de Audiências',0,1,'C');		
		$x1 = $x2 = 93;
		for ($i = 0; $i < count($andamentos); $i++) {
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(0,5,'',0,1);
			$pdf->MultiCell(80,10,'Descrição: '.$andamentos[$i]->descricao,0,'L',false);
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(25,5,'Local: ',0,0);
			$pdf->Cell(25,5,$andamentos[$i]->localAudiencia,0,1);
			$pdf->Cell(25,5,'Data e Hora: ',0,0);
			$pdf->Cell(25,5,$andamentos[$i]->dataHora,0,1);
			$pdf->Line(20, $x1, 190, $x2);
			$x1 = $x2 += 25;
		}
		echo $pdf->Output();
	}
	public function relatorioCausasPorArea($idArea){
		$causa = $this->call('http://localhost/av2/api/cidadao/causa');
		$area_atendimento = $this->call('http://localhost/av2/api/cidadao/area_atendimento/'.$idArea);
		$this->response->setContentType("application/pdf");
		$pdf = new FPDF('L');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Causas por Área - '.$area_atendimento->nome,0,1,'C');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(80,5,'Relato',1,0);
		$pdf->Cell(50,5,'Prazo Decadencial',1,0);
		$pdf->Cell(50,5,'Prazo Drescricional',1,0);
		$pdf->Cell(50,5,'Tipo de Ação',1,0);
		$pdf->Cell(50,5,'Assistido',1,1);
		$pdf->SetFont('Arial','',12);
		for ($i = 0; $i < count($causa); $i++) {
			if ($idArea == $causa[$i]->areaatendimento->id){
				$pdf->Cell(80,5,$causa[$i]->relato,1,0);
				$pdf->Cell(50,5,$causa[$i]->prazoDecadencial,1,0);
				$pdf->Cell(50,5,$causa[$i]->prazoDrescricional,1,0);
				$pdf->Cell(50,5,$causa[$i]->tipoAcao,1,0);
				$assistido = $this->call('http://localhost/av2/api/cidadao/assistido/'.$causa[$i]->idAssistido);
				$pdf->Cell(50,5,$assistido->nome,1,1);
			}
		}
		echo $pdf->Output();
	}
	public function causasArquivadas(){
		$causas = $this->call('http://localhost/av2/api/cidadao/causa');
		$this->response->setContentType("application/pdf");
		$pdf = new FPDF('L');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Causas Aquivadas',0,1,'C');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(80,5,'Relato',1,0);
		$pdf->Cell(50,5,'Prazo Decadencial',1,0);
		$pdf->Cell(50,5,'Prazo Drescricional',1,0);
		$pdf->Cell(50,5,'Tipo de Ação',1,0);
		$pdf->Cell(50,5,'Assistido',1,1);
		$pdf->SetFont('Arial','',12);
		for ($i = 0; $i < count($causas); $i++) {
			if ($causas[$i]->aquivado){
				$pdf->Cell(80,5,$causas[$i]->relato,1,0);
				$pdf->Cell(50,5,$causas[$i]->prazoDecadencial,1,0);
				$pdf->Cell(50,5,$causas[$i]->prazoDrescricional,1,0);
				$pdf->Cell(50,5,$causas[$i]->tipoAcao,1,0);
				$assistido = $this->call('http://localhost/av2/api/cidadao/assistido/'.$causas[$i]->idAssistido);
				$pdf->Cell(50,5,$assistido->nome,1,1);
			}
		}
		echo $pdf->Output();
	}
	public function causasEmAndamento(){
		$causas = $this->call('http://localhost/av2/api/cidadao/causa');
		$this->response->setContentType("application/pdf");
		$pdf = new FPDF('L');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Causas em Andamento',0,1,'C');
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(80,5,'Relato',1,0);
		$pdf->Cell(50,5,'Prazo Decadencial',1,0);
		$pdf->Cell(50,5,'Prazo Drescricional',1,0);
		$pdf->Cell(50,5,'Tipo de Ação',1,0);
		$pdf->Cell(50,5,'Assistido',1,1);
		$pdf->SetFont('Arial','',12);
		for ($i = 0; $i < count($causas); $i++) {
			if (!$causas[$i]->aquivado){
				$pdf->Cell(80,5,$causas[$i]->relato,1,0);
				$pdf->Cell(50,5,$causas[$i]->prazoDecadencial,1,0);
				$pdf->Cell(50,5,$causas[$i]->prazoDrescricional,1,0);
				$pdf->Cell(50,5,$causas[$i]->tipoAcao,1,0);
				$assistido = $this->call('http://localhost/av2/api/cidadao/assistido/'.$causas[$i]->idAssistido);
				$pdf->Cell(50,5,$assistido->nome,1,1);
			}
		}
		echo $pdf->Output();
	}
}