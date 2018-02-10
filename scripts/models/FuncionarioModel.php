<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/dao/Funcionario.php";

class AlunoModel extends MainModel {

    ///Se a senha estiver NULL, cria uma aleatória
    public function cadastrar($funcionario, $cursos) {
        $this->loader->loadUtil('funcao-geraSenha');
        $this->loader->loadDAO('Usuario');

        try {


            ///Sempre cadastra no Campus Montes Claros!
            $this->conn->beginTransaction();


            $pstmt = $this->conn->prepare("INSERT INTO usuario (email, senha, tipo) VALUES (?, ?, ?)");


            if ($funcionario->getsenha() == NULL || $funcionario->getsenha() == " ") {
                $verif = $pstmt->execute(array($funcionario->getlogin(), Usuario::generateSenha(geraSenha(8, true, true, true)), 2));
                if (!$verif) {
                    print_r($pstmt->errorInfo());
                    return false;
                }
            } else {
                $verif = $pstmt->execute(array($funcionario->getlogin(), $funcionario->getsenha(), 2));
                if (!$verif) {
                    echo "<br>Ali!";
                    print_r($pstmt->errorInfo());
                    $_SESSION['pau12'] = $pstmt->errorInfo();
                    return false;
                }
            }



            $pstmt = $this->conn->prepare("INSERT INTO funcionario (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, 
							usuario_email, campus_cnpj) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $verif = $pstmt->execute(array($funcionario->getsiape(), $funcionario->getnome(), $funcionario->ispo(), $funcionario->isoe(), $funcionario->isce(), $funcionario->issra(),
                $funcionario->isroot(), $funcionario->getformacao(), $funcionario->isprivilegio(), $funcionario->getlogin(), 10727655000462));
            if (!$verif) {

                $_SESSION['pau1'] = $pstmt->errorInfo();
                return false;
            }


            /* echo "\n".$pstmt->queryString."\n";
              echo $funcionario->getsiape() . '<br>' . $funcionario->getnome() . '<br>' . $funcionario->ispo() . '<br>' . $funcionario->isoe() . '<br>' .
              $funcionario->isce() . '<br>' .	$funcionario->issra() . '<br>' . $funcionario->isroot() . '<br>' . $funcionario->getformacao() .
              '<br>' . $funcionario->isprivilegio() . '<br>' . $funcionario->getlogin() . '<br>' . 10727655000462; */

            if (isset($cursos)) {

                foreach ($cursos as $i => $c) {
                    $_SESSION['curso'] = $c;
                    if (strcmp($c, "cienciadacomputacao") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 1));
                        if (!$verif) {
                            $_SESSION['pau10'] = $pstmt->errorInfo();
                            return false;
                        }
                    }

                    if (strcmp($c, "engenhariaquimica") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 2));
                        if (!$verif) {
                            $_SESSION['pau20'] = $pstmt->errorInfo();
                            return false;
                        }
                    }

                    if (strcmp($c, "tecnicoeminformatica") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 3));
                        if (!$verif) {
                            $_SESSION['pau30'] = $pstmt->errorInfo();
                            return false;
                        }
                    }

                    if (strcmp($c, "tecnicoemquimica") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 4));
                        $_SESSION['pau39'] = "Inseriu";
                        if (!$verif) {
                            $_SESSION['pau40'] = $pstmt->errorInfo();
                            return false;
                        }
                    }

                    if (strcmp($c, "tecnicoemeletrotecnica") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 5));
                        if (!$verif) {
                            $_SESSION['pau50'] = $pstmt->errorInfo();
                            return false;
                        }
                    }

                    if (strcmp($c, "tecnicoemsegurancadotrabalho") == 0) {
                        $pstmt = $this->conn->prepare("INSERT INTO leciona (po_siape, oferece_curso_id) VALUES(?,?)");
                        $verif = $pstmt->execute(array($funcionario->getsiape(), 6));
                        if (!$verif) {
                            $_SESSION['pau60'] = $pstmt->errorInfo();
                            return false;
                        }
                    }
                }
            }

            return $this->conn->commit();
        } catch (PDOException $e) {
            $this->conn->rollback();
            return false;
        }
    }

}

?>