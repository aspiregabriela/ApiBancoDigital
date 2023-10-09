<?php

namespace ApiBancoDigital\Model;

use ApiBancoDigital\DAO\ContaDAO;
use ApiBancoDigital\DAO\ChavePixDAO;
use Exception;

class ContaModel extends Model
{

    public $id, $numero, $tipo, $senha, $id_correntista;
    public $lista_pix, $rows;

    public function save()
    {
        include 'DAO/ContaDAO.php';
        $dao = new ContaDAO();

        if(empty($this->id))
        {
            $dao->insert($this);
        } else {
            $dao->update($this);
        }
    }
    public function getById(int $id)
    {
        include 'DAO/ContaDAO.php';
        $dao = new ContaDAO();
       // $obj = $dao->selectById($id);

        return($obj) ? $obj : new ContaModel();
    }

    public function getAllRows(int $id)
    {
        include 'DAO/ContaDAO.php';
        $dao = new ContaDAO();

        $this->rows = $dao->select();
    }
    public function getContaByIdCorrentista(int $id_correntista)
    {
            $dao = new ContaDAO();

            $this->rows = $dao->selectByIdCorrentista($id_correntista);
    }

    public function getContaByNumeroConta(string $numero)
    {
        return (new ContaDAO())->selectByNumeroConta($numero);
    }

    public function getAllChaves()
    {
        include './DAO/ChavePixDAO.php';

        $dao = new ChavePixDAO;

        $this->lista_pix = $dao->select();
    }


    public function delete()
    {
        (new ContaDAO())->delete($this->id);
    }
}