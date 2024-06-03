<?php
include 'includes/header.php';
use Controllers\HikesController as HikeController;

// Ensure the user is authenticated
if (!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] === false) {
    header('Location: /login');
    exit();
}

// Handle form submission
if ($_POST) {
    try {
        HikeController::addHike($_POST);
        $notification = "Hike added successfully.";
    } catch (Exception $e) {
        $notification = "Error: " . $e->getMessage();
    }
}
?>

<main class="w-screen px-10 flex-1 overflow-hidden flex flex-col justify-center  items-center">
    <?php if (isset($notification)): ?>
        <div class="notification">
            <p><?= htmlspecialchars($notification) ?></p>
        </div>
    <?php endif; ?>
    <section class="">
        <form action="/addHike" method="post" class="authForm w-[600px]">
        <div class="authFormSection">
            <label for="name" class="authLabel">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" class="authFormField" required>
        </div>

        <div class="authFormSection">
            <label for="distance" class="authLabel">Distance</label>
            <input type="text" id="distance" name="distance" value="<?= htmlspecialchars($_POST['distance'] ?? '') ?>" class="authFormField" required>
        </div>

        <div class="authFormSection">
            <label for="duration" class="authLabel">Duration</label>
            <input type="text" id="duration" name="duration" value="<?= htmlspecialchars($_POST['duration'] ?? '') ?>" class="authFormField" required>
        </div>

        <div class="authFormSection">
            <label for="elevation_gain" class="authLabel">Elevation Gain:</label>
            <input type="text" id="elevation_gain" name="elevation_gain" value="<?= htmlspecialchars($_POST['elevation_gain'] ?? '') ?>" class="authFormField" required>
        </div>

        <div class="authFormSection">
            <label for="description" class="authLabel">Description:</label>
            <textarea id="description" name="description" class="authFormField resize-none h-48" required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>
        <!-- Picture URL Hidden-->
        <input type="hidden" id="picture_url" name="picture_url" value="<?= htmlspecialchars($_POST['picture_url'] ?? '') ?>">

        <!-- User id Hidden-->
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['id']) ?>">

        <input type="submit" value="Add Hike" class="authButton">
    </form>
    </section>
</main>

<?php
include 'includes/footer.php';
?>

