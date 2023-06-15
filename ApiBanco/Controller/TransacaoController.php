<?php
namespace ApiBancoDigital\Controller;

class TransacaoController extends Controller {
	public static function save() 
	{
		try
        {
            $json_obj = json_decode(file_get_contents('php://input'));

            $model = new TransacaoModel();
            $model->id = $json_obj->Id;
            $model->data_trans = $json_obj->Data_trans;
            $model->id_conta_enviou = $json_obj->Id_conta_enviou;  
            $model->id_conta_recebeu = $json_obj->Id_conta_recebeu;
           

            $model->save();
              
        } catch (Exception $e) {

            parent::getExceptionAsJSON($e);
        }
    }

	
	public static function listar() 
	{
		try
        {
            $model = new TransacaoModel();
            
            $model->getAllRows();

            parent::getResponseAsJSON($model->rows);
              
        } catch (Exception $e) {

            parent::getExceptionAsJSON($e);
        }

	}

	public static function delete() 
	{
		try
		{
            $model = new TransacaoModel();
            
            $model->id = parent::getIntFromUrl(isset($_GET['id']) ? $_GET['id'] : null);

            $model->delete();

           
        } catch (Exception $e) {

            parent::LogError($e);
            parent::getExceptionAsJSON($e);
        }
	}
}