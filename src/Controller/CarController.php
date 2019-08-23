<?php


namespace App\Controller;


use App\Lib\LibCar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CarController extends AbstractController implements TokenAuthenticatedController
{
  /*
   * Посмотреть список доступных автомобилей в определенный период (start_date - end_date)
   * Methods[GET]
   * Пример запроса:
   *    http://site/cars?start_date={string Г-м-д ч:м:с} 13:00:00&end_date={string Г-м-д ч:м:с}
   *    http://site/cars?start_date=2019-09-12 13:00:00&end_date=2019-09-12 15:00:00*/

  public function showCarsList(Request $request, LibCar $car)
  {
    $start_date = $request->query->get('start_date');
    $end_date = $request->query->get('end_date');

    $cars = $car->getCarsList($start_date, $end_date);

    return $this->json(['status' => "OK", 'message' => "", 'data' => ['cars' => $cars]]);
  }

  /*
   * Добавление новой машины
   * Methods[POST]
   * Пример body:
   *    {
          "type": "Легковая",
          "name": "Nissan Micra",
          "fuel_type": "АИ-95",
          "carrying": null,
          "seats_count": "5",
          "comment": null,
          "owner_ID": "5413288368"
        }
  */
  public function addNewCar(Request $request, LibCar $car)
  {
    $type = $request->request->get('type', null);
    $name = $request->request->get('name', null);
    $fuel_type = $request->request->get('fuel_type', null);
    $carrying = $request->request->get('carrying', null);
    $seats_count = $request->request->get('seats_count', null);
    $comment = $request->request->get('comment', null);
    $owner_ID = $request->request->get('owner_ID', null);

    $car->addNewCar($type, $name, $fuel_type, $carrying, $seats_count, $comment, $owner_ID);

    return $this->json(['status' => 'OK', 'message' => '', 'data' => []]);
  }
  /*
   * Удаление машины по индентификатору carID
   * Methods[POST]
   * */
  public function deleteCarByID($carID, LibCar $car)
  {
    $car->deleteCarByID($carID);

    return $this->json(['status' => 'OK', 'message' => '', 'data' => []]);
  }
  /*
   * Обновление информации о машине
   * Methods[POST]
   * Пример body:
   *    {
          "type": "Легковая",
          "name": "Nissan Micra",
          "fuel_type": "АИ-95",
          "carrying": null,
          "seats_count": "5",
          "comment": null,
          "owner_ID": "5413288368"
        }
  */
  public function updateCarByID(Request $request, $carID, LibCar $car)
  {
    $type = $request->request->get('type', null);
    $name = $request->request->get('name', null);
    $fuel_type = $request->request->get('fuel_type', null);
    $carrying = $request->request->get('carrying', null);
    $seats_count = $request->request->get('seats_count', null);
    $comment = $request->request->get('comment', null);
    $owner_ID = $request->request->get('owner_ID', null);

    $car->updateCarInfo($type, $name, $fuel_type, $carrying, $seats_count, $comment, $owner_ID, $carID);
    return $this->json(['status' => 'OK', 'message' => '', 'data' => []]);
  }

  public function getMostUsedCars(Request $request, LibCar $car)
  {
    $cars = $car->getMostUsedCars();
    return $this->json(['status' => "OK", 'message' => "", 'data' => ['cars' => $cars]]);
  }


}