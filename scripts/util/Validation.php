<?php

class Validation{
    public static $REQUIRED = 'required';
    public static $MIN_SIZE = 'min_size';
    public static $MAX_SIZE = 'max_size';
    public static $EMAIL = 'email';
    public static $INTEGER = 'integer';
    public static $DATE = 'date';
    public static $TIME = 'time';
    public static $CNPJ = 'cnpj';
    public static $CPF = 'cpf';
    public static $TELEPHONE = 'tel';

    //array para ser validado
    private $toValidate;

    //campos que devem ser validados
    private $fields;

    //erros após a validação
    private $errors;

    //mensagens de erro
    private $msgs;

    public function __construct($toValidate){
        $this->toValidate = $toValidate;
    }

    public function addField($key, $validations, $msgs = array()){
        $this->fields[$key] = $validations;

        foreach($validations as $type => $params){
            $this->msgs[$key] = $msgs;
        }
    }

    /*
        Se shortCiruit = true: para no primeiro erro encontrado e o registra
        caso contrário, vai processar todos os erros
    */
    public function validate($shortCircuit = true){
        $this->errors = array();

        foreach($this->fields as $key => $validations){
            if(isset($this->toValidate[$key])){

                //os parâmetros de uma validação podem ser um array ou apenas um valor
                foreach($validations as $type => $params){
                    if($type == 'required')
                        continue;

                    if(!$this->internalValidation($key, $type, $params)){
                        echo "Error: " . $key . " " . $type . " " . $params . "<br>";
                        $this->errors[$key][] = $type;
                        break;
                    }
                }
            }else if(isset($this->fields[$key][self::$REQUIRED])){
                $this->errors[$key][] = self::$REQUIRED;
            }

            if(count($this->errors) > 0 && $shortCircuit)
                return false;
        }

        return count($this->errors) == 0;
    }

    public function pushErrors(&$session){
        foreach($this->errors as $key => $errors){
            foreach($errors as $type){
                $msg;
                if(isset($this->msgs[$key][$type])){
                    $msg = $this->msgs[$key][$type];
                }else{
                    $msg = $this->defaultMessage($type, $this->fields[$key][$type]);
                }
                $session->pushError($msg, $key);
            }
        }
    }

    //retorna true caso tenha sido validado sem erros
    private function internalValidation($field, $validation, $params){
        $value = $this->toValidate[$field];

        //métodos de validação padrão(OBS: é possível editar esta classe para adicionar métodos definidos pelo usuário)
        switch($validation){
            case self::$MIN_SIZE:
                return strlen($value) >= $params;
            break;
            case self::$MAX_SIZE:
                return strlen($value) <= $params;
            break;
            case self::$EMAIL:
                return filter_var($value, FILTER_VALIDATE_EMAIL) != false;
            break;
            case self::$INTEGER:
                return is_numeric($value);
            break;
            case self::$DATE:
                return $this->validateDate($value);
            break;
            case self::$TIME:
                return $this->validateTime($value);
            break;
            case self::$CNPJ:
                return $this->validateCNPJ($value);
            break;
            case self::$CPF:
                return $this->validateCPF($value);
            break;
            case self::$TELEPHONE:
                return $this->validateTelephone($value);
            break;
        }
    }

    //carregar mensgaens padrão quando não são fornecidas
    private function defaultMessage($type, $params){
        switch($type){
            case self::$REQUIRED:
                return 'Preencha este campo!';
            break;
            case self::$MIN_SIZE:
                return 'Tamanho mínimo é :' . $params;
            break;
            case self::$MAX_SIZE:
                return 'Tamanho máximo é: ' . $params;
            break;
            case self::$EMAIL:
                return 'Email fornecido é inválido.';
            break;
            default:
                return 'Dados inválidos.';
            break;
            case self::$INTEGER:
                return 'Apenas números.';
            break;
            case self::$DATE:
                return 'Formato de data inválido.';
            break;
            case self::$TIME:
                return 'Formato de tempo inválido.';
            break;
            case self::$CNPJ:
                return 'cnpj inválido.';
            break;
            case self::$CPF:
                return 'cpf inválido.';
            break;
            case self::$TELEPHONE:
                return 'Telefone inválido.';
            break;
        }
    }

    /* Métodos de validação abaixo */

    private function validateDate($date){
        $d = explode('-', $date);

        if(count($d) != 3)
            $d = explode('/', $date);

        if(count($d) == 3){
            return is_numeric($d[0]) && is_numeric($d[1]) && is_numeric($d[2]);
        }else{
            return false;
        }
    }

    private function validateTime($time){
        $time = explode(':', $time);
        if(count($time) == 2){
            return is_numeric($time[0]) && is_numeric($time[1]);
        }else{
            return false;
        }
    }

    private function validateCNPJ($cnpj){
        //xx.xx.xxx/xxx-xx
        return preg_match('/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/', $cnpj) == 1;
    }

    private function validateCPF($cpf){
        //xxx.xxx.xxx-xx
        return preg_match('/^\d{3}\.\d{3}\.\d{3}\-\d{2}$/', $cpf) == 1;
    }

    private function validateTelephone($tel){
        //[(xx)] xxxx-xxxx
        return preg_match('/^(\(\d{2}\)|)(| )\d{4}-\d{4}$/', $tel) == 1;
    }
}