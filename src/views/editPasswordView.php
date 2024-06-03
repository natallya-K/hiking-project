<?php
include 'includes/header.php';
use Controllers\AuthController as Auth;

if (!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] === false) {
    header('Location: /login');
    exit();
}

list (
    'isEditPassword' => $isEditPassword,
    'isEditPasswordNotification' => $notification
    ) = Auth::EditPassword();
?>

<!--Todo : mettre en page -->


<main class="flex-1 flex flex-col justify-center items-center">

    <?php if (isset($notification)): ?>
        <div class="$notification">
            <p><?= $notification ?></p>
        </div>
    <?php endif; ?>

    <div class="change-password-container">
        <form id="changePasswordForm" action="" method="post" class="authForm">
            <div class="authFormSection">

                <label for="OldPassword" class="authLabel">Change Password</label>
                <input id="OldPassword" type="password" name="oldPassword" placeholder="Old Password" class="authFormField" required>
                <input id="NewPassword" type="password" name="newPassword" placeholder="New Password" class="authFormField" required>
                <input id="ConfirmPassword" type="password" name="confirmPassword" placeholder="Confirm Password" class="authFormField" required>
            </div>
            <input type="submit" value="Change" class="authButton">
        </form>
    </div>
</main>

<?php
include 'includes/footer.php';
?>

