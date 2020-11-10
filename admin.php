
<?php if (isset($_SESSION['login']['logged'])): ?>

    <h3>Fala Admin</h3>
    <div class="row text-right">
        <div class="col-6">
            <p><?= $_SESSION['login']['user'] ?></p>
        </div>
        <div class="col-6">
            <button>Loggout</button>
        </div>
    </div>

<?php else: ?>
<div class="container">
    <div class="row mt-5"></div>
        <div class="offset-3 col-6">
            <form action="?p=admin" method="POST">
                <div class="form-group">
                    <input type="email" name="text_email" class="form-control" placeholder="Enter email...">
                </div>
                <div class="form-group">
                    <input type="password" name="text_password" class="form-control" placeholder="Enter password...">
                </div>
                <div class="text-right">
                    <input type="submit" class="btn btn-primary" value="Logar">
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>



