<?php
function navbar()
{
?>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <!-- brand icon -->
            <a class="navbar-brand" href="#">
                <img src="./img/logo.svg" height="60" alt="" loading="lazy" />
            </a>
            <?php
            if (isset($_SESSION['user_id'])) {
            ?>
                <form class="d-flex input-group w-auto">
                    <!-- logout button -->
                    <a href="logout.php">
                        <button class="btn btn-outline-primary" type="button" data-mdb-ripple-color="dark">
                            LogOut
                        </button>
                    </a>
                </form>
            <?php
            }
            ?>
        </div>
    </nav>
    <!-- Navbar -->
<?php
}
?>