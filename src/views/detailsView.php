<?php
include 'includes/header.php';

use Models\Hikes;
use Models\Users;

$hikeId = isset($_GET['id']) ? (int)$_GET['id'] : null;


if ($hikeId === null) {
    echo "Invalid hike ID.";
    exit;
}

$hikeDetails = Hikes::getHikeDetails($hikeId);
$userModel = new Users();
$userDetails = $userModel->getUserDetails($hikeDetails['user_id']);

if ($hikeDetails === null) {
    echo "Hike not found.";
    exit;
}
//    echo "<h1>Hike details</h1>";
?>

<main class="flex-1 flex flex-col justify-center items-center">

<div class="flex justify-between w-11/12 h-1/5 bg-white rounded-md shadow-sm overflow-hidden">
    <img src="<?= $hikeDetails['picture_url']; ?>" alt="Hike Image" class=" w-1/3 object-cover object-bottom rounded-s">
    <section class="flex justify-center items-top py-5 pl-2 pr-5 ">
        <a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="text-primary-200 mx-2">
                <span class="material-symbols-outlined">
                    arrow_back_ios
                </span>
        </a>
        <div class="">

            <h2 class="text-2xl font-bold text-primary-200 "><?= $hikeDetails['name']; ?></h2>

            <div class="hikesInfosBar">
                <div class="hikesInfo">
                                <span class="material-symbols-outlined">
                                    distance
                                </span>
                    <p><?php echo $hikeDetails['distance']; ?> km</p>
                </div>

                <div class="hikesInfo">
                                <span class="material-symbols-outlined">
                                    timer
                                </span>
                    <p> <?php echo $hikeDetails['duration']; ?> hours </p>
                </div>
                <div class="hikesInfo">
                                <span class="material-symbols-outlined">
                                    altitude
                                </span>
                    <p><?php echo $hikeDetails['elevation_gain']; ?> m</p>
                </div>
            </div>


            <p class="mb-5 text-sm leading-6"><?=$hikeDetails['description']; ?></p>

            <iframe class='w-full h-1/3 my-10 rounded-3xl self-center'
                    src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d53147.006939295585!2d-84.67094710692703!3d33.639332613621!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88f4fc2a15298593%3A0xa3f9172e00fafefa!2sForest%20Park%2C%20G%C3%A9orgie%2C%20%C3%89tats-Unis!5e0!3m2!1sfr!2sbe!4v1716924927224!5m2!1sfr!2sbe'
                    width='400' height='400'
                    style='border:0;'
                    allowfullscreen=''
                    loading='lazy'
                    referrerpolicy='no-referrer-when-downgrade'>
            </iframe>
        </div>
    </section>
</div>



<section class=" w-11/12 flex flex-col bg-white m-5 px-10 py-5 rounded-l shadow-sm">
    <div class="flex gap-5 justify-start items-center">
        <img src="<?= $userDetails['profile_picture']; ?>" alt="Hike Image" class=" w-20 h-20  object-cover object-top rounded-full">
        <div class="">
            <p class="text-xl"><?=$userDetails['username']; ?> </p>
            <p>Total hikes: 30</p>
        </div>
        <p class="bg-customWhite p-4 rounded-xl font-vollkorn text-primary-100 italic my-3 flex-1">\"Mountains are the beginning and the end of all landscapes.\"</p>
    </div>



    <div class="flex space-x-2 mt-2 self-end ">
        <img src="asset/svg/facebook_logo.svg" alt="Facebook Logo" class="w-5">
        <img src="asset/svg/instagram-logo.svg"   alt="Instagram Logo" class="w-5">
        <img src="asset/svg/x_logo.svg"   alt="X Logo" class="w-5">
    </div>



</section>
</main>






<!--<div class="grid grid-rows-3 grid-flow-col gap-4">-->
<!--    <div class="row-span-2 overflow-hidden">-->
<!--        --><?php
//        // Display the image from the Hikes table
//        echo "<img src='" . htmlspecialchars($hikeDetails['picture_url'], ENT_QUOTES, 'UTF-8') . "' alt='Hike Image' width='500' height='300' class='w-full h-auto'>";
//        ?>
<!--    </div>-->


<!--    <div class="row-span-2 col-span-2 p-4 border border-gray-200 rounded-lg shadow-lg">-->
<!--        --><?php
//        // Display the hike details
//
//        echo "<p>Created At: " . htmlspecialchars($hikeDetails['created_at'], ENT_QUOTES, 'UTF-8') . "</p>";
//        echo "<p>Updated At: " . htmlspecialchars($hikeDetails['updated_at'], ENT_QUOTES, 'UTF-8') . "</p>";
//        echo "<br>";
//        ?>





<!--        </div>-->




<!--    </div>-->



<!--</div>-->







<?php
//    // Display the hike details
//    echo "<h1>" . $hikeDetails['name'] . "</h1>";
//    echo "<p>Distance: " . $hikeDetails['distance'] . " km</p>";
//    // Other details
//echo "<p>Duration: " . $hikeDetails['duration'] . "</p>";
//
//// Display the hike details
//echo "<p>Elevation Gain: " . $hikeDetails['elevation_gain'] . "</p>";
//echo "<p>Description: " . $hikeDetails['description'] . "</p>";
//echo "<p>Created At: " . $hikeDetails['created_at'] . "</p>";
//echo "<p>Updated At: " . $hikeDetails['updated_at'] . "</p>";
//
//// Display the user details
//echo "<p>User: " . $hikeDetails['user_id'] . "</p>";
//echo "<p>User Name: " . $userDetails['username'] . "</p>";
//echo "<img src='" . $userDetails['profile_picture'] . "' alt='Profile Picture' class='rounded-full' width='100' height='100'>";
//
//// Display the image from the Hikes table
//echo "<img src='" . $hikeDetails['picture_url'] . "' alt='Hike Image' width='500' height='300'>";
//echo "<br>";
// Hyperlink to the previous page
include 'includes/footer.php';
?>
