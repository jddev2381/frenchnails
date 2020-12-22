<?php

require_once "inc/config.php";


// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once 'classes/' . $className . '.php';
});

// Instantiate Core Class
$visitor = new Visitor;
$core = new Core;

$core->checkIP($ipAddress);



$nailTechs = $visitor->getAvailableTechs();


$fname = '';
$lname = '';
$phone = '';
$nailTech = '';

$hands = '';
$handsOption1 = '';
$handsOption21 = '';
$handsOption22 = '';

$feet = '';
$feetOption1 = '';
$feetOption21 = '';
$feetOption22 = '';

$error = false;
$error_fname = '';
$error_lname = '';
$error_phone = '';
$error_nailTech = '';
$error_service = '';
$error_generic = '';

$error_h1 = '';
$error_h21 = '';
$error_h22 = '';

$error_f1 = '';
$error_f21 = '';
$error_f22 = '';



if(isset($_POST['register'])) {
    $fname = trim(ucwords(strtolower($_POST['fname'])));
    $lname = trim(ucwords(strtolower($_POST['lname'])));
    $phone = $_POST['phone'];
    $phone = $core->formatPhone($phone);

    $nailTech = $_POST['nailTech'];



    $hands = $_POST['hands'];
    $handsOption1 = $_POST['hands-1-options'];
    $handsOption21 = $_POST['hands-21-options'];
    $handsOption22 = $_POST['hands-22-options'];

    $feet = $_POST['feet'];
    $feetOption1 = $_POST['feet-1-options'];
    $feetOption21 = $_POST['feet-21-options'];
    $feetOption22 = $_POST['feet-22-options'];


    if(!$feet && !$hands) {
        $error = true;
        $error_service = 'You must select what service you would like.';
    }

    if($hands) {
        if(empty($handsOption1)) {
            $error = true;
            $error_h1 = 'Please select an option.';
        } else {
            if($handsOption1 == 'mani') {
                if(empty($handsOption21)) {
                    $error = true;
                    $error_h21 = 'Please select an option.';
                } 
            } else {
                if(empty($handsOption22)) {
                    $error = true;
                    $error_h22 = 'Please select an option.';
                }
            }
        }
    }

    if($feet) {
        if(empty($feetOption1)) {
            $error = true;
            $error_f1 = 'Please select an option.';
        }
        else {
            if($feetOption1 == 'pedi') {
                if(empty($feetOption21)) {
                    $error = true;
                    $error_f21 = 'Please select an option.';
                }
            } else {
                if(empty($feetOption22)) {
                    $error = true;
                    $error_f22 = 'Please select an option.';
                }
            }
        }
    }



    if(empty($fname)) {
        $error = true;
        $error_fname = 'You must provide your first name.';
    } elseif(!preg_match("/^[a-zA-Z\' ]*$/",$fname)) {
        $error = true;
        $error_fname = 'Only letters are allowed in your first name.';
    }
    if(empty($lname)) {
        $error = true;
        $error_lname = 'You must provide your last name.';
    } elseif(!preg_match("/^[a-zA-Z\' ]*$/",$lname)) {
        $error = true;
        $error_lname = 'Only letters are allowed in your last name.';
    }
    if(empty($phone)) {
        $error = true;
        $error_phone = 'You must provide your phone number.';
    } elseif(!preg_match("/^[0-9]*$/",$phone)) {
        $error = true;
        $error_phone = 'Only numbers are allowed in your phone number.';
    }
    if(empty($nailTech)) {
        $error = true;
        $error_nailTech = 'You must select an option.';
    }

    $deets = [
        'hands' => $hands,
        'feet' => $feet,
        'hands1' => $handsOption1,
        'hands21' => $handsOption21,
        'hands22' => $handsOption22,
        'feet1' => $feetOption1,
        'feet21' => $feetOption21,
        'feet22' => $feetOption22
    ];


    $deets = json_encode($deets);

    if(!$error) {
        // Process form
        if($visitor->checkVisitorIn($fname, $lname, $phone, $nailTech, $deets)) {
            // Redirect with message here
            $core->setMessage('success', "<h1>Thanks $fname!</h1><h2>You have been added to the queue.</h2><h3>Someone will let you know when you are up!</h3>");
            $core->redirect('');
        }
        else {
            $core->setMessage('success', "<h1>Oops!</h1><h2>Something went wrong</h2><h3>Please call attendant so they can assist you.</h3>");
            $core->redirect('');
        }
    }
}



$title = 'Check In';

require_once "inc/header.php";



?>






<div class="checkin">

    <h2>Check In</h2>


    <?php if($error) : ?>
        <div class="errors mb-50">
            <?php if(!empty($error_generic)) : ?>
                <h3 class="mb-50"><?= $error_generic; ?></h3>
            <?php else : ?>
                <h3>Please fix the errors below.</h3>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

        <div class="flexed mb-50">
            <div class="form-group">
                <input id="fname" type="text" name="fname" value="<?= htmlspecialchars($fname); ?>">
                <label>First Name</label>
                <?php if(!empty($error_fname)) : ?>
                    <p class="error"><?= $error_fname; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <input id="lname" type="text" name="lname" value="<?= htmlspecialchars($lname); ?>">
                <label>Last Name</label>
                <?php if(!empty($error_lname)) : ?>
                    <p class="error"><?= $error_lname; ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="flexed mb-50">

            <div class="form-group">
                <input id="phone" type="text" name="phone" value="<?= htmlspecialchars($phone); ?>">
                <label>Phone Number</label>
                <?php if(!empty($error_phone)) : ?>
                    <p class="error"><?= $error_phone; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <select id="nailTech" name="nailTech">
                    <option value=""></option>
                    <option value="first" <?= ($nailTech == 'first' ? 'selected' : '') ?>>First Available</option>
                    <?php foreach($nailTechs as $tech) : ?>
                        <option value="<?= $tech->worker_id ?>" <?= ($nailTech == $tech->worker_id ? 'selected' : '') ?>><?= $tech->name ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Desired Nail Tech</label>
                <?php if(!empty($error_nailTech)) : ?>
                    <p class="error"><?= $error_nailTech; ?></p>
                <?php endif; ?>
            </div>

        </div>





        <div class="flexed mb-50">

            <div class="form-group">
                <label class="check-container"> <img src="img/icons/mani-white.png" alt="Manicure">
                    <input name="hands" id="hands" type="checkbox" <?= $hands ? 'checked' : ''; ?>>
                    <span class="checkmark"></span>
                </label>
                <?php if(!empty($error_service)) : ?>
                    <p class="error"><?= $error_service; ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="check-container"> <img src="img/icons/pedi-white.png" alt="Pedicure">
                    <input name="feet" id="feet" type="checkbox" <?= $feet ? 'checked' : ''; ?>>
                    <span class="checkmark"></span>
                </label>
                <?php if(!empty($error_service)) : ?>
                    <p class="error"><?= $error_service; ?></p>
                <?php endif; ?>
            </div>

        </div>


        <div class="flexed">

            <div class="hand-stuff">

                <div id="hands-1" class="form-group mb-50 hands-div-step fadeIn">
                    <select id="hands-1-options" name="hands-1-options">
                        <option value=""></option>
                        <option value="mani" <?= $handsOption1 == 'mani' ? 'selected' : ''; ?>>Manicure</option>
                        <option value="fill" <?= $handsOption1 == 'fill' ? 'selected' : ''; ?>>Fill In</option>
                        <option value="full" <?= $handsOption1 == 'full' ? 'selected' : ''; ?>>Full Set</option>
                    </select>
                    <label>What would you like done?</label>
                    <?php if(!empty($error_h1)) : ?>
                        <p class="error"><?= $error_h1; ?></p>
                    <?php endif; ?>
                </div>

                <div id="hands-21" class="form-group mb-50 hands-div-step fadeIn">
                    <select id="hands-21-options" name="hands-21-options">
                        <option value=""></option>
                        <option value="color" <?= $handsOption21 == 'color' ? 'selected' : ''; ?>>Color</option>
                        <option value="gel" <?= $handsOption21 == 'gel' ? 'selected' : ''; ?>>Gel</option>
                        <option value="tips" <?= $handsOption21 == 'tips' ? 'selected' : ''; ?>>White Tips</option>
                    </select>
                    <label>Details</label>
                    <?php if(!empty($error_h21)) : ?>
                        <p class="error"><?= $error_h21; ?></p>
                    <?php endif; ?>
                </div>

                <div id="hands-22" class="form-group mb-50 hands-div-step fadeIn">
                    <select id="hands-22-options" name="hands-22-options">
                        <option value=""></option>
                        <option value="color" <?= $handsOption22 == 'color' ? 'selected' : ''; ?>>Color</option>
                        <option value="gel" <?= $handsOption22 == 'gel' ? 'selected' : ''; ?>>Gel</option>
                        <option value="tips" <?= $handsOption22 == 'tips' ? 'selected' : ''; ?>>White Tips</option>
                        <option value="pw" <?= $handsOption22 == 'pw' ? 'selected' : ''; ?>>Pink & White</option>
                        <option value="powder" <?= $handsOption22 == 'powder' ? 'selected' : ''; ?>>Powder Dip</option>
                    </select>
                    <label>Details</label>
                    <?php if(!empty($error_h22)) : ?>
                        <p class="error"><?= $error_h22; ?></p>
                    <?php endif; ?>
                </div>

            </div>












            <div class="feet-stuff">

                <div id="feet-1" class="form-group mb-50 fadeIn">
                    <select id="feet-1-options" name="feet-1-options">
                        <option value=""></option>
                        <option value="pedi" <?= $feetOption1 == 'pedi' ? 'selected' : ''; ?>>Pedicure</option>
                        <option value="paint" <?= $feetOption1 == 'paint' ? 'selected' : ''; ?>>Paint Only</option>
                    </select>
                    <label>What would you like done?</label>
                    <?php if(!empty($error_f1)) : ?>
                        <p class="error"><?= $error_f1; ?></p>
                    <?php endif; ?>
                </div>

                <div id="feet-21" class="form-group mb-50 fadeIn">
                    <select id="feet-21-options" name="feet-21-options">
                        <option value=""></option>
                        <option value="color" <?= $feetOption21 == 'color' ? 'selected' : ''; ?>>Color</option>
                        <option value="gel" <?= $feetOption21 == 'gel' ? 'selected' : ''; ?>>Gel</option>
                        <option value="tips" <?= $feetOption21 == 'tips' ? 'selected' : ''; ?>>White Tips</option>
                        <option value="pedi" <?= $feetOption21 == 'pedi' ? 'selected' : ''; ?>>Pedicure Only</option>
                    </select>
                    <label>Details</label>
                    <?php if(!empty($error_f21)) : ?>
                        <p class="error"><?= $error_f21; ?></p>
                    <?php endif; ?>
                </div>

                <div id="feet-22" class="form-group mb-50 fadeIn">
                    <select id="feet-22-options" name="feet-22-options">
                        <option value=""></option>
                        <option value="color"  <?= $feetOption22 == 'color' ? 'selected' : ''; ?>>Color</option>
                        <option value="gel" <?= $feetOption22 == 'gel' ? 'selected' : ''; ?>>Gel</option>
                        <option value="tips" <?= $feetOption22 == 'tips' ? 'selected' : ''; ?>>White Tips</option>
                    </select>
                    <label>Details</label>
                    <?php if(!empty($error_f22)) : ?>
                        <p class="error"><?= $error_f22; ?></p>
                    <?php endif; ?>
                </div>


            </div>

        </div>


        <div class="flexed contains-btns mb-50">
            <a href="index.php">Cancel <i class="icon fas fa-times"></i></a>
            <button id="checkInButton" type="submit" name="register">Check In <i class="icon fas fa-check"></i></button>
        </div>

    </form>


</div>





<?php require_once "inc/footer.php"; ?>