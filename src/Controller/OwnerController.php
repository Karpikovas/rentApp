<?php


namespace App\Controller;


use App\Lib\LibOwner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class OwnerController extends AbstractController implements TokenAuthenticatedController
{
  /*
   * Добавление нового владельца
   * Methods[POST]
   * Пример body:
   *    {
          "owner_passport_ID": "5413288366",
          "owner_name": "Михаил",
          "owner_secondname": "Михайлов",
          "owner_patr": "Михайлович",
          "owner_phone": "+78888888888",
          "owner_drive_license": 	"888888"
        }
  */
  public function addNewOwner(Request $request, LibOwner $owner)
  {
    $owner_passport_ID = $request->request->get('owner_passport_ID', null);
    $owner_name = $request->request->get('owner_name', null);
    $owner_secondname = $request->request->get('owner_secondname', null);
    $owner_patr = $request->request->get('owner_patr', null);
    $owner_phone = $request->request->get('owner_phone', null);
    $owner_drive_license = $request->request->get('owner_drive_license', null);


    $owner->addNewOwner($owner_passport_ID, $owner_name,
                        $owner_secondname, $owner_patr,
                        $owner_phone, $owner_drive_license);

    return $this->json(['status' => 'OK', 'message' => '', 'data' => []]);
  }
  /*
   * Удаление владельца по индентификатору carID
   * Methods[POST]
   * */
  public function deleteOwnerByID($ownerID, LibOwner $owner)
  {
    $owner->deleteownerByID($ownerID);

    return $this->json(['status' => 'OK', 'message' => '', 'data' => []]);
  }
  /*
   * Обновление информации о владельце
   * Methods[POST]
   * Пример body:
   *    {
          "owner_passport_ID": "5413288366",
          "owner_name": "Михаил",
          "owner_secondname": "Михайлов",
          "owner_patr": "Михайлович",
          "owner_phone": "+78888888888",
          "owner_drive_license": 	"888888"
        }
  */
  public function updateOwnerByID(Request $request, $ownerID, LibOwner $owner)
  {
    $owner_passport_ID = $request->request->get('owner_passport_ID', null);
    $owner_name = $request->request->get('owner_name', null);
    $owner_secondname = $request->request->get('owner_secondname', null);
    $owner_patr = $request->request->get('owner_patr', null);
    $owner_phone = $request->request->get('owner_phone', null);
    $owner_drive_license = $request->request->get('owner_drive_license', null);

    $owner->updateOwnerInfo($owner_passport_ID, $owner_name,
        $owner_secondname, $owner_patr,
        $owner_phone, $owner_drive_license, $ownerID);
    return $this->json(['status' => 'OK', 'message' => '', 'data' => []]);
  }

  /*
   * Получение информации о размере выплаты владельца по ownerID
   * Methods[GET]
   * */
  public function getPayoutAmountByOwnerID($ownerID, LibOwner $owner)
  {
    $info = $owner->getPayoutAmountByOwnerID($ownerID);

    return $this->json(['status' => 'OK', 'message' => '', 'data' => $info]);

  }
}