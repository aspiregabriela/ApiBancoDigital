<?php

namespace ApiBancoDigital\Model;
use ApiBancoDigital\DAO\CorrentistaDAO;

class CorrentistaModel extends Model
{
   
    public $id, $nome, $cpf, $data_nasc, $senha;
    
 
    public function save()
    {
        if($this->id == null)
            return (new CorrentistaDAO())->insert($this);
        else
            return (new CorrentistaDAO())->update($this);
    }

    
    public function getAllRows()
    {
        $this->rows = (new CorrentistaDAO())->select();
    }

   
    public function delete()
    {
        (new CorrentistaDAO())->delete($this->id);
    }
}