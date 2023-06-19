<?php
namespace ApiBancoDigital\Controller;
use ApiBancoDigital\Model\ChavePixModel;
use Exception;

class ChavePixController extends Controller {
	public static function salvar() 
	{
		try
        {
            $json_obj = json_decode(file_get_contents('php://input'));

            $model = new ChavePixModel();
            $model->id = $json_obj->Id;
            $model->chave = $json_obj->Chave;
            $model->tipo = $json_obj->Tipo;
            $model->id_conta = $json_obj->Id_conta;


            $model->save();

        } catch (Exception $e) {

            parent::getExceptionAsJSON($e);
        }
	}
	public static function listar() : void
    {
        try
        {
            $model = new ChavePixModel();

            $model->getAllRows();

            parent::getResponseAsJSON($model->rows);

        } catch (Exception $e) {

            parent::getExceptionAsJSON($e);
        }
    }

    public static function deletar() : void
    {
        try 
        {
            $model = new ChavePixModel();

            $model->id = parent::getIntFromUrl(isset($_GET['id']) ? $_GET['id'] : null);

            $model->delete();


        } catch (Exception $e) {

            parent::getExceptionAsJSON($e);
        }
    }
}