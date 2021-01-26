<?php

class User
{
    function register($name, $email, $password)
    {
        $db = DB::getDbConnection();
        $data = array($name, $email, $password);
        $result = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");

        return $result->execute($data);
    }

    function checkName($name)
    {
        $name = urldecode(htmlspecialchars(trim($name)));
        if (strlen($name) >= 5) {
            return true;
        }
        return false;
    }

    function checkEmail($email)
    {
        $email = urldecode(htmlspecialchars(trim($email)));
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    function checkPassword($password)
    {
        $password = urldecode(htmlspecialchars(trim($password)));
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    function checkEmailExists($email)
    {
        $db = DB::getDbConnection();

        $result = $db->prepare("SELECT * FROM users WHERE email=:email");
        $result->bindParam(":email", $email);
        $result->execute();

        if ($result->fetch()) {
            return true;
        }
        return false;
    }

    function checkUserData($email, $password)
    {
        $db = DB::getDbConnection();

        $result = $db->prepare("SELECT * FROM users WHERE email=:email AND password=:password");
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch(PDO::FETCH_OBJ);
        if ($user) {
            return $user;
        }
        return false;
    }

    function auth($userId, $userName, $userEmail)
    {
        $_SESSION['userId'] = $userId;
        $_SESSION['userName'] = $userName;
        $_SESSION['userEmail'] = $userEmail;
    }

    function getUserById($id)
    {
        $db = DB::getDbConnection();

        $result = $db->prepare("SELECT * FROM users WHERE id=:id");
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch(PDO::FETCH_OBJ);
    }
}
