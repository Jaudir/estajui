<?php

/**
 * Interface de relações com o BD
 *
 * @author gabriel Lucas
 */
interface CrudInterface {

    /**
     * Salvar
     *
     * Salva o objeto no BD
     *
     * @return string Mensagem de erro ou sucesso
     * @access public
     */
    public function create();
    public function createOnTransaction($conexao);

    /**
     * Leitura
     *
     * Lê objetos do bd.
     *
     * @param mixed $key Chave a ser consultada
     * @return array Vetor de objetos encontrados
     * @access public
     */
    public static function read($key, $limite);

    /**
     * Atualizar
     *
     * Atualiza um objeto no BD
     *
     * @return string Mensagem de erro ou sucesso
     * @access public
     */
    public function update();

    /**
     * Remover
     *
     * Remove o objeto no BD
     *
     * @return string Mensagem de erro ou sucesso
     * @access public
     */
    public function delete();
}
