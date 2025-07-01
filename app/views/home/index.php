<?php require_once 'app/views/templates/header.php'; ?>

<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12">
                <!-- Show username passed from controller -->
                <h1>Welcome, <?= htmlspecialchars($data['username']); ?>!</h1>
                <!-- Show today's date -->
                <p class="lead"><?= date("F jS, Y"); ?></p>
            </div>
        </div>
    </div>

    <!-- Show logout link -->
    <div class="row">
        <div class="col-lg-12">
            <p><a href="/logout">Click here to logout</a></p>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
