<?php
include 'includes/header.php';
use Controllers\AuthController as Auth;

if (!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] === false) {
    header('Location: /login');
    exit();
}

if ($_POST) {
list (
        'isAllEdited' => $isAllEdited,
        'notification' => $notification
    ) = Auth::EditProfile();

}
?>

<!--Todo : mettre en page -->
<main class="flex-1 flex flex-col justify-center items-center">
    <?php if (isset($notification)): ?>
        <div class="$notification">
            <p><?= $notification ?></p>
        </div>
    <?php endif; ?>

    <section class="">
        <form action="" method="POST" class="authForm">
            <div class="authFormSection">
                <label for="username" class="authLabel">Username</label>
                <input type="text" name="username" id="username" value="<?= $_SESSION['username'] ?>" class="authFormField" required>
            </div>

            <div class="authFormSection">
                <label for="firstname" class="authLabel">First Name</label>
                <input type="text" name="firstname" id="firstname" value="<?= $_SESSION['firstname'] ?>" class="authFormField" required>
            </div>

            <div class="authFormSection">
                <label for="lastname" class="authLabel">Last Name</label>
                <input type="text" name="lastname" id="lastname" value="<?= $_SESSION['lastname'] ?>" class="authFormField" required>
            </div>

            <div class="authFormSection">
                <label for="email" class="authLabel">Email</label>
                <input type="email" name="email" id="email" value="<?= $_SESSION['email'] ?>" class="authFormField" required>
            </div>

            <button type="submit" class="authButton">Update</button>
        </form>
    </section>
</main>


<?php
include 'includes/footer.php'
?>

