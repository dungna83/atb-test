<?php

namespace Api\Controller;

use Api\Core\Response;
use Api\Model\UserModel;
use Api\Core\CommonFunction as Common;
use Api\Controller\AuthController;

class UserController extends BaseController
{
    const PASSWORD_LENGTH = 6;
    private $auth;

    public function __construct()
    {
        $this->auth = new AuthController();
    }

    public function post()
    {
        $params = $this->getStreamData();
        Common::validateEmail($params);
        $email = filter_var($params['email'], FILTER_SANITIZE_EMAIL);
        Common::checkEmailExists($email);
        Common::validatePassword($params);

        $full_name = empty($params['full_name']) ? '' : filter_var($params['full_name'], FILTER_SANITIZE_STRING);
        $tel = empty($params['tel']) ? '' : filter_var($params['tel'],FILTER_SANITIZE_STRING);
        $address = empty($params['address']) ? '' : filter_var($params['address'], FILTER_SANITIZE_STRING);

        $userData = array(
            'email' => $email,
            'password' => password_hash($params['password'], PASSWORD_BCRYPT),
            'full_name' => $full_name,
            'tel' => $tel,
            'address' => $address
        );

        $insertResult = UserModel::insert($userData);

        if ($insertResult == false) {
            Response::sent(400, ['error_message' => 'Register failed!']);
        }

        unset($userData['password']);
        Response::sent(200, ['user' => $userData]);
    }


    public function get()
    {
        $this->auth->validateToken();

        $email = $this->uriSegment(1);
        if ($email == false) {
            $this->getAll();

        } else {
            $this->getOne($email);
        }
    }

    public function put()
    {
        $sessionInfo = $this->auth->validateToken();
        $params = $this->getStreamData();

        $user = UserModel::findByEmail($sessionInfo['email']);
        if ($user == false) {
            Response::sent(400, ["error_message" => "User not found"]);
        }

        $full_name = empty($params['full_name']) ? '' : filter_var($params['full_name'], FILTER_SANITIZE_STRING);
        $tel = empty($params['tel']) ? '' : filter_var($params['tel'],FILTER_SANITIZE_STRING);
        $address = empty($params['address']) ? '' : filter_var($params['address'], FILTER_SANITIZE_STRING);

        $data = array(
            'full_name' => $full_name,
            'tel' => $tel,
            'address' => $address,
            'email' => $sessionInfo['email']
        );

        $updateResult = UserModel::update($data);
        if ($updateResult == false) {
            Response::sent(400);
        }

        $new_token = $this->auth->updateToken($sessionInfo['email']);
        Response::sent(200, ['token' => $new_token]);
    }

    // Change own user's password
    public function patch()
    {
        $sessionInfo = $this->auth->validateToken();
        $params = $this->getStreamData();
        Common::validatePassword($params);
        $password = $params['password'];
        Common::validateNewPassword($params);
        $new_password = $params['new_password'];

        $currentUser = UserModel::findByEmail($sessionInfo['email']);

        if (!password_verify($password, $currentUser['password'])) {
            Response::sent(400, ['error_message' => 'Wrong current password']);
        }
        $userData = array(
            'email' => $currentUser['email'],
            'password' => password_hash($new_password, PASSWORD_BCRYPT)
        );

        $updateResult = UserModel::updatePassword($userData);
        if ($updateResult == false) {
            Response::sent(400);
        }

        Response::sent(200, ["info" => "Change password success!"]);
    }

    private function getAll()
    {
        $userData = UserModel::all();

        if ($userData == false) {
            Response::sent(400);
        }
        $userList = array();
        $index = 0;
        foreach ($userData as $user) {
            $userList[$index]['email'] = $user['email'];
            $userList[$index]['full_name'] = $user['full_name'];
            $userList[$index]['tel'] = $user['tel'];
            $userList[$index]['address'] = $user['address'];
            $index++;
        }

        Response::sent(200, ['users' => $userList]);
    }

    private function getOne($email)
    {
        Common::validateEmail(['email' => $email]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $row = UserModel::findByEmail($email);
        if ($row == false) {
            Response::sent(400);
        }
        $userData = array(
            'email' => $row['email'],
            'full_name' => $row['full_name'],
            'tel' => $row['tel'],
            'address' => $row['address'],
        );

        Response::sent(200, ['user' => $userData]);
    }

}