<?php


namespace App\Controller;


use App\Lib\LibClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends AbstractController implements TokenAuthenticatedController
{
  /*
   * Добавление нового клиента
   * Methods[POST]
   * Пример body:
   *    {
          "client_passport_ID": "5413288366",
          "client_name": "Михаил",
          "client_secondname": "Михайлов",
          "client_patr": "Михайлович",
          "client_phone": "+78888888888",
          "client_drive_license": 	"888888"
        }
  */
  public function addNewClient(Request $request, LibClient $client)
  {
    $client_passport_ID = $request->request->get('client_passport_ID', null);
    $client_name = $request->request->get('client_name', null);
    $client_secondname = $request->request->get('client_secondname', null);
    $client_patr = $request->request->get('client_patr', null);
    $client_phone = $request->request->get('client_phone', null);
    $client_drive_license = $request->request->get('client_drive_license', null);


    $client->addNewClient($client_passport_ID, $client_name,
        $client_secondname, $client_patr,
        $client_phone, $client_drive_license);

    return $this->json(['status' => 'OK', 'message' => '', 'data' => []]);
  }
}