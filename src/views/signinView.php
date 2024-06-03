<?php
include 'includes/header.php';
use Controllers\AuthController as Auth;

list(
    'isValidForm' => $isValidForm,
    'formVerificationError' => $notification
) = Auth::userInfoCheck();

if ($isValidForm) {
    list(
        'isNewUser' => $isNewUser,
        'isValidUserNotification' => $notification
    ) = Auth::registerUser();

    if ($isNewUser) {
        header("Location: /home");
        exit();
    }
}

?>
    <main class="w-screen px-10 flex-1 overflow-hidden flex flex-col justify-center  items-center">
         <?php if (!empty($notification)): ?>
             <div class="notification">
                 <p><?= $notification ?></p>
             </div>
         <?php endif; ?>

         <section class="">

            <form id="signInForm" action="" method="post" class="authForm">
                <div class="authFormSection">
                    <label for="UserName" class="authLabel">Username</label>
                    <input id="UserName" type="text" name="username" placeholder="Username" class="authFormField" required>
                </div>

                <div class="authFormSection">
                    <label for="Name" class="authLabel">Name</label>
                    <input  id="Name" type="text" name="name" placeholder="First name" class="authFormField" required>
                    <input  id="LastName" type="text" name="lastname" placeholder="Last name"  class="authFormField" required>
                </div>

                <div class="authFormSection">
                    <label for="Password" class="authLabel">Password</label>
                    <input id="Password" type="password" name="password" placeholder="Password" class="authFormField" required>
                    <input id="ConfirmPassword" type="password" name="confirm_password" placeholder="Confirm password" class="authFormField" required>
                </div>

                <div class="authFormSection">
                    <label for="Email" class="authLabel">Email</label>
                    <input id="Email" type="email" name="email" placeholder="email" class="authFormField" required>
                    <input id="ConfirmEmail" type="email" name="confirm_email" placeholder="Confirm email" class="authFormField" required>
                </div>

                <input type="submit" value="sign in" class="authButton">
            </form>

        </section>
    </main>
<?php
include 'includes/footer.php'
?>