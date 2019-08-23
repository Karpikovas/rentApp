<?php


namespace App\Lib;


class LibOwner
{
  private $Db;

  public function __construct(LibDB $Db)
  {
    $this->Db = $Db;
  }

  public function addNewOwner(string $owner_passport_ID, string $owner_name,
                              string $owner_secondname, string $owner_patr,
                              string $owner_phone, string $owner_drive_license): bool
  {
    $params = [
        $owner_passport_ID,
        $owner_name,
        $owner_secondname,
        $owner_patr,
        $owner_phone,
        $owner_drive_license
    ];
    return $this->Db->exec('
        INSERT INTO Owner(
            owner_passport_ID, 
            owner_name, 
            owner_secondname, 
            owner_patr, 
            owner_phone, 
            owner_drive_license
          )
         VALUES(?, ?, ?, ?, ?, ?);',
        $params
    );
  }

  public function deleteOwnerByID(string $ownerID): bool
  {
    return $this->Db->exec('DELETE FROM Owner WHERE owner_passport_ID = ?;', [$ownerID]);
  }

  public function updateOwnerInfo(string $owner_passport_ID, string $owner_name,
                                  string $owner_secondname, string $owner_patr,
                                  string $owner_phone, string $owner_drive_license,
                                  string $ownerID): bool
  {

    $params = [
        $owner_passport_ID,
        $owner_name,
        $owner_secondname,
        $owner_patr,
        $owner_phone,
        $owner_drive_license,
        $ownerID
    ];

    return $this->Db->exec('
        UPDATE Owner SET 
            owner_passport_ID=?, 
            owner_name=?, 
            owner_secondname=?, 
            owner_patr=?, 
            owner_phone=?, 
            owner_drive_license=?
         WHERE owner_passport_ID=?;',
        $params
    );
  }

  public function getPayoutAmountByOwnerID(string $ownerID): array
  {
    return $this->Db->select('
        select 
            sum(cost) as payout_amount 
        from Rent  
        where car_ID in (
            select 
                car_ID 
            from Car 
            where owner_ID=?
        ) 
        and end_date <= now();',
        [$ownerID]
    );
  }
}