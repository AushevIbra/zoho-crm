<?php
namespace application\lib;
class ZohoCrm {
    public $client_id;
    public $redirect_uri;
    public $secret_key;

    public function __construct()
    {
        $data = require 'application/config/zoho_crm.php';
        $this->client_id = $data['client_id'];
        $this->redirect_uri = $data['redirect_uri'];
        $this->secret_key = $data['secret_key'];
    }

    public function checkLead($phone)
    {

        $result = $this->sendRequest('Leads', null, "search?phone=" . $phone);
        
        return $result;
    }

    public function sendRequest($module, $data, $query = null)
    {
        $url = ($query != null) ? "https://www.zohoapis.com/crm/v2/$module/$query" : "https://www.zohoapis.com/crm/v2/$module";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if($data){
          curl_setopt($ch, CURLOPT_POSTFIELDS,     json_encode($data) );
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Authorization: Zoho-oauthtoken ' . $_COOKIE['token'],
          'Content-Type: application/json'
        ));
        $server_output = curl_exec($ch);
        curl_close ($ch);
        $result = json_decode($server_output);
        if(isset($result->code) &&  $result->code == "INVALID_TOKEN"){
          setcookie("token", "", time()-3600);
          header('Location: /');
        }


        return $result;
    }

    public function addLead($data)
    {
      $fields = [
        'data' => [
          [
            "Email" => $data['email'],
            "Lead_Source" => $data['other'],
            "Last_Name" => $data['name'],
            "Phone" => $data['phone'],
          ]
        ]
      ];
      $result = $this->sendRequest('Leads', $fields);

      return $result;
    }

    public function convertDeal($id_lead, $array) {
      $amount = count(explode('.', $array['sum'])) > 1 ? (float) $array['sum'] :  (int) $array['sum'];
      $fields = [
        'data' => [
          [
            "overwrite" => true,
            "notify_lead_owner" => true,
            "notify_new_entity_owner" => true,

            "Deals" => [
                "Deal_Name" => $array['name'],
                "Closing_Date" => date('Y-m-d'),
                "Stage" => "Closed Won",
                "Amount" => $amount
            ]
          ]

      ]];
      $result = $this->sendRequest('Leads', $fields, "$id_lead/actions/convert");

      return $result;

    }

}
