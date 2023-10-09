<?php

namespace ApiBancoDigital\DAO;
use ApiBancoDigital\Model\ContaModel;
use \PDO;


class ContaDAO extends DAO
{

    public function __construct()
    {
         return parent::__construct();       
    }


    public function select()
    {
        $sql = "SELECT * FROM conta";

        $stmt=$this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }


    public function insert(ContaModel $m) : ContaModel
    {
        $sql = "INSERT INTO conta (numero, tipo, senha, id_correntista) VALUES (?, ?, ?, ?) ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $m->numero);
        $stmt->bindValue(2, $m->tipo);
        $stmt->bindValue(3, $m->senha);
        $stmt->bindValue(4, $m->id_correntista);

        $m->id = $this->conexao->lastInsertId();

        return $m;

    }
    public function selectByIdCorrentista(int $id_correntista) : array
    {
        
        $sql = "SELECT * FROM conta WHERE id_correntista=?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1,$id_correntista);
        $stmt->execute();

        return $stmt->fetchAll(DAO::FETCH_CLASS, "ApiBancoDigital\Model\ContaModel");
    }
    public function numeroConta(){

        $pt1 = rand(10000000,99999999);
        $pt2 = rand(0,9);

        $num_conta = $pt1."-".$pt2;

        return $num_conta;

    }

    public function selectByNumeroConta(string $numero)
    {      
        $sql = "SELECT * FROM conta WHERE numero=?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1,$numero);
        $stmt->execute();
        
        $obj = $stmt->fetchObject("ApiBancoDigital\Model\ContaModel");

        if (is_object($obj))
        {
            
            return $obj;
        }
        else return new ContaModel();

        
    }

    public function update(ContaModel $model)
    {
        $sql = "UPDATE conta SET numero= ?, tipo= ?, senha= ? id_correntista= ? WHERE id=? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model ->tipo);
       
        $stmt->bindValue(4, $model ->id);

        return $stmt->execute();
    }

    public function delete(int $id) : bool
    {
        $sql = "DELETE FROM conta WHERE id = ? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }
}