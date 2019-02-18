<?php

namespace Api\Controller;

use Firebase\JWT\JWT;
use Api\Model\UserModel;
use Api\Model\SessionModel;
use Api\Core\CommonFunction as Common;
use Api\Core\Response;


class AuthController extends BaseController
{
    //Login
    public function post()
    {
        Common::validateEmail($_POST);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        Common::validatePassword($_POST);

        $user = UserModel::findByEmail($email);
        if ($user == false) {
            Response::sent(401);
        }

        if (password_verify($_POST['password'], $user['password'])) {
            $token = $this->createOrUpdateToken($user['email']);
            Response::sent(200, ["token" => $token]);
        } else {
            Response::sent(401);
        }
    }

    //Logout
    public function get()
    {
        $sessionInfo = $this->validateToken();

        $result = SessionModel::delete($sessionInfo['email']);
        if ($result == false) {
            Response::sent(400, ["error_message" => "Logout failed"]);
        } else {
            Response::sent(200, ["info" => "Logout success!"]);
        }
    }

    private function createOrUpdateToken($email)
    {
        $sessionInfo = SessionModel::getToken($email);
        if ($sessionInfo == false) {
            $token = $this->createToken($email);
        } else {
            $token = $this->updateToken($email);
        }

        return $token;
    }

    public function createToken($email)
    {
        $tokenData = $this->createTokenData($email);

        try {
            SessionModel::insert($tokenData);
        } catch (\Exception $e) {
            Response::sent(401, ["message" => "Login failed", "error_message" => $e->getMessage()]);
        }

        return $tokenData['token'];
    }

    public function updateToken($email)
    {
        $tokenData = $this->createTokenData($email);

        try {
            SessionModel::update($tokenData);
        } catch (\Exception $e) {
            Response::sent(401, ["message" => "Login failed", "error_message" => $e->getMessage()]);
        }

        return $tokenData['token'];
    }

    public function validateToken()
    {
        $token = $this->getBearerToken();
        if (!$token) {
            Response::sent(401, ["message" => "Access denied.", "error_message" => "Require authorization token"]);
        }

        $token = filter_var($token, FILTER_SANITIZE_STRING);
        $sessionInfo = SessionModel::findSession($token);
        if ($sessionInfo == false) {
            Response::sent(401, ["error_message" => "Invalid token"]);
        }

        if ($sessionInfo['expire'] < time()) {
            Response::sent(401, ["error_message" => "Expired token"]);
        }

        return $sessionInfo;
    }


    private function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));

            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }

        return $headers;
    }

    private function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }

        return false;
    }

    private function createTokenData($email)
    {
        $expire = time() + EXPIRE_TIME;
        $token = hash("sha256", $email . $expire . API_KEY, false);

        $tokenData = [
            "email" => $email,
            "token" => $token,
            "expire" => $expire
        ];

        return $tokenData;
    }
}