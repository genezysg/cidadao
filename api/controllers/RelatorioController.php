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
		$causa = $this->call('http://localhost/av2/api/cidadao/causa/'.$id);
		$assistido = $this->call('http://localhost/av2/api/cidadao/assistido/'.$causa->idAssistido);	
		$this->response->setContentType("application/pdf");
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Ficha de Atendimento',0,1,'C');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(0,15,'Potocolo nº:_____________________',0,1,'R');
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Dados Pessoais do assistido',0,1,'C');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(0,7,'Nome:'.$assistido->nome,1,1);		
		$pdf->Cell(100,7,'Nome do Pai:'.$assistido->nomePai,1,0);
		$pdf->Cell(0,7,'Nome da Mãe:'.$assistido->nomeMae,1,1);
		$pdf->Cell(65,7,'Nacionalidade:'.$assistido->nacionalidade,1,0);
		$pdf->Cell(65,7,'Estado Civil:'.$assistido->estadoCivil,1,0);
		$pdf->Cell(0,7,'Data de Nascimento:'.date("d/m/Y", strtotime($assistido->dataNascimento)),1,1);
		$pdf->Cell(50,7,'Identidade:'.$assistido->identidade,1,0);
		$pdf->Cell(50,7,'CPF:'.$assistido->cpf,1,0);
		$pdf->Cell(0,7,'Profissão:'.$assistido->profissao,1,1);
		$pdf->Cell(90,7,'Rendimento Pessoal: R$'.$assistido->rendimentoPessoal,1,0);
		$pdf->Cell(0,7,'Rendimento Familiar: R$'.$assistido->rendimentoFamiliar,1,1);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,20,'Dados da Causa',0,1,'C');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(100,7,'Área de Atendimento:'.$causa->areaatendimento->nome,1,0);
		$pdf->Cell(0,7,'Tipo de Ação:'.$causa->tipoAcao,1,1);
		$pdf->Cell(0, 15, 'Relato: '.$causa->relato,1,1);
		$pdf->Cell(90,7,'Prazo Decadencial:'.$causa->prazoDecadencial,1,0);
		$pdf->Cell(0,7,'Prazo Prescricional:'.$causa->prazoPrescricional,1,1);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,20,'Parte Contrária',0,1,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(0,7,'Nome:'.$causa->partecontraria->nome,1,1);
		$pdf->Cell(0,7,'Endereço Residencial:'.$causa->partecontraria->enderecoResidencial,1,1);
		$pdf->Cell(0,7,'Endereço Comercial:'.$causa->partecontraria->enderecoComercial,1,1);
		$pdf->Cell(50,7,'Telefone:'.$causa->partecontraria->telefone,1,0);
		$pdf->Cell(0,7,'E-Mail:'.$causa->partecontraria->email,1,1);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(0,10,'Atendimento:',0,1,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(90,7,'Data e Hora: '.date("d/m/Y, H:i:s", strtotime($causa->dataAtendimento)),1,0);		
		$pdf->Cell(0,7,'Local: '.$causa->localAtendimento,1,1);
		$pdf->SetY(265);
		$pdf->Cell(0,5,'_________________________________________',0,1,'C');
		$pdf->Cell(0,5,'Assinatura do Assistido',0,1,'C');
		echo $pdf->Output();
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
		if (count($andamentos) == 0){
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(0,20,'Sem Audiências Lançadas',0,1,'C');
		}
		else{
			for ($i = 0; $i < count($andamentos); $i++) {
				$pdf->SetFont('Arial','B',12);
				$pdf->Cell(0,5,'',0,1);
				$pdf->MultiCell(80,10,'Descrição: '.$andamentos[$i]->descricao,0,'L',false);
				$pdf->SetFont('Arial','',10);
				$pdf->Cell(25,5,'Local: ',0,0);
				$pdf->Cell(25,5,$andamentos[$i]->localAudiencia,0,1);
				$pdf->Cell(25,5,'Data e Hora: ',0,0);
				$pdf->Cell(25,5,date("d/m/Y, H:i:s", strtotime($andamentos[$i]->dataHora)),0,1);
				$pdf->Line(20, $x1, 190, $x2);
				$x1 = $x2 += 25;
			}
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
		$pdf->Cell(0,10,'Causas por Área de Atendimento - '.$area_atendimento->nome,0,1,'C');
		$pdf->SetFont('Arial','B',12);
		for ($i = 0; $i < count($causa); $i++) {
			if ($idArea == $causa[$i]->areaatendimento->id){
				$pdf->SetFont('Arial','B',14);
				$pdf->Cell(0,20,'Causa Nº '.$causa[$i]->id,0,1,'C');
				$pdf->SetFont('Arial','B',12);
				$pdf->MultiCell(0, 10, 'Relato: '.$causa[$i]->relato);
				$pdf->Cell(110,10,'Prazo Decadencial: '.$causa[$i]->prazoDecadencial,0,0);
				$pdf->Cell(0,10,'Prazo Drescricional: '.$causa[$i]->prazoPrescricional,0,1);
				$pdf->Cell(110,10,'Tipo de Ação: '.$causa[$i]->tipoAcao,0,0);
				$assistido = $this->call('http://localhost/av2/api/cidadao/assistido/'.$causa[$i]->idAssistido);
				$pdf->Cell(0,10,'Nome do Assistido: '.$assistido->nome,0,1);				
			}
		}
		echo $pdf->Output();
	}
	public function causasArquivadas(){
		$causa = $this->call('http://localhost/av2/api/cidadao/causa');
		$this->response->setContentType("application/pdf");
		$pdf = new FPDF('L');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Causas Aquivadas',0,1,'C');
		for ($i = 0; $i < count($causa); $i++) {
			if ($causa[$i]->aquivado){
				$pdf->SetFont('Arial','B',14);
				$pdf->Cell(0,20,'Causa Nº '.$causa[$i]->id,0,1,'C');
				$pdf->SetFont('Arial','B',12);
				$pdf->MultiCell(0, 10, 'Relato: '.$causa[$i]->relato);
				$pdf->Cell(110,10,'Prazo Decadencial: '.$causa[$i]->prazoDecadencial,0,0);
				$pdf->Cell(0,10,'Prazo Drescricional: '.$causa[$i]->prazoPrescricional,0,1);
				$pdf->Cell(110,10,'Tipo de Ação: '.$causa[$i]->tipoAcao,0,0);
				$assistido = $this->call('http://localhost/av2/api/cidadao/assistido/'.$causa[$i]->idAssistido);
				$pdf->Cell(0,10,'Nome do Assistido: '.$assistido->nome,0,1);				
			}
		}
		echo $pdf->Output();
	}
	public function causasEmAndamento(){
		$causa = $this->call('http://localhost/av2/api/cidadao/causa');
		$this->response->setContentType("application/pdf");
		
		$pdf = new FPDF('L');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Causas em Andamento',0,1,'C');
		for ($i = 0; $i < count($causa); $i++) {
			if (!$causa[$i]->aquivado){
				$pdf->SetFont('Arial','B',14);
				$pdf->Cell(0,20,'Causa Nº '.$causa[$i]->id,0,1,'C');
				$pdf->SetFont('Arial','B',12);
				$pdf->MultiCell(0, 10, 'Relato: '.$causa[$i]->relato);
				$pdf->Cell(110,10,'Prazo Decadencial: '.$causa[$i]->prazoDecadencial,0,0);
				$pdf->Cell(0,10,'Prazo Drescricional: '.$causa[$i]->prazoPrescricional,0,1);
				$pdf->Cell(110,10,'Tipo de Ação: '.$causa[$i]->tipoAcao,0,0);
				$assistido = $this->call('http://localhost/av2/api/cidadao/assistido/'.$causa[$i]->idAssistido);
				$pdf->Cell(0,10,'Nome do Assistido: '.$assistido->nome,0,1);				
			}
		}
		echo $pdf->Output();
	}
	public function procuracao($id){
		$assistido = $this->call('http://localhost/av2/api/cidadao/assistido/'.$id);
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',16);
		$pdf->Cell(0,10,'NÚCLEO DE PRÁTICA JURÍDICA',0,1,'L');
		$pdf->SetFont('Arial','',24);
		$pdf->setY(60);
		$pdf->Cell(0,20,'PROCURAÇÃO',0,1,'C');
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(25,100);
		$pdf->MultiCell(160,7,'Pelo presente instrumento particular de mandato, '.$assistido->nome.', '.$assistido->nacionalidade.
				', '.$assistido->estadoCivil.', '.$assistido->profissao.', '.$assistido->identidade.', '.$assistido->cpf.
				', '.$assistido->nomeMae.', '.date("d/m/Y", strtotime($assistido->dataNascimento)).', '.$assistido->endereco.', nomeia e constitui '.
				'como procurador(a) ______________________________________, inscrito(a) na OAB/RJ sob o número ______________________________________, e os estagiários(as) '.
				'______________________________________, inscritos na OAB/RJ, sob os números ____________________________ '.
				' respectivamente, todos integrantes do Núcleo de Prática Jurídica – NPJ, da UNIABEU, com sede na '.
				'Av. Getúlio Vargas, n.º 1730, Centro, Nilópolis/RJ, CEP: 26510-010, conferindo-lhes os poderes para representar '.
				'o (a) outorgante perante o Foro em geral, podendo praticar todos os atos indispensáveis ao fiel cumprimento do '.
				'presente mandato, inclusive confessar, reconhecer a procedência do pedido, transigir, desistir, renunciar ao direito '.
				'sobre o qual se funda a ação, receber e dar quitação e firmar compromisso, inclusive substabelecer com ou sem reserva de poderes.');
		$pdf->SetX(90);
		$pdf->Cell(95, 50, 'Rio de Janeiro, ______ de ________________ de __________',0,1,'R');
		echo $pdf->Output();
	}
	public function hiposuficiencia($id){
		$assistido = $this->call('http://localhost/av2/api/cidadao/assistido/'.$id);
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','',16);
		$pdf->Cell(0,10,'NÚCLEO DE PRÁTICA JURÍDICA',0,1,'L');
		$pdf->SetFont('Arial','',24);
		$pdf->setY(60);
		$pdf->Cell(0,20,'AFIRMAÇÃO DE HIPOSSUFICIÊNCIA',0,1,'C');
		$pdf->SetFont('Arial','',10);
		$pdf->SetXY(25,100);
		$pdf->MultiCell(160,7,'__________________________________________________________________'.
				'__________________________________________________________________'.
				'__________________________________________________________________'.
				'__________________________________________________________________'.
				'__________________________________________________________________'.
				'__________________________________________________________________'.
				'__________________________________________________________________'.
				'__________________________________________________________________'.
				'__________________________________________________________________'.
				', afirma de acordo com a Lei nº 7.115, de 29 de agosto de 1983 e de '.
				'conformidade com a Lei Nº 1060/50, que não tem condições financeiras '.
				'para arcar com as despesas processuais e honorários advocatícios ou '.
				'de qualquer espécie, sem prejuízo do sustento próprio e da família '.
				'fazendo jus à gratuidade dos serviços judiciários, indicando os '.
				'integrantes do Núcleo de Prática Jurídica da UNIABEU Centro Universitário '.
				'para o patrocínio gratuito.');
		$pdf->SetXY(25,195);
		$pdf->MultiCell(160,7,'Declara ainda conhecer as sanções civis e criminais previstas na legislação aplicável, caso comprovada a falsidade das afirmações supra.');
	
		$pdf->SetX(90);
		$pdf->Cell(95, 55, 'Rio de Janeiro, ______ de ________________ de __________',0,1,'R');
		$pdf->Cell(175, 5, '___________________________________________',0,1,'R');
		$pdf->Cell(175, 5, 'Beneficiário / Assistido',0,1,'R');
		echo $pdf->Output();
}
}