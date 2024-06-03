<nav class="flex ">
    <ul class="links">
        <?php if (isset($_SESSION['isConnected']) && $_SESSION['isConnected'] ) : ?>
            <li><a href="/profile">Profile</a></li>
            <li> <a href="/logout">Logout</a></li>
        <?php else : ?>
            <li><a href="/login">Login</a></li>
        <?php endif; ?>

    </ul>
</nav>



