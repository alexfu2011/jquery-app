<?php

class UserController
{

    function index_action($id)
    {
        header('Content-Type: application/json');
        $user = User::getUserById($id);
        echo json_encode(array('data' => $user));
    }

    function register_action()
    {
        if (isset($_POST['name'])) {
            header('Content-Type: application/json');
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!User::checkName($name)) {
                $error = 'WRONG_NAME';
            } else if (!User::checkEmail($email)) {
                $error = 'WRONG_EMAIL';
            } else if (!User::checkPassword($password)) {
                $error = 'WRONG_PASSWORD';
            } else if (User::checkEmailExists($email)) {
                $error = 'USER_NOT_EXISTS';
            } else {
                $result = User::register($name, $email, $password);
                echo json_encode(array('success' => 'success'));
                return;
            }
            echo json_encode(array('error' => $error));
        }
    }

    function login_action()
    {
        if (isset($_POST['email'])) {
            header('Content-Type: application/json');
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!User::checkEmail($email)) {
                $error = 'WRONG_EMAIL';
            } else if (!User::checkPassword($password)) {
                $error = 'WRONG_PASSWORD';
            } else {
                $user = User::checkUserData($email, $password);

                if ($user->id == false) {
                    $error = 'USER_NOT_EXISTS';
                    echo json_encode(array('error' => $error));
                } else {
                    User::auth($user->id, $user->name, $user->email);
                    $data = array();
                    $data['api_token'] = uniqid();
                    $data['id'] = $user->id;
                    $data['name'] = $user->name;
                    $data['email'] = $user->email;
                    echo json_encode(array('data' => $data));
                }
                return;
            }
            echo json_encode(array('error' => $error));
        }
    }

    public function logout_action()
    {
        header('Content-Type: application/json');
        unset($_SESSION['userId']);
        unset($_SESSION['userName']);
        echo json_encode(array('success' => 'success'));
    }
}
