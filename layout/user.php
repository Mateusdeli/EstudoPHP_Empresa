<?php 
    if (!isset($_SESSION['login']['logged'])) {
        return;
    }
?>

<div class="bg-dark text-light text-right p-2">
    <?= $_SESSION['login']['user'] ?> | <a class="btn btn-primary" href="?p=logout">Logout</a>
</div>