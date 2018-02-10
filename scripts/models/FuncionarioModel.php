<?php

require_once('MainModel.php');
require_once $_SERVER['DOCUMENT_ROOT'] . "/estajui/scripts/daos/Funcionario.php";

class FuncionarioModel extends MainModel {

    private $_tabela = "funcionario";

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

    public function create(Funcionario $funcionario) {
        $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
        $result = $usuarioModel->create($funcionario);
        if ($result == 0) {
            $pstmt = $this->$conn->prepare("INSERT INTO " . $this->_tabela . " (siape, nome, bool_po, bool_oe, bool_ce, bool_sra, bool_root, formacao, privilegio, usuario_email, campus_cnpj) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            try {
                $this->$conn->beginTransaction();
                $pstmt->execute(array($funcionario->getsiape(), $funcionario->getnome(), (int) $funcionario->ispo(), (int) $funcionario->isoe(), (int) $funcionario->isce(), (int) $funcionario->issra(), (int) $funcionario->isroot(), $funcionario->getformacao(), (int) $funcionario->isprivilegio(), $funcionario->getlogin(), $funcionario->getcampus()->getcnpj()));
                $this->$conn->commit();
                return 0;
            } catch (PDOExecption $e) {
                $this->$conn->rollback();
                #return "Error!: " . $e->getMessage() . "</br>";
                return 2;
            }
        } else {
            return $result;
        }
    }

    public function read($siape, $limite) {
        if ($limite == 0) {
            if ($siape == NULL) {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE siape LIKE :siape");
                $pstmt->bindParam(':siape', $siape);
            }
        } else {
            if ($siape == NULL) {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE siape LIKE :siape LIMIT :limite");
                $pstmt->bindParam(':siape', $siape);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
                $campusModel = $this->loader->loadModel("CampusModel", "CampusModel");
                $user = $usuarioModel->read($row["usuario_email"], 1)[0];
                $result[$cont] = new Funcionario($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["siape"], $row["nome"], boolval($row["bool_po"]), boolval($row["bool_oe"]), boolval($row["bool_ce"]), boolval($row["bool_sra"]), boolval($row["bool_root"]), $row["formacao"], boolval($row["privilegio"]), $campusModel->read($row["campus_cnpj"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbyusuario(Usuario $user, $limite) {
        $key = $user->getlogin();
        if ($limite == 0) {
            if ($key == NULL) {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE usuario_email LIKE :usuario_email");
                $pstmt->bindParam(':usuario_email', $key);
            }
        } else {
            if ($key == NULL) {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE usuario_email LIKE :usuario_email LIMIT :limite");
                $pstmt->bindParam(':usuario_email', $key);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $campusModel = $this->loader->loadModel("CampusModel", "CampusModel");
                $result[$cont] = new Funcionario($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["siape"], $row["nome"], boolval($row["bool_po"]), boolval($row["bool_oe"]), boolval($row["bool_ce"]), boolval($row["bool_sra"]), boolval($row["bool_root"]), $row["formacao"], boolval($row["privilegio"]), $campusModel->read($row["campus_cnpj"], 1)[0]);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function readbycampus(Campus $campus, $limite) {
        $key = $campus->getcnpj();
        if ($limite == 0) {
            if ($key == NULL) {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . "");
            } else {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE campus_cnpj LIKE :campus_cnpj");
                $pstmt->bindParam(':campus_cnpj', $key);
            }
        } else {
            if ($key == NULL) {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . " LIMIT :limite");
            } else {
                $pstmt = $this->$conn->prepare("SELECT * FROM " . $this->_tabela . " WHERE campus_cnpj LIKE :campus_cnpj LIMIT :limite");
                $pstmt->bindParam(':campus_cnpj', $key);
            }
            $pstmt->bindParam(':limite', $limite, PDO::PARAM_INT);
        }
        try {
            $pstmt->execute();
            $cont = 0;
            $result = [];
            while ($row = $pstmt->fetch()) {
                $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
                $user = $usuarioModel->read($row["usuario_email"], 1)[0];
                $result[$cont] = new Funcionario($user->getlogin(), $user->getsenha(), $user->gettipo(), $row["siape"], $row["nome"], boolval($row["bool_po"]), boolval($row["bool_oe"]), boolval($row["bool_ce"]), boolval($row["bool_sra"]), boolval($row["bool_root"]), $row["formacao"], boolval($row["privilegio"]), $campus);
                $cont++;
            }
            return $result;
        } catch (PDOExecption $e) {
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function update(Funcionario $funcionario) {
        $pstmt = $this->$conn->prepare("UPDATE " . $this->_tabela . " SET siape=?, nome=?, bool_po=?, bool_oe=?, bool_ce=?, bool_sra=?, bool_root=?, formacao=?, privilegio=?, campus_cnpj=? WHERE siape = ?");
        try {
            $this->$conn->beginTransaction();
            $pstmt->execute(array($funcionario->getsiape(), $funcionario->getnome(), (int) $funcionario->ispo(), (int) $funcionario->isoe(), (int) $funcionario->isce(), (int) $funcionario->issra(), (int) $funcionario->isroot(), $funcionario->getformacao(), (int) $funcionario->isprivilegio(), $funcionario->getlogin(), $funcionario->getcampus()->getcnpj(), $funcionario->getsiape()));
            $this->$conn->commit();
            $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
            return $usuarioModel->update($funcionario);
        } catch (PDOExecption $e) {
            $this->$conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

    public function delete(Funcionario $funcionario) {
        $pstmt = $this->$conn->prepare("DELETE from " . $this->_tabela . " WHERE siape LIKE ?");
        try {
            $this->$conn->beginTransaction();
            $pstmt->execute(array($this->getsiape()));
            $this->$conn->commit();
            $usuarioModel = $this->loader->loadModel("UsuarioModel", "UsuarioModel");
            return $usuarioModel->delete($funcionario);
        } catch (PDOExecption $e) {
            $this->$conn->rollback();
            #return "Error!: " . $e->getMessage() . "</br>";
            return 2;
        }
    }

}

?>