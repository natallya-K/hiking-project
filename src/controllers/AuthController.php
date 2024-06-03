<?php
declare(strict_types=1);
namespace Controllers;

use Models\Users;

class AuthController extends RegisterController
{

    public static function registerUser(): array
    {

        // Data cleaning
        $cleaningData = new self;
        $cleanedData = $cleaningData-> cleanData($_POST);

        // Sanitize data
        $cleanedFirstName = filter_var($cleanedData['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cleanedLastName = filter_var($cleanedData['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cleanedUsername = filter_var($cleanedData['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cleanedEmail = filter_var($cleanedData['email'], FILTER_SANITIZE_EMAIL);
        $cleanedPassword = filter_var($cleanedData['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $cleanedData = array($cleanedFirstName, $cleanedLastName, $cleanedUsername, $cleanedEmail, $cleanedPassword);

        // Is the user already registered?
        $verified = Users::verifyUser($cleanedUsername, $cleanedEmail);

        // If the user is not already registered, add the user else return the notification
        if ($verified['isNewUser']) {
            $user = new Users();
            $user->addUser($cleanedData);
            $notification = 'User successfully added';

            // Todo : lancé un launch Session
            $user = new Users();
            $user->launchSession($cleanedUsername);

            return array('isNewUser' => true, 'isValidUserNotification' => $notification);
        }  else {
            return $verified;
        }
    }

    public static function loginUser(): array
    {
        if (!empty($_POST)) {
            //Clean Data
            $cleaningData = new self;
            $cleanedData = $cleaningData->cleanData($_POST);

            // Sanitize data
            $cleanedUsername = filter_var($cleanedData['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $cleanedPassword = filter_var($cleanedData['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Login user
            $user = new Users();

            return $user->loginUser($cleanedUsername, $cleanedPassword);
        }   else {
            return array('isValidUser' => false, 'isValidUserNotification' => '');
        }
    }

    public static function logoutUser(): void
    {
        $user = new Users();
        $user->logoutUser();
    }

    public static function editProfile(): array
    {
        $cleaningData = new self;
        $cleanedData = $cleaningData->cleanData($_POST);

        $cleanedUsername = filter_var($cleanedData['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cleanedFirstName = filter_var($cleanedData['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cleanedLastName = filter_var($cleanedData['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $cleanedEmail = filter_var($cleanedData['email'], FILTER_SANITIZE_EMAIL);

        $cleanedData = array($cleanedUsername, $cleanedFirstName, $cleanedLastName, $cleanedEmail);

        $user = new Users();
        list (
            'isAllEdited' => $isAllEdited,
            'notification' => $notification
        ) = $user->editProfile($cleanedData,  $_SESSION['username']);

            var_dump($user->editProfile($cleanedData, $_SESSION['username']));
           if ($isAllEdited) {
               header('Location: /profile');

               return array('isAllEdited' => $isAllEdited, 'notification' => $notification);
            } else {
               return array('isAllEdited' => $isAllEdited, 'notification' => $notification);
            }
    }

    public static function forgotPassword($email): void
    {
        $cleaningData = new self;
        $cleanedData = $cleaningData->cleanData($_POST);
        $email = $cleanedData['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
//        echo $email;

        $user = new Users();
        $user->forgotPassword($email);

        header('Location: /login');
    }

    public static function editPassword()
    {
        // Si $_POST get data
        if (!empty($_POST)){
            // Data cleaning
            $cleaningData = new self;
            $cleanedData = $cleaningData->cleanData($_POST);

            $oldPassword = filter_var($cleanedData['oldPassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $newPassword = filter_var($cleanedData['newPassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirmPassword = filter_var($cleanedData['confirmPassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $currentUser = $_SESSION['username'];

            list(
                'isValidUser' => $isValidUser,
                'isValidUserNotification' => $notification
                ) = Users::comparePasswordToDB($currentUser, $oldPassword);

            if ($isValidUser) {
                $checkPassword = self::checkPassword($newPassword);
                $checkConfirmPassword = self::checkConfirmPassword($newPassword, $confirmPassword);


                $isValidPassword = $checkPassword['isValidPassword'];
                $errorMessagePassword = $checkPassword['errorMessagePassword'];

                $isValidConfirmPassword = $checkConfirmPassword['isValidConfirmPassword'];
                $errorMessageConfirmPassword = $checkConfirmPassword['errorMessageConfirmPassword'];

                if ($isValidPassword && $isValidConfirmPassword) {

                    Users::editPassword($currentUser, $newPassword);
                    $notification = 'Password successfully changed';
                    header('Location: /profile');
                    return array('isEditPassword' => true, 'isEditPasswordNotification' => $notification);                    exit();
                    exit();

                } else {
                    $notification = $errorMessagePassword . $errorMessageConfirmPassword;
                    return array('isEditPassword' => false, 'isEditPasswordNotification' => $notification);
                }
            } else {
                return array('isEditPassword' => false, 'isEditPasswordNotification' => $notification);
            }
        }
    }

}

