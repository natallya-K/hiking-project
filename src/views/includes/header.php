<?php
    declare(strict_types=1);
    require_once __DIR__ . '/../../../vendor/autoload.php';
//    var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Wonderlust</title>
<!--  Google material  -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link href="/css/tailwind.css" rel="stylesheet">
</head>


<body class="min-h-screen justify-between bg-customWhite text-customBlack font-radio text-customBlack flex flex-col overflow-x-hidden scrollbar-none">
<?php
$uri = $_SERVER['REQUEST_URI'];
if (preg_match('/^\/(\?|home)?(\?.*)?$/', $uri)):
?>
<section class="bg-[url('https://images.unsplash.com/photo-1552083375-1447ce886485?q=80&w=3270&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-cover bg-center w-screen h-5/6 shadow ">
<?php endif; ?>

    <?php
    if (preg_match('/^\/(\?|home)?(\?.*)?$/', $uri)) {
        $headerClass = "homeHeader";
    } else {
        $headerClass = "header";
    }
    ?>

    <header class="header-wrapper <?php echo $headerClass ?>">
        <div class="logo">
            <a href="/">Wonderlust</a>
        </div>
        <?php
        include 'nav.php';
        ?>
    </header>
