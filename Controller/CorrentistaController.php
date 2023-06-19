<?php

namespace ApiBancoDigital\Controller;

use ApiBancoDigital\Model\CorrentistaModel;
use Exception;



class CorrentistaController extends Controller
{
    /**
     * 
     */
    public static function salvar() : void
    {
        try
        {
            $json_obj = json_decode(file_get_contents('php://input'));

            $model = new CorrentistaModel();
            $model->nome = $json_obj->nome;
            $model->cpf = $json_obj->cpf;
            $model->data_nasc = $json_obj->data_nasc;
            $model->senha = $json_obj->senha;

            parent::getResponseAsJSON($model->save());

        } catch (Exception $e) {
            echo "DEU ERRO: " . $e->getMessage();
            parent::getExceptionAsJSON($e);
        }
    }

    public static function listar() : void
    {
        try
        {
            $model = new CorrentistaModel();

            $model->getAllRows();

            parent::getResponseAsJSON($model->rows);

        } catch (Exception $e) {

            parent::LogError($e);
            parent::getExceptionAsJSON($e);
        }
    }

    public static function deletar() : void
    {
        try 
        {
            $model = new CorrentistaModel();

            $model->id = parent::getIntFromUrl(isset($_GET['id']) ? $_GET['id'] : null);

            $model->delete();


        } catch (Exception $e) {
            echo "DEU ERRO: " . $e->getMessage();
            parent::getExceptionAsJSON($e);
        }
    }

    public static function buscar() : void
    {
        try
        {
            $model = new CorrentistaModel();

            $q = json_decode(file_get_contents('php://input'));


            $model->getAllRows($q);

            parent::getResponseAsJSON($model->rows);

        } catch (Exception $e) {

            parent::LogError($e);
            parent::getExceptionAsJSON($e);
        }
    }
}