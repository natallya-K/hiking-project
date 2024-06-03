<?php
include 'includes/header.php';

use Controllers\AuthController;

if (isset($_POST['email'])) {
    AuthController::forgotPassword($_POST['email']);
}
?>


    <main class="w-screen px-10 flex-1 overflow-hidden flex flex-col justify-center  items-center">
        <section class="">

            <form id="forgotPasswordForm" action="" method="post" class="authForm">
                <div class="authFormSection">
                    <label for="Email" class="authLabel">Forgot Password</label>
                    <input id="Email" type="email" name="email" placeholder="Email" class="authFormField" required>
                </div>

                <input type="submit" value="Send" class="authButton">
            </form>
        </section>
    </main>


<?php
include 'includes/footer.php'
?>
