<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">

		<link rel="shortcut icon" href="<?php echo SITE_URL; ?>img/favicon.png">

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


		<!--STYLESHEETS-->

    	<link rel="stylesheet" href="<?php echo SITE_URL; ?>css/admin.css">






    	<!--FONTS-->

        <script src="https://kit.fontawesome.com/5f8b5295f2.js" crossorigin="anonymous"></script>


        

        



    	<title><?php echo $title; ?></title>

    </head>



    <body>


        <?php
            if($page != 'login') : ?>
        ?>

            <section id="adminNav">

                <h2>Admin Area</h2>

                <ul>
                    <li><a href="<?= SITE_URL ?>admin/" <?= $page == 'home' ? 'class="active"' : ''; ?>><i class="fas fa-tachometer-alt"></i> Home</a></li>
                    <li><a href="<?= SITE_URL ?>admin/profile.php" <?= $page == 'profile' ? 'class="active"' : ''; ?>><i class="far fa-id-badge"></i> Profile</a></li>
                    <li><a href="<?= SITE_URL ?>admin/staff.php" <?= $page == 'staff' ? 'class="active"' : ''; ?>><i class="fas fa-users-cog"></i> Staff</a></li>
                    <li><a href="<?= SITE_URL ?>admin/clients.php" <?= $page == 'clients' ? 'class="active"' : ''; ?>><i class="fas fa-users"></i> Clients</a></li>
                    <li><a href="<?= SITE_URL ?>admin/reports.php" <?= $page == 'reports' ? 'class="active"' : ''; ?>><i class="fas fa-chart-line"></i> Reports</a></li>
                    <li><a href="<?= SITE_URL ?>admin/reset.php?pass=clumsybiketanktruckcarswimmermanpaddedcorkwhiskey" <?= $page == 'reset' ? 'class="active"' : ''; ?>><i class="fas fa-redo"></i> Reset System</a></li>
                    <li><a href="<?= SITE_URL ?>admin/logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                </ul>

            </section>

        <?php endif; ?>