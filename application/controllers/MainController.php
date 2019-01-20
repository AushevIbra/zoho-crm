<?php
namespace application\controllers;
use application\core\Controller;
class MainController extends Controller {

    public function indexAction()
    {
        //$class = new ZohoCrm();
        $status = "";
        if($_POST){
          $res = $this->zoho->checkLead($_POST['phone']);
          if($res == null) {

              $result = $this->zoho->addLead($_POST);
              $status = "Лид добавлен";
          }
          else {
            $data = $this->zoho->convertDeal($res->data[0]->id, $_POST);
            $status = "Сделка заключена";
          }

        }
        $this->view->render('Главная', ['status' => $status]);
    }

    public function tokenAction()
    {
        if($_GET['code']){
            $redirect_uri = $this->zoho->redirect_uri;
            $secret_key = $this->zoho->secret_key;
            $client_id = $this->zoho->client_id;

            $code = $_GET['code'];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,"https://accounts.zoho.com/oauth/v2/token?code=$code&redirect_uri=$redirect_uri&client_id=$client_id&client_secret=$secret_key&grant_type=authorization_code");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close ($ch);
            $result = json_decode($server_output);
            setcookie('token', $result->access_token);
            header("Location: /");

        }


    }
}
