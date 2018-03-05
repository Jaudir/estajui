<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/controllers/TC.php";

function underlineString($tamanho, $string) {
    $formatada = substr($string, 0, $tamanho);

    $formatada = $formatada . str_repeat(' ', $tamanho - strlen($formatada));
    return $formatada;
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
        <link rel="stylesheet" href="base.min.css"/>
        <link rel="stylesheet" href="fancy.min.css"/>
        <link rel="stylesheet" href="main.css"/>
        <link rel="stylesheet" href="mainprint.css" media="print"/>
        <script src="compatibility.min.js"></script>
        <script src="theViewer.min.js"></script>
        <script>
            try {
                theViewer.defaultViewer = new theViewer.Viewer({});
            } catch (e) {
            }
        </script>
        <title>
        </title>
    </head>
    <body onload="window.print()">
        <div id="sidebar">
            <div id="outline">
            </div>
        </div>
        <div id="page-container">
            <div id="pf1" class="pf w0 h0" data-page-no="1">
                <div class="pc pc1 w0 h0">
                    <img class="bi x0 y0 w1 h1" alt="" src="bg1.png"/>
                    <div class="t m0 x1 h2 y1 ff1 fs0 fc0 sc0 ls0 ws0">Ministério da Educação </div>
                    <div class="t m0 x2 h2 y2 ff1 fs0 fc0 sc0 ls0 ws0">Secretaria de Educação Profissional e Tecnológica</div>
                    <div class="t m0 x3 h2 y3 ff1 fs0 fc0 sc0 ls0 ws0">Instituto Federal do Norte de Minas Gerais – IFNMG </div>
                    <div class="t m0 x4 h2 y4 ff3 fs0 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x5 h3 y5 ff4 fs1 fc0 sc0 ls0 ws0">TERMO DE COMPROMISSO DE ESTÁGIO OBRIGATÓRIO</div>
                    <div class="t m0 x4 h4 y6 ff1 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h4 y7 ff1 fs2 fc0 sc0 ls0 ws0">Neste ato as partes a seguir nomeadas:  </div>
                    <div class="t m0 x6 h5 y8 ff4 fs3 fc0 sc0 ls0 ws0">ESTAGIÁRIO </div>
                    <div class="t m0 x6 h6 y9 ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 ya ff4 fs2 fc0 sc0 ls0 ws0">Nome:<span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(98, NULL) : underlineString(98, $estagio->getaluno()->getnome()); ?></span></div>
                    <div class="t m0 x6 h6 yb ff4 fs2 fc0 sc0 ls0 ws0">RG: <span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(26, NULL) : underlineString(26, $estagio->getaluno()->getrg_numformatado()); ?></span> CPF: <span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(26, NULL) : underlineString(26, $estagio->getaluno()->getcpfformatado()); ?></span>Data de nascimento: <span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(26, NULL) : underlineString(26, $estagio->getaluno()->getdata_nasc()); ?></span></div>
                    <div class="t m0 x6 h6 yc ff4 fs2 fc0 sc0 ls0 ws0">Endereço (rua/av.): <span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(57, NULL) : underlineString(57, $estagio->getaluno()->getendereco()->getlogradouro()); ?></span> N º: <span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(7, NULL) : underlineString(7, $estagio->getaluno()->getendereco()->getnumero()); ?></span> Aptº: <span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(15, NULL) : underlineString(15, $estagio->getaluno()->getendereco()->getcomplemento()); ?></span> </div>
                    <div class="t m0 x6 h6 yd ff4 fs2 fc0 sc0 ls0 ws0">Bairro: <span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(40, NULL) : underlineString(40, $estagio->getaluno()->getendereco()->getbairro()); ?></span> Cidade:<span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(37, NULL) : underlineString(37, $estagio->getaluno()->getendereco()->getcidade()); ?></span> Estado:  <span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(5, NULL) : underlineString(5, $estagio->getaluno()->getendereco()->getuf()); ?> </span></div>
                    <div class="t m0 x6 h6 ye ff4 fs2 fc0 sc0 ls0 ws0">CEP: <span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(20, NULL) : underlineString(20, $estagio->getaluno()->getendereco()->getcep()); ?></span> Telefone Fixo: <span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(20, NULL) : underlineString(20, $estagio->getaluno()->gettelefone()); ?></span> Celular:<span class="underline"><?php echo (!$estagio->getaluno()) ? underlineString(40, NULL) : underlineString(40, $estagio->getaluno()->getendereco()->getcidade()); ?></span> </div>
                    <div class="t m0 x6 h6 yf ff4 fs2 fc0 sc0 ls0 ws0">Curso: <span class="underline"><?php echo (!$estagio->getmatricula()) ? underlineString(54, NULL) : underlineString(54, $estagio->getmatricula()->getoferta()->getcurso()->getnome()); ?></span> Série: <span class="underline"><?php echo underlineString(8, $estagio->getserie()); ?></span> Módulo: <span class="underline"><?php echo underlineString(8, $estagio->getmodulo()); ?></span> Período: <span class="underline"><?php echo underlineString(8, $estagio->getperiodo()); ?></span></div>
                    <div class="t m0 x6 h6 y10 ff4 fs2 fc0 sc0 ls0 ws0">*Aluno (a) integralizou a carga horária do curso:Semestre/Ano de Integralização:<span class="underline"><?php echo underlineString(6, $estagio->getsemestre()); ?></span>/<span class="underline"><?php echo underlineString(8, $estagio->getano()); ?></span>  </div>
                    <div class="t m0 x6 h7 y11 ff6 fs4 fc0 sc0 ls0 ws0">*Concluiu com aproveitamento todas as disciplinas/módulos que integram a estrutura curricular do curso, excluindo-se estágios e defesas de TCC, entre outras atividades </div>
                    <div class="t m0 x6 h7 y12 ff6 fs4 fc0 sc0 ls0 ws0">que não pressuponham a presença regular do aluno nas dependências da instituição. </div>
                    <div class="t m0 x6 h8 y13 ff1 fs4 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h5 y14 ff4 fs3 fc0 sc0 ls0 ws0">CONCEDENTE </div>
                    <div class="t m0 x6 h4 y15 ff1 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y16 ff4 fs2 fc0 sc0 ls0 ws0">Nome ou Razão Social: <span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(84, NULL) : underlineString(84, $estagio->getempresa()->getnome()); ?></span></div>
                    <div class="t m0 x6 h6 y17 ff4 fs2 fc0 sc0 ls0 ws0">Endereço (rua/av.):<span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(57, NULL) : underlineString(57, $estagio->getempresa()->getendereco()->getlogradouro()); ?></span> N º:  <span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(7, NULL) : underlineString(7, $estagio->getempresa()->getendereco()->getnumero()); ?></span> Sala:<span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(15, NULL) : underlineString(15, $estagio->getempresa()->getendereco()->getsala()); ?></span> </div>
                    <div class="t m0 x6 h6 y18 ff4 fs2 fc0 sc0 ls0 ws0">Bairro: <span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(41, NULL) : underlineString(41, $estagio->getempresa()->getendereco()->getbairro()); ?></span>   Cidade: <span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(36, NULL) : underlineString(36, $estagio->getempresa()->getendereco()->getcidade()); ?></span> Estado: <span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(5, NULL) : underlineString(5, $estagio->getempresa()->getendereco()->getuf()); ?></span> </div>
                    <div class="t m0 x6 h6 y19 ff4 fs2 fc0 sc0 ls0 ws0">CEP: <span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(20, NULL) : underlineString(20, $estagio->getempresa()->getendereco()->getcep()); ?></span> Telefone(s):<span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(69, NULL) : underlineString(69, $estagio->getempresa()->gettelefone()); ?></span></div>
                    <div class="t m0 x6 h6 y1a ff4 fs2 fc0 sc0 ls0 ws0">CNPJ :<span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(98, NULL) : underlineString(98, $estagio->getempresa()->getcnpj()); ?></span></div>
                    <div class="t m0 x6 h6 y1b ff4 fs2 fc0 sc0 ls0 ws0">N° Registro: <span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(40, NULL) : underlineString(40, $estagio->getempresa()->getnregistro()); ?></span> Conselho de Fiscalização: <span class="underline"><?php echo (!$estagio->getempresa()) ? underlineString(32, NULL) : underlineString(32, $estagio->getempresa()->getconselhofiscal()); ?></span></div>
                    <div class="t m0 x6 h4 y1c ff1 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h5 y1d ff4 fs3 fc0 sc0 ls0 ws0">INSTITUIÇÃO DE ENSINO </div>
                    <div class="t m0 x6 h6 y1e ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y1f ff4 fs2 fc0 sc0 ls0 ws0">Razão Social: Instituto Federal de Educação, Ciência e Tecnologia Norte de Minas Gerais – Campus <span class="underline"><?php echo (!$estagio->getmatricula()) ? underlineString(32, NULL) : underlineString(24, $estagio->getmatricula()->getoferta()->getcampus()->getendereco()->getcidade()); ?></span> </div>
                    <div class="t m0 x6 h6 y20 ff4 fs2 fc0 sc0 ls0 ws0">Endereço:<span class="underline"><?php echo (!$estagio->getmatricula()) ? underlineString(95, NULL) : underlineString(95, $estagio->getmatricula()->getoferta()->getcampus()->getendereco()->getendereco()); ?></span></div>
                    <div class="t m0 x6 h6 y21 ff4 fs2 fc0 sc0 ls0 ws0">Cidade:<span class="underline"><?php echo (!$estagio->getmatricula()) ? underlineString(40, NULL) : underlineString(40, $estagio->getmatricula()->getoferta()->getcampus()->getendereco()->getcidade()); ?></span> Estado:MG CEP: <span class="underline"><?php echo (!$estagio->getmatricula()) ? underlineString(15, NULL) : underlineString(15, $estagio->getmatricula()->getoferta()->getcampus()->getendereco()->getcep()); ?></span> Telefone:<span class="underline"><?php echo (!$estagio->getmatricula()) ? underlineString(20, NULL) : underlineString(20, $estagio->getmatricula()->getoferta()->getcampus()->gettelefone()); ?></span></div>
                    <div class="t m0 x6 h6 y22 ff4 fs2 fc0 sc0 ls0 ws0">CNPJ(do Campus):<span class="underline"><?php echo (!$estagio->getmatricula()) ? underlineString(30, NULL) : underlineString(30, $estagio->getmatricula()->getoferta()->getcampus()->getcnpj()); ?></span>  </div>
                    <div class="t m0 x6 h4 y23 ff1 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y24 ff1 fs2 fc0 sc0 ls0 ws0">Celebram entre si este TERMO DE COMPROMISSO DE ESTÁGIO convencionando ascláusulas e condições seguintes: </div>
                    <div class="t m0 x6 h4 y25 ff1 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y26 ff4 fs2 fc0 sc0 ls0 ws0">Art. 1º Este TERMO DE COMPROMISSO DE ESTÁGIO reger-se-á pela disposição da Lei Nº 11.788, de 25 de setembro de 2008, e </div>
                    <div class="t m0 x6 h4 y27 ff1 fs2 fc0 sc0 ls0 ws0">explicitará o estágio como estratégia de complementação do processo de ensino-aprendizagem, bem como estabelecerá ascondições de </div>
                    <div class="t m0 x6 h6 y28 ff1 fs2 fc0 sc0 ls0 ws0">sua realização.</div>
                    <div class="t m0 x6 h6 y29 ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y2a ff4 fs2 fc0 sc0 ls0 ws0">Art. 2º Fica acertado entre as partes que:</div>
                    <div class="t m0 x6 h6 y2b ff4 fs2 fc0 sc0 ls0 ws0">a) as atividades principais desenvolvidas no estágio serão:</div>
                    <div class="t m0 x6 h4 y2c ff1 fs2 fc0 sc0 ls1 ws0"><span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(102, NULL) : underlineString(102, substr($estagio->getpe()->getatividades(), 0, 102)); ?></span></div>
                    <div class="t m0 x6 h4 y2d ff1 fs2 fc0 sc0 ls1 ws0"><span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(102, NULL) : underlineString(102, substr($estagio->getpe()->getatividades(), 102, 102)); ?></span></div>
                    <div class="t m0 x6 h4 y2e ff1 fs2 fc0 sc0 ls1 ws0"><span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(102, NULL) : underlineString(102, substr($estagio->getpe()->getatividades(), 204, 102)); ?></span></div>
                    <div class="t m0 x6 h4 y2f ff1 fs2 fc0 sc0 ls1 ws0"><span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(102, NULL) : underlineString(102, substr($estagio->getpe()->getatividades(), 306, 102)); ?></span></div>
                    <div class="t m0 x6 h4 y30 ff1 fs2 fc0 sc0 ls1 ws0"><span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(102, NULL) : underlineString(102, substr($estagio->getpe()->getatividades(), 408, 102)); ?></span></div>
                    <div class="t m0 x6 h6 y31 ff4 fs2 fc0 sc0 ls0 ws0">b) a jornada de estágio será cumprida (diariamente) nos horários de: </div>
                    <div class="t m0 x6 h4 y32 ff1 fs2 fc0 sc0 ls0 ws0"><span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(10, NULL) : underlineString(10, $estagio->getpe()->gethora_inicio1()); ?></span>h às <span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(10, NULL) : underlineString(10, $estagio->getpe()->gethora_fim1()); ?></span>h e das ___________h às ___________h, totalizando <span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(10, NULL) : underlineString(10, $estagio->getpe()->gettotal_horas()); ?></span>h semanais;</div>
                    <div class="t m0 x6 h6 y33 ff4 fs2 fc0 sc0 ls0 ws0">c) o estágio será oferecido(<?php if ($estagio->getpe()) {
    if (boolval($estagio->getpe()->getremuneracao())) echo "X";
    else echo "  ";
} else echo "  " ?>) sem (<?php if ($estagio->getpe()) {
    if (!boolval($estagio->getpe()->getremuneracao())) echo "X";
    else echo "  ";
} else echo "  "; ?>) com remuneração no valor de R$ <span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(12, NULL) : underlineString(12, $estagio->getpe()->getremuneracao()); ?></span> (______________________________________ </div>
                    <div class="t m0 x6 h4 y34 ff1 fs2 fc0 sc0 ls1 ws0">__________________________________________________________________________________), bem como auxilio - transporte no </div>
                    <div class="t m0 x6 h4 y35 ff1 fs2 fc0 sc0 ls0 ws0">valor de R$  ( <span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(90, NULL) : underlineString(90, $estagio->getpe()->getvale_transporte()); ?></span>); </div>
                    <div class="t m0 x6 h6 y36 ff4 fs2 fc0 sc0 ls0 ws0">d) o presente TERMO DE COMPROMISSO DE ESTÁGIO terá validade de <span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(17, NULL) : underlineString(17, $estagio->getpe()->getdata_inicio()); ?></span> a <span class="underline"><?php echo (!$estagio->getpe()) ? underlineString(17, NULL) : underlineString(17, $estagio->getpe()->getdata_fim()); ?></span>, </div>
                    <div class="t m0 x6 h4 y37 ff1 fs2 fc0 sc0 ls0 ws0">que poderá ser eventualmente prorrogado ou modificado por documento complementar, desde que qualquer das partes peça rescisão, por </div>
                    <div class="t m0 x6 h4 y38 ff1 fs2 fc0 sc0 ls0 ws0">escrito, com 5 dias de antecedência.  </div>
                </div>
                <div class="pi" data-data='{"ctm":[1.000000,0.000000,0.000000,1.000000,0.000000,0.000000]}'></div>
            </div>
            <div id="pf2" class="pf w0 h0" data-page-no="2">
                <div class="pc pc2 w0 h0">
                    <img class="bi x0 y0 w1 h1" alt="" src="bg2.png"/>
                    <div class="t m0 x1 h2 y1 ff1 fs0 fc0 sc0 ls0 ws0">Ministério da Educação </div>
                    <div class="t m0 x2 h2 y2 ff1 fs0 fc0 sc0 ls0 ws0">Secretaria de Educação Profissional e Tecnológica </div>
                    <div class="t m0 x3 h2 y3 ff1 fs0 fc0 sc0 ls0 ws0">Instituto Federal do Norte de Minas Gerais – IFNMG </div>
                    <div class="t m0 x4 h2 y4 ff3 fs0 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y39 ff4 fs2 fc0 sc0 ls0 ws0">Art.3º A CONCEDENTE designa o(a) Sr.(a) <span class="underline"><?php echo (!$estagio->getsupervisor()) ? underlineString(62, NULL) : underlineString(62, $estagio->getsupervisor()->getnome()); ?></span>, </div>
                    <div class="t m0 x6 h6 y3a ff1 fs2 fc0 sc0 ls0 ws0">cargo <span class="underline"><?php echo (!$estagio->getsupervisor()) ? underlineString(59, NULL) : underlineString(59, $estagio->getsupervisor()->getcargo()); ?></span>, para atuar como SUPERVISOR DO ESTÁGIO e o 
                    </div>
                    <div class="t m0 x6 h4 y3b ff1 fs2 fc0 sc0 ls0 ws0">Instituto Federal de Educação, Ciência e Tecnologia Norte de Minas Gerais – Campus <span class="underline"><?php echo (!$estagio->getmatricula()) ? underlineString(30, NULL) : underlineString(30, $estagio->getmatricula()->getoferta()->getcampus()->getendereco()->getcidade()); ?></span>, designa o </div>
                    <div class="t m0 x6 h6 y3c ff1 fs2 fc0 sc0 ls0 ws0">(a) Prof.(a) <span class="underline"><?php echo (!$estagio->getfuncionario()) ? underlineString(58, NULL) : underlineString(58, $estagio->getfuncionario()->getnome()); ?></span>, para atuar como ORIENTADOR  DO ESTÁGIO. </div>
                    <div class="t m0 x6 h6 y3d ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y3e ff4 fs2 fc0 sc0 ls0 ws0">Art. 4º Constituem-se motivos para a INTERRUPÇÃO AUTOMÁTICA do presente TERMO DE COMPROMISSO DE ESTÁGIO: </div>
                    <div class="t m0 x6 h4 y3f ff1 fs2 fc0 sc0 ls0 ws0">a) conclusão do curso, trancamento de matrícula ou abandono do curso; </div>
                    <div class="t m0 x6 h6 y40 ff1 fs2 fc0 sc0 ls0 ws0">b) o não cumprimento do convencionado neste TERMO DE COMPROMISSO DE ESTÁGIO. </div>
                    <div class="t m0 x4 h2 y41 ff3 fs0 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y42 ff4 fs2 fc0 sc0 ls0 ws0">Art. 5ºNa vigência do presente TERMO DE COMPROMISSO DE ESTÁGIO, o ESTAGIÁRIO estará incluído na cobertura do SEGURO </div>
                    <div class="t m0 x6 h6 y43 ff4 fs2 fc0 sc0 ls0 ws0">CONTRA ACIDENTES PESSOAIS, proporcionada pela:  </div>
                    <div class="t m0 x6 h4 y44 ff1 fs2 fc0 sc0 ls0 ws0">APÓLICE nº:<span class="underline"><?php echo (!$estagio->getapolice()) ? underlineString(93, NULL) : underlineString(93, $estagio->getapolice()->getnumero()); ?></span></div>
                    <div class="t m0 x6 h4 y45 ff1 fs2 fc0 sc0 ls0 ws0">SEGURADORA:<span class="underline"><?php echo (!$estagio->getapolice()) ? underlineString(91, NULL) : underlineString(91, $estagio->getapolice()->getseguradora()); ?></span> </div>
                    <div class="t m0 x6 h6 y46 ff4 fs2 fc0 sc0 ls0 ws0">Art. 6ºAssim materializado, documentado ecaracterizado, o presente estágio, não acarretará vínculo empregatício, de qualquer natureza,</div>
                    <div class="t m0 x6 h6 y47 ff1 fs2 fc0 sc0 ls0 ws0">entre o ESTAGIARIO e a CONCEDENTE nos termos do que dispõem oArt. 3°da Lei Nº 11.788, de 25 de setembro de 2008.</div>
                    <div class="t m0 x6 h6 y48 ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y49 ff4 fs2 fc0 sc0 ls0 ws0">Art. 7º No desenvolvimento do estágio ora compromissado, caberá à INSTITUIÇÃO DE ENSINO:</div>
                    <div class="t m0 x6 h6 y4a ff1 fs2 fc0 sc0 ls0 ws0">a) exigir do ESTAGIÁRIOa apresentação periódica, em prazo não superior a 6 (seis) meses, de relatório das atividades;</div>
                    <div class="t m0 x6 h6 y4b ff1 fs2 fc0 sc0 ls0 ws0">b)  comunicar à  parte CONCEDENTE do estágio, por  meio do ESTAGIÁRIO,  as datas  de realização de  avaliações escolares  ou </div>
                    <div class="t m0 x6 h4 y4c ff1 fs2 fc0 sc0 ls0 ws0">acadêmicas.  </div>
                    <div class="t m0 x6 h4 y4d ff1 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y4e ff4 fs2 fc0 sc0 ls0 ws0">Art. 8º No desenvolvimento do estágio ora compromissado, caberá à CONCEDENTE:</div>
                    <div class="t m0 x6 h6 y4f ff1 fs2 fc0 sc0 ls0 ws0">a) proporcionar ao ESTAGIÁRIO atividades de aprendizado social, profissional e cultural, compatíveiscom o seu curso;</div>
                    <div class="t m0 x6 h6 y50 ff1 fs2 fc0 sc0 ls0 ws0">b) enviar à INSTITUIÇÃO DE ENSINO, comperiodicidade mínima de 6 (seis) meses, relatório das atividades, com vista obrigatória ao </div>
                    <div class="t m0 x6 h6 y51 ff4 fs2 fc0 sc0 ls0 ws0">ESTAGIÁRIO; </div>
                    <div class="t m0 x6 h4 y52 ff1 fs2 fc0 sc0 ls0 ws0">c) fornecer certificado ou declaração de Estágio constando o período, a carga horária em que as atividades foram desenvolvidas;</div>
                    <div class="t m0 x6 h4 y53 ff1 fs2 fc0 sc0 ls0 ws0">d) manter a disposição da fiscalização documentos que comprovem a relação de estágio; </div>
                    <div class="t m0 x6 h4 y54 ff1 fs2 fc0 sc0 ls0 ws0">e) conceder ao estagiário, sempre que o estágio tenha duração igual ou superior a 1 (um) ano, período de recesso de 30 (trinta) dias, a ser </div>
                    <div class="t m0 x6 h4 y55 ff1 fs2 fc0 sc0 ls0 ws0">gozado preferencialmente durante o período de suas férias escolares. </div>
                    <div class="t m0 x6 h6 y56 ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y57 ff4 fs2 fc0 sc0 ls0 ws0">Art. 9ºNo desenvolvimento do estágio ora compromissado, caberá ao ESTAGIÁRIO:</div>
                    <div class="t m0 x6 h4 y58 ff1 fs2 fc0 sc0 ls0 ws0">a) cumprir com todo o empenho e interesse toda a programação estabelecida para o estágio;</div>
                    <div class="t m0 x6 h6 y59 ff1 fs2 fc0 sc0 ls0 ws0">b) cumprir as normas e regulamentos da CONCEDENTE, quando lhe forem informados. Pela inobservância dessas normas e </div>
                    <div class="t m0 x6 h6 y5a ff1 fs2 fc0 sc0 ls0 ws0">regulamentos, o ESTAGIÁRIO poderá responder por perdas e danos; </div>
                    <div class="t m0 x6 h6 y5b ff1 fs2 fc0 sc0 ls0 ws0">c) elaborar e entregar relatório dasatividades à CONCEDENTE, quando esta o exigir;</div>
                    <div class="t m0 x6 h6 y5c ff1 fs2 fc0 sc0 ls0 ws0">d) apresentar relatório das atividades periodicamente à INSTITUIÇÃO DE ENSINO,em prazo não superior a 6 (seis) meses; </div>
                    <div class="t m0 x6 h4 y5d ff1 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="t m0 x6 h6 y5e ff4 fs2 fc0 sc0 ls0 ws0">Art. 10 De comum acordo, as partes elegem o foro da Justiça Federal da Seção Judiciária de Minas Gerais da cidade de Montes Claros, </div>
                    <div class="t m0 x6 h6 y5f ff1 fs2 fc0 sc0 ls0 ws0">renunciando, desde logo, a qualquer outro, por mais privilegiado que seja, para dirimir qualquer questão que se originar deste TERMO DE </div>
                    <div class="t m0 x6 h6 y60 ff4 fs2 fc0 sc0 ls0 ws0">COMPROMISSO DE ESTÁGIO e que não possa ser resolvida amigavelmente.</div>
                    <div class="t m0 x6 h6 y61 ff1 fs2 fc0 sc0 ls0 ws0">E, por estarem de inteiro e comum acordo com as condições e dizeres deste TERMO DE COMPROMISSO DE ESTÁGIO, as partes </div>
                    <div class="t m0 x6 h4 y62 ff1 fs2 fc0 sc0 ls0 ws0">assinam em 03 (três) vias de igual teor e forma. </div>
                    <div class="t m0 x7 h4 y63 ff1 fs2 fc0 sc0 ls1 ws0">___________________________________________________ (MG.), ________ de ________________________de ___________.</div>
                    <div class="t m0 x4 h4 y64 ff1 fs2 fc0 sc0 ls0 ws0"></div>
                    <div class="c x4 y65 w2 h9">
                        <div class="t m0 x8 h6 y66 ff4 fs2 fc0 sc0 ls0 ws0">Nome: </div>

                    </div>
                    <div class="c x4 y65 w2 ha">
                        <div class="t m0 x9 h6 y67 ff4 fs2 fc0 sc0 ls0 ws0">CONCEDENTE </div>
                        <div class="t m0 xa h6 y68 ff4 fs2 fc0 sc0 ls0 ws0">(Carimbo) </div>
                    </div>
                    <div class="c xb y65 w3 h9">
                        <div class="t m0 x8 h6 y66 ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    </div>
                    <div class="c xc y65 w4 h9">
                        <div class="t m0 x8 h6 y66 ff4 fs2 fc0 sc0 ls0 ws0">Instituto Federal de Educação, Ciência e Tecnologia do </div>
                        <div class="t m0 x8 h6 y67 ff4 fs2 fc0 sc0 ls0 ws0">Norte de Minas Gerais – Campus _____________________</div>
                    </div>
                    <div class="c xc y65 w4 ha">
                        <div class="t m0 xd h6 y68 ff4 fs2 fc0 sc0 ls0 ws0">INSTITUIÇÃODEENSINO </div>
                        <div class="t m0 xa h6 y69 ff4 fs2 fc0 sc0 ls0 ws0">(Carimbo) </div>
                        <div class="t m0 xe h6 y6a ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    </div>
                    <div class="c x4 y6b w2 hb">
                        <div class="t m0 x8 h4 y6c ff1 fs2 fc0 sc0 ls0 ws0"></div>
                    </div>
                    <div class="c xb y6b w3 hb">
                        <div class="t m0 x8 h6 y6c ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    </div>
                    <div class="c xc y6b w4 hb">
                        <div class="t m0 xe h6 y6c ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    </div>
                    <div class="c x4 y6d w2 hc">
                        <div class="t m0 x8 h6 y6e ff4 fs2 fc0 sc0 ls0 ws0">Nome: </div>
                        <div class="t m0 xf h6 y6f ff4 fs2 fc0 sc0 ls0 ws0">ESTAGIÁRIO </div>
                    </div>
                    <div class="c xb y6d w3 hc">
                        <div class="t m0 x8 h6 y6e ff4 fs2 fc0 sc0 ls0 ws0"></div>
                    </div>
                    <div class="c xc y6d w4 hc">
                        <div class="t m0 x8 h6 y6e ff4 fs2 fc0 sc0 ls0 ws0">Nome: </div>
                        <div class="t m0 x10 h6 y6f ff4 fs2 fc0 sc0 ls0 ws0">PAI ou RESPONSÁVEL </div>
                        <div class="t m0 x8 h6 y70 ff4 fs2 fc0 sc0 ls7 ws0">RG:______________________________________________</div>
                        <div class="t m0 x8 h4 y71 ff1 fs2 fc0 sc0 ls0 ws0"></div>
                        <div class="t m0 x8 h6 y72 ff4 fs2 fc0 sc0 ls0 ws0">Orgão Emissor: ____________________________________</div>
                    </div>
                    <div class="t m0 x4 h2 y73 ff1 fs0 fc0 sc0 ls0 ws0"></div>
                </div>
                <div class="pi" data-data='{"ctm":[1.000000,0.000000,0.000000,1.000000,0.000000,0.000000]}'></div>
            </div>
        </div>
        <div class="loading-indicator"></div>
    </body>
</html>