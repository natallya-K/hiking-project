<?php
declare(strict_types=1);

namespace Models;

use PDO;
use Models\Database;
use Controllers\MailController;

class Users extends Database
{
    public static function verifyUser(string $username, string $email): array
    {
        // Check if the user already exists in the database
        require_once "Database.php";
        $db = new Database();
        $sql = "SELECT COUNT(*) FROM Users WHERE username = :username OR email = :email";
        $param = (['username' => $username, 'email' => $email]);
        $stmt = $db->query($sql, $param);
        $isNewUser = (int) $stmt->fetchColumn();

        $isNewUser > 0 ? $VerifyUser = false : $VerifyUser = true;

        if ($VerifyUser) {
            $notification = '';
            return array('isNewUser' => true, 'isValidUserNotification' => $notification);
        } else {
            $notification = 'User already exists';
            return array('isNewUser' => false, 'isValidUserNotification' => $notification);
        }
    }

    public function addUser(array $data): void
    {
        // Data recovery
        list(
            $firstname,
            $lastName,
            $username,
            $email,
            $password
        ) = $data;

        // Hashing password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertion in database
        $sql = "INSERT INTO Users (username, firstname, lastname, password, email) VALUES (:username, :name, :lastname, :password, :email)";
        $param =  (['name' => $firstname, 'lastname' => $lastName, 'username' => $username, 'email' => $email, 'password' => $hashedPassword]);

        $this -> query($sql, $param);
        $recipientEmail = "cyril-f@hotmail.com";
        MailController::register($recipientEmail,$username);
    }

    public function loginUser(string $username, string $password): array
    {
        // Check if the user exists in the database
        $sql = "SELECT password FROM Users WHERE username = :username";
        $param = (['username' => $username]);
        $stmt = $this -> query($sql, $param);
        $isUser = $stmt -> fetch();

        // If user exists, check if the password is correct --- Else return an error message
        if ($isUser) {
            $isPasswordMatched = password_verify($password, $isUser['password']);

            //  If the password is correct, launch the session --- Else return an error message
            if ($isPasswordMatched) {
                $this->launchSession($username);

                header('Location: /home');
                exit();

            } else {
                $isValidUser = false;
                $isValidUserNotification = 'Invalid password';
                return array('isValidUser' => $isValidUser, 'isValidUserNotification' => $isValidUserNotification);

            }
        } else {
            $isValidUser = false;
            $isValidUserNotification = 'Invalid username';
            return array('isValidUser' => $isValidUser, 'isValidUserNotification' => $isValidUserNotification);
        }
    }

    public function launchSession($username)
    {
        //Todo aller chercher les données de l'utilisateur et les mettre dans la session
        $sql = "SELECT * FROM Users WHERE username = :username";
        $param = (['username' => $username]);
        $stmt = $this -> query($sql, $param);
        $user = $stmt -> fetch();

        $_SESSION['isConnected'] = true;
        $_SESSION['id'] = $user['ID'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['profilePicture'] = $user['profile_picture'];
    }

    // TODO : add a cookie to store the user's session

    public function logoutUser(): void
    {
        session_unset();
        session_destroy();
        header("Location: /home");
        exit;
    }

    public function editProfile(array $data, string $sessionUsername): array
    {
        $notification = '';

        // Data recovery
        list($username, $firstname, $lastName, $email) = $data;

        // Update firstname and lastname even if email or username exists
        $sql = "UPDATE Users SET firstname = :firstname, lastname = :lastname WHERE username = :sessionUsername";
        $params = ['firstname' => $firstname, 'lastname' => $lastName, 'sessionUsername' => $sessionUsername];
        $this->query($sql, $params);

        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastName;

        // Check if the email already exists in the database (excluding the current user's email)
        $sql = "SELECT COUNT(*) FROM Users WHERE email = :email AND username != :sessionUsername";
        $params = ['email' => $email, 'sessionUsername' => $sessionUsername];
        $stmt = $this->query($sql, $params);
        $emailExists = $stmt->fetchColumn() > 0;

        // Check if the username already exists in the database (excluding the current user's username)
        $sql = "SELECT COUNT(*) FROM Users WHERE username = :username AND username != :sessionUsername";
        $params = ['username' => $username, 'sessionUsername' => $sessionUsername];
        $stmt = $this->query($sql, $params);
        $usernameExists = $stmt->fetchColumn() > 0;

        $isAllEdited = true;

        if ($emailExists) {
            $isAllEdited = false;
            $notification .= 'Email already exists. ';
        } else {
            // Update email only if email does not exist
            $sql = "UPDATE Users SET email = :email WHERE username = :sessionUsername";
            $params = ['email' => $email, 'sessionUsername' => $sessionUsername];
            $this->query($sql, $params);
            $_SESSION['email'] = $email;
        }

        if ($usernameExists) {
            $isAllEdited = false;
            $notification .= 'Username already exists. ';
        } else {
            // Update username only if username does not exist
            $sql = "UPDATE Users SET username = :username WHERE username = :sessionUsername";
            $params = ['username' => $username, 'sessionUsername' => $sessionUsername];
            $this->query($sql, $params);
            $_SESSION['username'] = $username;
        }

        return ['isAllEdited' => $isAllEdited, 'notification' => $notification];
    }

    public function forgotPassword($email): void
    {
        // Todo : send an email to the user with a link to reset the password
//        echo 'forgot password </br>';
//        echo $email;
        $sql = "SELECT username FROM Users WHERE email = :email";
        $param = (['email' => $email]);
        $stmt = $this -> query($sql, $param);
        $user = $stmt -> fetch();
//        echo $user['username'];

        $recipientEmail = "cyril-f@hotmail.com";
        MailController::forgotPassword($recipientEmail, $user['username']);

    }

    public  static function comparePasswordToDB(string $username, string $password): array
    {
        // Get user data in the database
        $db = new Database();
        $sql = "SELECT password FROM Users WHERE username = :username";
        $param = (['username' => $username]);
        $stmt = $db -> query($sql, $param);
        $isUser = $stmt -> fetch();

        $isPasswordMatched = password_verify($password, $isUser['password']);

        //  If the password is correct, launch the session --- Else return an error message
        if ($isPasswordMatched) {
            $isValidUser = true;
            $isValidUserNotification = 'Valid password';
            return array('isValidUser' => $isValidUser, 'isValidUserNotification' => $isValidUserNotification);

        } else {
            $isValidUser = false;
            $isValidUserNotification = 'Invalid password';
            return array('isValidUser' => $isValidUser, 'isValidUserNotification' => $isValidUserNotification);

        }

    }

    public static function editPassword(string $user, string $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $db = new Database();
        $sql = "UPDATE Users SET password = :password WHERE username = :username";
        $param = (['password' => $hashedPassword, 'username' => $user]);
        $db -> query($sql, $param);
    }

    public function getUserDetails($userId) {
        $query = "SELECT * FROM Users WHERE id = :userId";
        $params = [':userId' => $userId];
        $result = $this->query($query, $params);
        return $result->fetch();
    }
}
