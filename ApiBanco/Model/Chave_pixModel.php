<?php

namespace ApiBancoDigital\Model;
use ApiBancoDigital\DAO\Chave_pixDAO;

class ChavePixModel extends Model {
    public $id, $tipo, $chave, $id_conta;

    public $rows;

    public function save()
    {
        include 'DAO/ChavePixDAO.php';
        $dao = new Chave_pixDAO();

        if(empty($this->id))
        {
            $dao->insert($this);
        } else {
            $dao->update($this);
        }
    }

    public function getAllRows()
    {
        include 'DAO/ChavePixDAO.php';
        $dao = new Chave_pixDAO();

        $this->rows = $dao->select();

    }

    public function delete()
    {
        (new Chave_pixDAO())->delete($this->id);
    }

    
    public function getById(int $id)
    {
        include 'DAO/ChavePixDAO.php';
        $dao = new Chave_pixDAO();
        $obj = $dao->selectById($id);

        return($obj) ? $obj : new ChavePixModel();
    }
}