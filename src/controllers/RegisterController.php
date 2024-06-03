<?php
declare(strict_types=1);
namespace Controllers;

class RegisterController
{
    private static function checkUsername(string $username): array
    {
        $minLength = 3;
        $isValidUsername = strlen($username) >= $minLength;
        $errorMessageUsername = "";

        if (!$isValidUsername) {
            $errorMessageUsername = "Username must be at least " . $minLength . " characters long. ";
        }

        return array('isValidUsername' => $isValidUsername, 'errorMessageUsername' => $errorMessageUsername);
    }

    protected static function checkPassword(string $password): array
    {
        $minLength = 6;
        $isValidPassword = false;
        $errorMessagePassword = "";

        if (strlen($password) >= $minLength) {
            // Vérifie si le mot de passe contient au moins une lettre majuscule
            if (preg_match('/[A-Z]/', $password)) {
                // Vérifie si le mot de passe contient au moins un caractère spécial
                if (preg_match('/[!@#$%^&*:()_+|\/?]/', $password)) {
                    $isValidPassword = true;
                } else {
                    $errorMessagePassword = "Password must contain at least one special character ( !@#$%^&*:()_+|/? ). ";
                }
            } else {
                $errorMessagePassword = "Password must contain at least one uppercase letter. ";
            }
        } else {
            $errorMessagePassword = "Password must be at least " . $minLength . " characters long.";
        }

        return array('isValidPassword' => $isValidPassword, 'errorMessagePassword' => $errorMessagePassword);
    }

    protected static function checkConfirmPassword(string $password, string $confirmPassword): array
    {
        $isValidConfirmPassword = $password == $confirmPassword;
        $errorMessageConfirmPassword = "";

        if (!$isValidConfirmPassword) {
            $errorMessageConfirmPassword = "Please be careful, confirm the same password as you entered. ";
        }

        return array('isValidConfirmPassword' => $isValidConfirmPassword, 'errorMessageConfirmPassword' => $errorMessageConfirmPassword);
    }

    private static function checkConfirmEmail(string $email, string $confirmEmail): array
    {
        $isValidConfirmEmail = $email == $confirmEmail;
        $errorMessageConfirmEmail = "";

        if (!$isValidConfirmEmail) {
            $errorMessageConfirmEmail = "Please be careful, confirm the same email as you entered. ";
        }

        return array('isValidConfirmEmail' => $isValidConfirmEmail, 'errorMessageConfirmEmail' => $errorMessageConfirmEmail);
    }

    protected function cleanData(array $array): array {
        $array = array_map('trim', $array);
        $array = array_map('stripslashes', $array);
        $array = array_map('strip_tags', $array);
        $array = array_map('htmlspecialchars', $array);
        return $array;
    }

    public static function userInfoCheck(): array
    {
        if (!empty($_POST)) {

            //Clean Data
            $cleaningData = new self;
            $cleanedData = $cleaningData-> cleanData($_POST);

            // Sanitize data
            $username = filter_var($cleanedData['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_var($cleanedData['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $confirm_password = filter_var($cleanedData['confirm_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($cleanedData['email'], FILTER_SANITIZE_EMAIL);
            $confirm_email = filter_var($cleanedData['confirm_email'], FILTER_SANITIZE_EMAIL);

            // Check data
            $usernameResult = self::checkUsername($username);
            $passwordResult = self::checkPassword($password);
            $confirmPasswordResult = self::checkConfirmPassword($password, $confirm_password);
            $confirmEmailResult = self::checkConfirmEmail($email, $confirm_email);

            $isValidUsername = $usernameResult['isValidUsername'];
            $errorMessageUsername = $usernameResult['errorMessageUsername'];

            $isValidPassword = $passwordResult['isValidPassword'];
            $errorMessagePassword = $passwordResult['errorMessagePassword'];

            $isValidConfirmPassword = $confirmPasswordResult['isValidConfirmPassword'];
            $errorMessageConfirmPassword = $confirmPasswordResult['errorMessageConfirmPassword'];

            $isValidConfirmEmail = $confirmEmailResult['isValidConfirmEmail'];
            $errorMessageConfirmEmail = $confirmEmailResult['errorMessageConfirmEmail'];

            // Return verification
            if (
                $isValidUsername &&
                $isValidPassword &&
                $isValidConfirmPassword &&
                $isValidConfirmEmail
            ) {
                $isValidForm = true;
                $errorMessage = "";
                return array('isValidForm' => $isValidForm, 'formVerificationError' => $errorMessage);

            } else {
                $isValidForm = false;
                $errorMessage = $errorMessageUsername . $errorMessagePassword . $errorMessageConfirmPassword . $errorMessageConfirmEmail;
                return array('isValidForm' => $isValidForm, 'formVerificationError' => $errorMessage);
            }
        } else {
            $isValidForm = false;
            $errorMessage = "";
            return array('isValidForm' => $isValidForm, 'formVerificationError' => $errorMessage);

        }
    }



}
?>