<?php
declare(strict_types=1);

use Controllers\HikesController;
use Models\Hikes;

// Import the Hikes class

$page1 = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$selectedTag = isset($_GET['tag']) ? $_GET['tag'] : null;
// HikesController::test();
HikesController::getHikeNames();
if ($selectedTag) {
    $hikeNames = HikesController::getHikesByTag($selectedTag, $page1);
} else {
    $hikeNames = HikesController::getHikeNames($page1); // Get the first page
}
$totalHikes = Hikes::getTotalHikes();
$itemsPerPage = 6;
$totalPages = ceil($totalHikes / $itemsPerPage);
?>

<!--    <h2>List of hikes</h2>-->
<section class=" w-5/6 flex justify-around m-4">

    <!--  EASY  -->
    <a href="?tag=Easy" class="tagsButton">
        <span class="material-icons">
            star_outline
        </span>
    </a>

    <!--  MODERATE  -->
    <a href="?tag=Moderate" class="tagsButton">
        <span class="material-icons">
            star_half
        </span>
    </a>

    <!--  DIFFICULT  -->
    <a href="?tag=Difficult" class="tagsButton">
        <span class="material-icons">
            star
        </span>
    </a>

    <!--  HISTORICAL  -->
    <a href="?tag=Historical" class="tagsButton">
        <span class="material-icons">
            stadium
        </span>
    </a>

    <!--  FOREST  -->
    <a href="?tag=Forest" class="tagsButton">
        <span class="material-icons">
            forest
        </span>
    </a>

    <!--  WATERFALL -->
    <a href="?tag=Waterfall" class="tagsButton">
        <span class="material-icons">
            sailing
        </span>
    </a>

    <!--  BIRDWATCHING  -->
    <a href="?tag=Wildflowers" class="tagsButton">
        <span class="material-icons">
            local_florist
        </span>
    </a>

    <!--  DOG-FRIENDLY  -->
    <a href="?tag=Dog-friendly" class="tagsButton">
        <span class="material-icons">
            pets
        </span>
    </a>

    <!--  SCENIC  -->
    <a href="?tag=Scenic" class="tagsButton">
        <span class="material-icons">
            vrpano
        </span>
    </a>

    <!--  SPRING/FALL  -->
    <a href="?tag=Spring" class="tagsButton">
        <span class="material-icons">
            emoji_nature
        </span>
    </a>

    <!--  SUMMER  -->
    <a href="?tag=Summer" class="tagsButton">
        <span class="material-icons">
            beach_access
        </span>
    </a>

</section>

<section class="w-fit overflow-x-hidden grid grid-cols-3 gap-x-10 gap-y-5 px-4">
    <?php foreach ($hikeNames as $hike): ?>
        <?php $hikeDetails = Hikes::getHikeDetails($hike['id']); ?>

        <a href="details?id=<?php echo $hike['id']; ?>">
        <div class="min-w-[100px] overflow-hidden flex flex-col items-center h-80 bg-white rounded-xl flex shadow-sm">
            <img src="<?php echo $hikeDetails['picture_url']; ?>" alt="Hike Image" class="w-full h-40 object-cover rounded-t-xl">

            <h3 class="font-vollkorn font-bold text-xl text-primary-200 mt-3">
                    <?php echo $hike['name']; ?>
            </h3>

            <div class="hikesInfosBar">
                <div class="hikesInfo">
                    <span class="material-symbols-outlined">
                        distance
                    </span>
                    <p><?php echo $hike['distance']; ?> km</p>
                </div>

                <div class="hikesInfo">
                    <span class="material-symbols-outlined">
                        timer
                    </span>
                    <p> <?php echo $hike['duration']; ?> hours </p>
                </div>
                <div class="hikesInfo">
                    <span class="material-symbols-outlined">
                        altitude
                    </span>
                    <p><?php echo $hike['elevation_gain']; ?> m</p>
                </div>
            </div>

            <?php $hikeTags = Hikes::getHikeTags($hike['id']); ?>

            <ul class="hikesTagsBar">
                <?php foreach ($hikeTags as $tag): ?>
                    <li class="hikesTag">
                        <?php echo $tag['tag_name']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p class="text-xs pt-6 self-end mr-1 text-slate-300">
                <?php echo $hike['created_at']; ?>
            </p>
        </div>
        </a>
    <?php endforeach; ?>



</section>

<aside class="pages">
    <ul>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li >
                <a href='?page=<?php echo $i; ?>'>
                    <span><?php echo $i; ?></span>
                </a>
            </li>
        <?php endfor; ?>
    </ul>
</aside>