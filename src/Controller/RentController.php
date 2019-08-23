<?php


namespace App\Controller;


use App\Lib\LibRent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class RentController extends AbstractController implements TokenAuthenticatedController
{
  /*
   * Добавление нового клиента
   * Methods[POST]
   * Пример body:
   *    {
          "client_ID": "5413288366",
          "car_ID": "Михаил",
          "start_date": "Михайлов",
          "end_date": "Михайлович",
          "comment": "+78888888888"
        }
  */
  public function addNewRent(Request $request, LibRent $rent)
  {
    $client_ID = $request->request->get('client_ID', null);
    $car_ID = $request->request->get('car_ID', null);
    $start_date = $request->request->get('start_date', null);
    $end_date = $request->request->get('end_date', null);
    $comment = $request->request->get('comment', null);

    $rent->addNewRent($client_ID, $car_ID, $start_date, $end_date, $comment);

    return $this->json(['status' => 'OK', 'message' => '', 'data' => []]);
  }

  public function editRentByID(Request $request, $contractID, LibRent $rent)
  {
    $rent_date = $rent->getRentDate($contractID);
    $rent_date = strtotime(array_shift($rent_date)["start_date"]);


    $current_date = date(time());

    if ($rent_date < $current_date)
    {
      return $this->json(['status' => 'error', 'message' => "Can't edit completed rents", 'data' => []]);
    }

    $client_ID = $request->request->get('client_ID', null);
    $car_ID = $request->request->get('car_ID', null);
    $start_date = $request->request->get('start_date', null);
    $end_date = $request->request->get('end_date', null);
    $comment = $request->request->get('comment', null);

    $rent->updateRent($client_ID, $car_ID, $start_date, $end_date, $comment, $contractID);

    return $this->json(['status' => 'OK', 'message' => '', 'data' => []]);
  }

  public function showComingRentList(LibRent $rent)
  {
    $rents = $rent->showComingRentList();
    return $this->json(['status' => 'OK', 'message' => '', 'data' => ['coming_rents' => $rents]]);
  }

  public function getProfitInfo(Request $request, LibRent $rent)
  {
    $start_date = $request->query->get('start_date');
    $end_date = $request->query->get('end_date');

    $profit = $rent->getProfitInfo($start_date, $end_date);

    return $this->json(['status' => "OK", 'message' => "", 'data' => ['profit' => $profit]]);
  }

}