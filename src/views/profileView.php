<?php
include 'includes/header.php';

use Controllers\HikesController;

$hikes = HikesController::getHikeUsers($_SESSION['id']);

if (!isset($_SESSION['isConnected']) || $_SESSION['isConnected'] === false) {
    header('Location: /login');
    exit();
}

?>

<main class="w-screen px-10 flex-1 overflow-hidden flex flex-col justify-center items-center">
        <!-- Profile Section -->
        <section class="flex w-11/12 items-start rounded-lg shadow-sm p-4 bg-white">
            <!-- Profile Picture and Actions -->
            <div class="mr-5">
                <img src="<?= htmlspecialchars($_SESSION['profilePicture'], ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Picture" width="150" height="130" class="rounded-full my-3">

                <div class="flex justify-center items-center">
                    <a href="/editProfile" class="font-medium text-secondary-200 dark:text-blue-500 hover:underline">
                    <span class="material-symbols-outlined">
                        upgrade
                    </span>
                    </a>
                    <a href="/editPassword" class="font-medium text-secondary-200 dark:text-blue-500 hover:underline">
                    <span class="material-symbols-outlined">
                        key_vertical
                    </span>
                    </a>
                </div>

            <!-- Profile Information -->
                <div class="mt-2">
                    <p class="text-secondary-100 text-xs">Username <span class="italic text-secondary-50 text-center text-xs mt-1">( <?= $_SESSION['role'] ?> )</span>
                    </p>
                    <p ><?= $_SESSION['username'] ?></p>

                </div>

                <div class="mt-2">
                    <p class="text-secondary-100 text-xs">First name</p>
                    <p><?= $_SESSION['firstname'] ?></p>
                </div>

                <div class="mt-2">
                    <p class="text-secondary-100 text-xs">Last name</p>
                    <p><?= $_SESSION['lastname'] ?></p>
                </div>

                <div class="mt-2">
                    <p class="text-secondary-100 text-xs">Email</p>
                    <p> <?= $_SESSION['email'] ?></p>
                </div>
            </div>

        <!-- List of Hikes Section -->
            <div class=" flex-grow">
                <div class="flex justify-between">
                    <h2 class="text-lg font-semibold">List of Hikes</h2>
                    <a href="/addHike" class=" flex items-center justify-center bg-primary-200 hover:bg-primary-100 active:bg-primary-50 text-white w-4 h-4 rounded-full">
                        <span class="">
                            +
                        </span>
                    </a>
                </div>
                <ul class="max-h-96 overflow-y-scroll rounded-lg">
                <?php
                // Check the user role
                if ($_SESSION['role'] === 'admin') {
                    // If the user is an admin, get all hikes
                    $hikes = \Controllers\HikesController::getAllHikes();
                } else {
                    // If the user is not an admin, get only the hikes related to the user
                    $hikes = \Controllers\HikesController::getHikeUsers($_SESSION['id']);
                }
                foreach ($hikes as $hike): ?>
                    <li class="flex justify-between my-2 bg-slate-50 rounded-2xl overflow-hidden">
                        <div class="flex flex-col  p-2 text-primary-200">
                            <p>Name <?= htmlspecialchars($hike['name'], ENT_QUOTES, 'UTF-8') ?></p>
                            <p>Distance <?= htmlspecialchars($hike['distance'], ENT_QUOTES, 'UTF-8') ?> km</p>
                            <p>Date <?= date('Y-m-d', strtotime($hike['created_at'])) ?></p>
                        </div>
                        <!-- Update button -->
                        <div class="flex justify-center items-center gap-3 mr-3">

                            <a href="/editHike?hikeId=<?= $hike['id'] ?>" class="flex items-center justify-center w-8 h-8 rounded-full bg-primary-200 hover:bg-primary-100 active:bg-primary-50 text-white text-xs">
                                <span class="material-symbols-outlined">
                                    upgrade
                                </span>
                            </a>

                            <form action="/deleteHike" method="post" class="flex ">
                                <input type="hidden" name="hikeId" value="<?= $hike['id'] ?>">
                                <button class=" flex items-center justify-center w-8 h-8 rounded-full bg-secondary-300 hover:bg-secondary-100 active:bg-secondary-50 text-white text-xs" type="submit">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            </div>
        </section>

</main>


<?php
include 'includes/footer.php'
?>
