<?php

/**
 * Description of Estagio
 *
 * @author gabriel Lucas
 */
class Estagio {
    
    private $_id;
    private $_aprovado;
    private $_obrigatorio;
    private $_periodo;
    private $_serie;
    private $_modulo;
    private $_ano;
    private $_semestre;
    private $_dependencias;
    private $_justificativa;
    private $_endereco_tc;
    private $_endereco_pe;
    private $_empresa;
    private $_aluno;
    private $_funcionario;
    private $_curso;
    private $_status;
	
	public function __construct($id, $aprovado, $obrigatorio, $periodo, $serie, $modulo, $ano, $semestre, $dependencias, $justificativa, $endereco_tc, $endereco_pe, $empresa, $aluno, $funcionario, $curso, $status){
		$this->$_id = $id;
		$this->$_aprovado = $aprovado;
		$this->$_obrigatorio = $obrigatorio;
		$this->$_periodo = $periodo;
		$this->$_serie = $serie;
		$this->$_modulo = $modulo;
		$this->$_ano = $ano;
		$this->$_semestre = $semestre;
		$this->$_dependencias = $dependencias;
		$this->$_justificativa = $justificativa;
		$this->$_endereco_tc = $endereco_tc;
		$this->$_endereco_pe = $endereco_pe;
		$this->$_empresa = $empresa;
		$this->$_aluno = $aluno;
		$this->$_funcionario = $funcionario;
		$this->$_curso = $curso;
		$this->$_status = $status;
	}
	
	public function getid(){
		return $this->$_id;
	}
	
	public function getaprovado(){
		return $this->$_aprovado;
	}
	
	public function getobrigatorio(){
		return $this->$_obrigatorio;
	}
	
	public function getperiodo(){
		return $this->$_periodo;
	}
	
	public function getserie(){
		return $this->$_serie;
	}
	
	public function getmodulo(){
		return $this->$_modulo;
	}
	
	public function getano(){
		return $this->$_ano;
	}
	
	public function getsemestre(){
		return $this->$_semestre;
	}
	
	public function getdependencias(){
		return $this->$_dependencias;
	}
	
	public function getjustificativa(){
		return $this->$_justificativa;
	}
	
	public function getendereco_tc(){
		return $this->$_endereco_tc;
	}
	
	public function getendereco_pe(){
		return $this->$_endereco_pe;
	}
	
	public function getempresa(){
		return $this->$_empresa;
	}
	
	public function getaluno(){
		return $this->$_aluno;
	}
	
	public function getfuncionario(){
		return $this->$_funcionario;
	}
	
	public function getcurso(){
		return $this->$_curso;
	}
	
	public function getstatus(){
		return $this->$_status;
	}
	
	public function setid($id){
		$this->$_id = $id;
	}
	
	public function setaprovado($aprovado){
		$this->$_aprovado = $aprovado;
	}
	
	public function setobrigatorio($obrigatorio){
		$this->$_obrigatorio = $obrigatorio;
	}
	
	public function setperiodo($periodo){
		$this->$_periodo = $periodo;
	}
	
	public function setserie($serie){
		$this->$_serie = $serie;
	}
	
	public function setmodulo($modulo){
		$this->$_modulo = $modulo;
	}
	
	public function setano($ano){
		$this->$_ano = $ano;
	}
	
	public function setsemestre($semestre){
		$this->$_semestre = $semestre;
	}
	
	public function setdependencias($dependencias){
		$this->$_dependencias = $dependencias;
	}
	
	public function setjustificativa($justificativa){
		$this->$_justificativa = $justificativa;
	}
	
	public function setendereco_tc($endereco_tc){
		$this->$_endereco_tc = $endereco_tc;
	}
	
	public function setendereco_pe($endereco_pe){
		$this->$_endereco_pe = $endereco_pe;
	}
	
	public function setempresa($empresa){
		$this->$_empresa = $empresa;
	}
	
	public function setaluno($aluno){
		$this->$_aluno = $aluno;
	}
	
	public function setfuncionario($funcionario){
		$this->$_funcionario = $funcionario;
	}
	
	public function setcurso($curso){
		$this->$_curso = $curso;
	}
	
	public function setstatus($status){
		$this->$_status = $status;
	}
	
	
}
