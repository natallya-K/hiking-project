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
        $_POST['hikeId'] = (int)$_POST['hikeId'];
        HikeController::updateHike($_POST);
        $notification = "Hike updated successfully.";
    } catch (Exception $e) {
        $notification = "Error: " . $e->getMessage();
    }
}

// Retrieve hike data for pre-filling the form
if (isset($_GET['hikeId'])) {
    $hikeId = (int)$_GET['hikeId'];
    $hike = HikeController::getHikeById($hikeId);
    if (!$hike) {
        // Handle the case where the hike is not found (maybe redirect or show an error)
        header('Location: /profile');
        exit();
    }
} else {
    // Handle the case where hikeId is not set (maybe redirect or show an error)
    header('Location: /profile');
    exit();
}
?>

<main class="w-screen px-10 flex-1 overflow-hidden flex flex-col justify-center  items-center">
    <?php if (isset($notification)): ?>
        <div class="notification">
            <p><?= htmlspecialchars($notification) ?></p>
        </div>
    <?php endif; ?>

    <section class="">

        <form action="/editHike" method="post" class="authForm w-[600px]">
            <input type="hidden" name="hikeId" value="<?= htmlspecialchars($hike['id']) ?>">

            <div class="authFormSection">
                <label for="name" class="authLabel" required>Name</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($hike['name']) ?>" class="authFormField" required>
            </div>

            <div class="authFormSection">
                <label for="distance" class="authLabel" required>Distance</label>
                <input type="text" id="distance" name="distance" value="<?= htmlspecialchars($hike['distance']) ?>" class="authFormField" required>
            </div>

            <div class="authFormSection">
                <label for="duration" class="authLabel" required>Duration</label>
                <input type="text" id="duration" name="duration" value="<?= htmlspecialchars($hike['duration']) ?>" class="authFormField" required>
            </div>

            <div class="authFormSection">
                <label for="elevation_gain" class="authLabel" required>Elevation Gain</label>
                <input type="text" id="elevation_gain" name="elevation_gain" value="<?= htmlspecialchars($hike['elevation_gain']) ?>" class="authFormField" required>
            </div>

            <div class="authFormSection">
                <label for="description" class="authLabel" required>Description</label>
                <textarea id="description" name="description" class="authFormField resize-none h-48" required><?= htmlspecialchars($hike['description']) ?></textarea>
            </div>

            <input type="submit" value="Update Hike" class="authButton">
        </form>
    </section>

</main>

<?php
include 'includes/footer.php';
?>


