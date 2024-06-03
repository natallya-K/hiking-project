<?php
include 'includes/header.php';
use Controllers\AuthController as Auth;

// todo: add the login form here
list (
'isValidUser' => $isValidUser,
'isValidUserNotification' => $notification
) = Auth::loginUser();

?>

    <main class="w-screen px-10 flex-1 overflow-hidden flex flex-col justify-center  items-center">
        <?php if (!empty($notification)): ?>
            <aside class="notification">
                <p><?= $notification ?></p>
            </aside>
        <?php endif; ?>

        <section class="authForm">


            <form id="loginForm" action="" method="post" class="flex flex-col justify-center items-center text-xs">
                <div class="authFormSection">
                    <label for="UserName" class="authLabel">Login</label>
                    <input id="UserName" type="text" name="username" placeholder="Login" class="authFormField" required>
                    <input id="Password" type="password" name="password" placeholder="Password" class="authFormField" required>
                </div>
                <div class="authLinks">
                    <a href="/signin">Not registered yet ?</a>
                    <a href="/forgotPassword">Forgot password ?</a>
                </div>


                <input type="submit" value="Login" class="authButton">
            </form>
        </section>
    </main>

<?php
include 'includes/footer.php'
?>