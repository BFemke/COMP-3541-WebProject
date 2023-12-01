<!--
    Author: Barbara Emke
    Date:   July 6, 2023

-->
<?php

session_start();

require_once('../utilities/database.php');

?>

<?php include '../utilities/header.php'; ?>

<link href="../utilities/styles.css" rel="stylesheet" />

    <h1>Profile</h1>

    <div id="profile_bar">
        <div id="user_image">
            <?php $imageBase64 = base64_encode($_SESSION['user']['image']);
               $imageSrc = 'data:image/jpeg;base64,' . $_SESSION['user']['image'];
               echo '<img class="user-image" id="profile" src="' . $imageSrc . '" alt="profile image">'; ?>
        </div>
        <div id="user_info">
            <p id="users_name"><?php echo $_SESSION['user']['firstName']." ".$_SESSION['user']['lastName']; ?></p>
            <p class="users_info"><?php echo $_SESSION['user']['username']; ?></p>
            <p class="users_info"><?php echo (isset($_SESSION['user']['email'])) ? $_SESSION['user']['email'] : ""; ?></p>
        </div>
    </div>
    <form class="profile_form" action="update_profile_form.php" method="POST" enctype="multipart/form-data">
            <input class="profile_form_btn" type="submit" value="Edit Profile">
    </form>
<?php include '../utilities/footer.php';