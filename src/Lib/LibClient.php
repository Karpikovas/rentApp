<?php


namespace App\Lib;


class LibClient
{
  private $Db;

  public function __construct(LibDB $Db)
  {
    $this->Db = $Db;
  }

  public function addNewClient(string $client_passport_ID, string $client_name,
                              string $client_secondname, string $client_patr,
                              string $client_phone, string $client_drive_license): bool
  {
    $params = [
        $client_passport_ID,
        $client_name,
        $client_secondname,
        $client_patr,
        $client_phone,
        $client_drive_license
    ];
    return $this->Db->exec('
        INSERT INTO Client(
            client_passport_ID, 
            client_name, 
            client_secondname, 
            client_patr, 
            client_phone, 
            client_drive_license
          )
         VALUES(?, ?, ?, ?, ?, ?);',
        $params
    );
  }
}