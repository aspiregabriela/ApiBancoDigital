<?php

namespace ApiBancoDigital\Controller;
use ApiBancoDigital\Model\ContaModel;
use Exception;
class ContaController extends Controller
{

    public static function salvar() : void
    {
        try
        {
            $json_obj = json_decode(file_get_contents('php://input'));

            $model = new ContaModel();
            $model->id = $json_obj->Id;
            $model->numero = $json_obj->Numero;
            $model->tipo = $json_obj->Tipo;
            $model->senha = $json_obj->Senha;
            $model->id_correntista = $json_obj->Id_correntista;


            $model->save();

        } catch (Exception $e) {

            parent::getExceptionAsJSON($e);
        }
    }

    public static function listar() : void
    {
        try
        {
            $json_obj = json_decode(file_get_contents('php://input'));


			$model = new ContaModel();
			$model->id_correntista = $json_obj->id_correntista;


			parent::getResponseAsJSON($model->getContaByIdCorrentista($json_obj->id));

        } catch (Exception $e) {

            parent::LogError($e);
            parent::getExceptionAsJSON($e);
        }
    }
    public static function deletar() : void
    {
        try 
        {
            $model = new ContaModel();

            $model->id = parent::getIntFromUrl(isset($_GET['id']) ? $_GET['id'] : null);

            $model->delete();


        } catch (Exception $e) {

            parent::getExceptionAsJSON($e);
        }
    }

    public static function SelecionarConta() : void
	{
		try
		{
			$json_obj = json_decode(file_get_contents('php://input'));

			parent::getResponseAsJSON((new ContaModel())->getContaByNumeroConta($json_obj->numero));
		}
		catch(Exception $e)
		{
			parent::getResponseAsJSON($e);
		}
	}
}