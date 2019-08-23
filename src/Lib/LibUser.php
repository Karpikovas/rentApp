<?php


namespace App\Lib;


class LibUser
{
  private $Db;
  public function __construct(LibDB $Db)
  {
    $this->Db = $Db;
  }
  public function checkPassword($user, $password)
  {
    $hash = $user['password'];
    if (password_verify($password, $hash)) {
      return true;
    }
    return false;
  }
  public function logout($key)
  {
    $params = [
        $key
    ];
    $this->Db->exec('DELETE from sessions WHERE `key` = ?', $params);
  }
  public function checkAuth($key): int // userId
  {
    if ($key) {
      $params = [
          $key
      ];
      $key = $this->Db->select('SELECT * from sessions WHERE `key` = ?; and exp_date > now()', $params);
      if ($key) {
        $key = array_shift($key);
        return $key['user_id'];
      }
      $this->Db->exec('DELETE from sessions WHERE `key` = ?', $params);
    }
    return false;
  }
  public function setAuth($key, $user_id)
  {
    $exp_date = date("Y-m-d H:i:s", strtotime("+1 hours"));
    $params = [
        $key,
        $exp_date,
        $user_id
    ];
    $this->Db->exec('INSERT INTO sessions VALUES (?, ?, ?);', $params);
  }
  public function checkUsernameExists($username)
  {
    $params = [
        $username
    ];
    $user = $this->Db->select('SELECT * FROM User WHERE username = ?;', $params);
    if ($user) {
      return array_shift($user);
    }
    return false;
  }
}