<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$router = new AltoRouter();


// Home
$router->map('GET', '/', function() {
    require __DIR__ . "/../src/views/homeView.php";
});
$router->map('GET', '/home', function() {
    require __DIR__ . "/../src/views/homeView.php";
});

// Sign In
$router->map('GET', '/signin', function() {
    require __DIR__ . "/../src/views/signinView.php";
});
$router->map('POST', '/signin', function() {
    require __DIR__ . "/../src/views/signinView.php";
});


// Login
$router->map('GET', '/login', function() {
    require __DIR__ . "/../src/views/loginView.php";
});
$router->map('POST', '/login', function() {
    require __DIR__ . "/../src/views/loginView.php";
});

// Logout
$router->map('GET', '/logout', function() {
    require __DIR__ . "/../src/views/logoutView.php";
});

// Forgot Password
$router->map('GET', '/forgotPassword', function() {
    require __DIR__ . "/../src/views/forgotPasswordView.php";
});
$router->map('POST', '/forgotPassword', function() {
    require __DIR__ . "/../src/views/forgotPasswordView.php";
});

// Profile
$router->map('GET', '/profile', function() {
    require __DIR__ . "/../src/views/profileView.php";
});

//Details
$router->map('GET', '/details', function() {
    require __DIR__ . "/../src/views/detailsView.php";
});

// Edit Profile
$router->map('GET', '/editProfile', function() {
    require __DIR__ . "/../src/views/editProfileView.php";
});
$router->map('POST', '/editProfile', function() {
    require __DIR__ . "/../src/views/editProfileView.php";
});

// Change Password
$router->map('GET', '/editPassword', function() {
    require __DIR__ . "/../src/views/editPasswordView.php";
});
$router->map('POST', '/editPassword', function() {
    require __DIR__ . "/../src/views/editPasswordView.php";
});

// Edit Hike
$router->map('GET', '/editHike', function() {
    require __DIR__ . "/../src/views/editHikeView.php";
});
$router->map('POST', '/editHike', function() {
    require __DIR__ . "/../src/views/editHikeView.php";
});
// Add Hike
$router->map('GET', '/addHike', function() {
    require __DIR__ . "/../src/views/addHikeView.php";
});
$router->map('POST', '/addHike', function() {
    // Handle the form submission to add a new hike
    $hikeData = $_POST;
    try {
        \Controllers\HikesController::addHike($hikeData);
        // Redirect to a success page or the profile page after successful addition
        header('Location: /profile');
        exit();
    } catch (\Exception $e) {
        // Handle the error, e.g., show an error message
        echo $e->getMessage();
    }
});

// Delete Hike
$router->map('POST', '/deleteHike', function() {
    $hikeId = $_POST['hikeId'] ?? null;
    if ($hikeId) {
        \Controllers\HikesController::deleteHike((int)$hikeId);
        header('Location: /profile');
        exit();
    } else {
        // Handle the error, e.g., show an error message
        echo "No hikeId provided";
    }
});
// match current request
$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}
?>
