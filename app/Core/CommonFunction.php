<?php

namespace Api\Core;

use Api\Core\Response;
use Api\Model\UserModel;
use Api\Controller\UserController;

class CommonFunction
{

    public static function validateEmail($data)
    {
        if (empty($data['email'])) {
            Response::sent(400, ['error_message' => 'empty email']);
        } elseif (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false) {
            Response::sent(400, ['error_message' => 'invalid email']);
        }

    }

    public static function validatePassword($data)
    {
        if (empty($data['password'])) {
            Response::sent(400, ['error_message' => 'empty password']);
        } elseif (strlen($data['password']) < PASSWORD_LENGTH) {
            Response::sent(400, ['error_message' => 'password must > 6 characters']);
        }
    }
    public static function validateNewPassword($data)
    {
        if (empty($data['new_password'])) {
            Response::sent(400, ['error_message' => 'empty new password']);
        } elseif (strlen($data['new_password']) < PASSWORD_LENGTH) {
            Response::sent(400, ['error_message' => 'new password must > 6 characters']);
        }
    }

    public static function checkEmailExists($email)
    {
        $user = UserModel::findByEmail($email);
        if ($user !== false) {
            Response::sent(400, ['error_message' => 'exists email']);
        }
    }
}