<?php


namespace App\Lib;


class LibRent
{
  private $Db;

  public function __construct(LibDB $Db)
  {
    $this->Db = $Db;
  }

  public function addNewRent(string $client_ID, string $car_ID, string $start_date,
                             string $end_date, string $comment): bool
  {
    $params = [
        $client_ID,
        $car_ID,
        $start_date,
        $end_date,
        $comment
    ];

    return $this->Db->exec('
        INSERT INTO agency.Rent(
            client_ID, 
            car_ID, 
            start_date, 
            end_date, 
            cost, 
            comment)  
        VALUES (?, ?, ?, ?,     
        (     
          if(TIMESTAMPDIFF(HOUR,start_date, end_date) > 24,   
              (mod(TIMESTAMPDIFF(HOUR,  start_date, end_date), 24) * 100 + TIMESTAMPDIFF(DAY,start_date, end_date) * 2000) * 0.75,   
              TIMESTAMPDIFF(HOUR,start_date, end_date) * 200 * 0.75)  
        ), 
        ?)',
        $params
    );
  }

  public function getRentDate(string $contractID)
  {
    return $this->Db->select('
        select 
            start_date 
          from Rent  
        where contract_id=?;',
        [$contractID]
    );
  }

  public function updateRent(string $client_ID, string $car_ID, string $start_date,
                             string $end_date, string $comment, string $contractID): bool
  {
    $params = [
        $client_ID,
        $car_ID,
        $start_date,
        $end_date,
        $comment,
        $contractID
    ];

    return $this->Db->exec('
        UPDATE Rent SET 
            client_ID=?, 
            car_ID=?, 
            start_date=?, 
            end_date=?, 
            cost=if(TIMESTAMPDIFF(HOUR,start_date, end_date) > 24,   
                (mod(TIMESTAMPDIFF(HOUR,  start_date, end_date), 24) * 100 + TIMESTAMPDIFF(DAY,start_date, end_date) * 2000) * 0.75,   
                TIMESTAMPDIFF(HOUR,start_date, end_date) * 200 * 0.75), comment=?
         WHERE contract_ID=?;',
        $params
    );
  }

  public function showComingRentList(): array
  {
    return $this->Db->select('
        SELECT 
            Rent.contract_ID, 
            Owner.owner_secondname, 
            Client.client_secondname, 
            Car.name,
            Rent.cost 
        FROM Rent 
        INNER JOIN Car ON Rent.car_ID=Car.car_ID 
        INNER JOIN Client on Rent.client_ID=Client.client_passport_ID 
        INNER JOIN Owner on Car.owner_ID=Owner.owner_passport_ID 
        where start_date > now()');
  }
  public function getProfitInfo(string $start_date, string $end_date):array
  {
    $params = [
        $start_date,
        $end_date
    ];
    return $this->Db->select('
        select 
          cast(end_date as date) as date,
            sum(cost / 3) as profit
        from Rent
        where end_date between ? and ?
        group by date
        order by date;
        ',
        $params
    );
  }
}