<?php

namespace ApiBancoDigital\DAO;

use ApiBancoDigital\Model\ChavePixModel;
use PDO;


class ChavePixDAO extends DAO
{

    public function __construct()
    {
        parent::__construct();       
    }

    public function save(ChavePixModel $model) : ?ChavePixModel
    {
        return ($model->id == null) ? $this->insert($model) : $this->update($model);
    }



    public function select()
    {
        $sql = "SELECT * FROM chave_pix ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(DAO::FETCH_CLASS);
    }


    public function insert(ChavePixModel $m) : ChavePixModel
    {
        $sql = "INSERT INTO chave_pix (chave, tipo, id_conta) VALUES (?, ?, ?) ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $m->chave);
        $stmt->bindValue(2, $m->tipo);
        $stmt->bindValue(3, $m->id_conta);

        $m->id = $this->conexao->lastInsertId();

        return $m;

    }

    public function update(ChavePixModel $m)
    {
        $sql = "UPDATE chave_pix SET chave= ?, tipo= ?, id_conta= ? WHERE id=? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $m->chave);
        $stmt->bindValue(2, $m->tipo);
        $stmt->bindValue(3, $m->id_conta);
        $stmt->bindValue(4, $m->id);

        return $stmt->execute();
    }

    public function delete(int $id) : bool
    {
        $sql = "DELETE FROM chave_pix WHERE id = ? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }
}