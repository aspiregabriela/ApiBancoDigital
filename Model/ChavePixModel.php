<?php

namespace ApiBancoDigital\Model;
use ApiBancoDigital\DAO\ChavePixDAO;

class ChavePixModel extends Model {
    public $id, $tipo, $chave, $id_conta;

    public $rows;

    public function save()
    {
        include 'DAO/ChavePixDAO.php';
        $dao = new ChavePixDAO();

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
        $dao = new ChavePixDAO();

        $this->rows = $dao->select();

    }

    public function delete()
    {
        (new ChavePixDAO())->delete($this->id);
    }


}