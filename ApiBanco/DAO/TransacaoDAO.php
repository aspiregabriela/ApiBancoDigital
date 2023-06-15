<?php

namespace ApiBancoDigital\DAO;
use ApiBancoDigital\Model\TransacaoModel;
use \PDO;

class TransacaoDAO extends DAO
{
    public function __construct()
    {
        return parent::__construct();    
    }

    public function insert (TransacaoModel $model)
    {
        $sql = "INSERT INTO transacao (data_trans, valor, id_conta_enviou, id_conta_recebeu) VALUES (?, ?, ?, ?)";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->data_trans);
        $stmt->bindValue(2, $model->valor);
        $stmt->bindValue(3, $model->id_conta_enviou);
        $stmt->bindValue(4, $model->id_conta_recebeu);
        $stmt->execute();

    }

    public function update(TransacaoModel $model)
    {
        $sql = "UPDATE transacao SET data_trans=?, valor=?, id_conta_enviou=?, id_conta_recebeu=? WHERE id=?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->data_trans);
        $stmt->bindValue(2, $model->valor);
        $stmt->bindValue(3, $model->id_conta_enviou);
        $stmt->bindValue(4, $model->id_conta_recebeu);
        $stmt->bindValue(5, $model->id);
        $stmt->execute();
    }

    public function select()
    {
        $sql = "SELECT * FROM conta";

        $stmt=$this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function selectById(int $id)
    {
        include_once 'Model/TransacaoModel.php';

        $sql = "SELECT id, data_trans, valor, id_conta_enviou, id_conta_recebeu FROM transacao WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $stmt->fetchObject("ApiBancoDigital\Model\TransacaoModel");
    }


    public function delete(int $id)
    {
        $sql = "DELETE FROM transacao WHERE id = ? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }
}