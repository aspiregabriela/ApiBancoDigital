<?php

namespace ApiBancoDigital\Model;

use ApiBancoDigital\DAO\ContaDAO;
use ApiBancoDigital\DAO\CorrentistaDAO;

class CorrentistaModel extends Model
{
   
    public $id, $nome, $cpf, $data_nasc, $senha;
    public $rows_conta;
 
    public function save() : ?CorrentistaModel
    {
        $dao_correntista = new CorrentistaDAO();
        
        $model_preenchido = $dao_correntista->save($this);

        
        if($model_preenchido->id != null)
        {
            $dao_conta = new ContaDAO();

            //conta corrente
            $conta_corrente = new ContaModel();
            $conta_corrente->id_correntista = $model_preenchido->id;
            $conta_corrente->tipo = 'C';
            $conta_corrente = $dao_conta->insert($conta_corrente);

            $model_preenchido->rows_contas[] = $conta_corrente;

            // conta poupança
            $conta_poupanca = new ContaModel();
            $conta_poupanca->id_correntista = $model_preenchido->id;
            $conta_poupanca->tipo = 'P';
            $conta_poupanca = $dao_conta->insert($conta_poupanca);

            $model_preenchido->rows_contas[] = $conta_poupanca;
        }

        return $model_preenchido;    
    }

    
    public function getAllRows()
    {
        $this->rows = (new CorrentistaDAO())->select();
    }

   
    public function delete()
    {
        (new CorrentistaDAO())->delete($this->id);
    }
    public function getByCpfAndSenha($cpf, $senha) : CorrentistaModel
    {      
        return (new CorrentistaDAO())->selectByCpfAndSenha($cpf, $senha);
    }

}