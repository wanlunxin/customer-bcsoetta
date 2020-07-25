<div class="grid">
    <?php if (isset($_SESSION['sdata']['apps_data'])) { $apps = $_SESSION['sdata']['apps_data']; foreach ($apps as $app) { ?>
        <div class="grid-div">
            <a href="<?php echo $app['app_url']; ?>">
                <img src="/assets/images/binary.svg" alt="">
                <div class="apptitle"><?php echo $app['app_name']; ?></div>
            </a>
        </div>
    <?php } } ?>
</div>