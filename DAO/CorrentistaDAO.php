<?php

namespace ApiBancoDigital\DAO;
use ApiBancoDigital\Model\CorrentistaModel;
use \PDO;

class CorrentistaDAO extends DAO
{

    public function __construct()
    {
       return parent::__construct();       
    }
    public function save(CorrentistaModel $m): ?CorrentistaModel
    {
        return ($m->id == null) ? $this->insert($m) : $this->update($m);
    }


    public function insert(CorrentistaModel $model): CorrentistaModel
    {
        $sql = "INSERT INTO correntista (nome, cpf, data_nasc, senha) VALUES (?, ?, ?, ?) ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->nome);
        $stmt->bindValue(2, $model->cpf);
        $stmt->bindValue(3, $model->data_nasc);
        $stmt->bindValue(4, $model->senha);
        $stmt->execute();

        $model->id = $this->conexao->lastInsertId();

        return $model;


    }

    public function selectCorrentistaByCpfAndSenha(CorrentistaModel $model) 
    {
        $sql = "SELECT * FROM Correntista WHERE cpf = ? AND senha = ?;";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->cpf);
        $stmt->bindValue(2, $model->senha);
        $stmt->execute();

        return $stmt->fetchObject();
    }
    public function select()
    {
        $sql = "SELECT * FROM conta";

        $stmt=$this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    public function update(CorrentistaModel $model)
    {
        $sql = "UPDATE correntista SET nome= ?, cpf= ?, data_nasc= ?, senha= ? WHERE id=? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->nome);
        $stmt->bindValue(2, $model->cpf);
        $stmt->bindValue(3, $model->data_nasc);
        $stmt->bindValue(4, $model->senha);
        $stmt->bindValue(5, $model->id);

        return $stmt->execute();
    }

    public function delete(int $id) : bool
    {
        $sql = "DELETE FROM correntista WHERE id = ? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }

    public function selectById(int $id)
    {
        include_once 'Model/CorrentistaModel.php';

        $sql = "SELECT id, nome, cpf, senha, data_nasc FROM conta WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $stmt->fetchObject("ApiBancoDigital\Model\CorrentistaModel");
    }
    public function search(string $query) : array
    {
        $str_query = ['filtro' => '%' . $query . '%'];

        $sql = "SELECT * FROM correntista WHERE nome LIKE :filtro ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute($str_query);

        return $stmt->fetchAll(DAO::FETCH_CLASS, "ApiBancoDigital\Model\CorrentistaModel");
    }

    
    public function selectByCpfAndSenha($cpf, $senha) : CorrentistaModel
    {
        $sql = "SELECT * FROM correntista WHERE cpf = ? AND senha = sha1(?) ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $cpf);
        $stmt->bindValue(2, $senha);
        $stmt->execute();

        /**
         * Aqui estamos organizando os dados vindos do banco como um Model CorrentistaModel
         * mas se a query não tiver nenhum resultado fetchObject retorna um bool false e portanto,
         * neste caso fetchObject pode retornar um objeto ou um bool.
         */
        $obj = $stmt->fetchObject("App\Model\CorrentistaModel");

        /**
         * Aqui verificamos se o retorno do banco foi um objeto do tipo model
         * (portando o usuário colocou CPF e Senha corretos e um resultado foi encontrado) ou
         * um bool false, que indica que nenhum resultado foi encontrado.
         * Se for um bool, nós iremos retornar um model Vazio (por padrão as propriedades são null)
         * e iremos verificar no App se a propriedade Id é null ou não.
         */
        return is_object($obj) ? $obj : new CorrentistaModel();
    }
    public function getCorrentistaByCpfAndSenha($cpf, $senha)
    {
        $sql = "SELECT * FROM correntista c WHERE cpf = ? AND senha = ? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $cpf);
        $stmt->bindValue(2, $senha);

        $stmt->execute();

        $obj = $stmt->fetchObject("ApiBancoDigital\Model\CorrentistaModel");

        if(is_object($obj))
        {
            // chamar a dao de contas
            $obj->lista_conta = (new ContaDAO)->selectByIdCorrentista($obj->id);

            return $obj;
            
        } else
            return new CorrentistaModel();
    }

    public function getCorrentistabyCPF($cpf)
    {
        $sql = "SELECT * FROM correntista WHERE cpf = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $cpf);

        $obj = $stmt->fetchObject("ApiBancoDigital\Model\CorrentistaModel");

        if (is_object($obj))
        {
            var_dump($obj);
            return $obj;
        }
        else return new CorrentistaModel();
    }



}
	