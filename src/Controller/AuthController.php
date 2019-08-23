<?php


namespace App\Controller;


use App\Lib\LibUser;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class AuthController extends AbstractController
{
  /*
   * Авторизация
   * Methods[POST]
   * Пример body:
   *    {
          "username": "root",
          "password": "root"
        }
  */

  public function login(Request $request, LibUser $User)
  {

    $username = $request->request->get('username', null);
    $password = $request->request->get('password', null);
    $errorMessage = "";
    $data = "";
    $status = "OK";

    $user = $User->checkUsernameExists($username);
    if ($user) {
      if ($User->checkPassword($user, $password)) {
        $bytes = random_bytes(25);
        $key = bin2hex($bytes);
        $data = ['key' => $key];
        $User->setAuth($key, $user['id']);

      } else {
        $status = 'error';
        $errorMessage = 'Wrong password!';
      }
    } else {
      $status = 'error';
      $errorMessage = 'User does not exist!';
    }

    return $this->json(['status' => $status, 'message' => $errorMessage, 'data' => $data]);
  }
}