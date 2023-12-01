<!--
    Author: Barbara Emke
    Date:   July 6, 2023

-->
<?php 
session_start();

require_once('../utilities/database.php');

//set values for later use
$_SESSION['path'] = $_SERVER['HTTP_REFERER'];

?>

<?php include '../utilities/header.php'; ?>

<link href="../utilities/styles.css" rel="stylesheet" />
    
    <p class="admin_option"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a></p>
    <h2>Update Profile</h2>
    <div class="edit_form">
        <form class="edit_user" action="update_profile.php" method="post" enctype="multipart/form-data">
            <?php $imageBase64 = base64_encode($_SESSION['user']['image']);
               $imageSrc = 'data:image/jpeg;base64,' . $_SESSION['user']['image'];
               echo '<img class="user-image" id="profile" src="' . $imageSrc . '" alt="profile image">'; ?>
            
            <input class="image_form" type="file" name="image">

            <label class="label">First Name:</label>
            <input class="value" type="text" name="firstName" value="<?php echo $_SESSION['user']['firstName']; ?>" required><br>

            <label class="label">Last Name:</label>
            <input class="value" type="text" name="lastName" value="<?php echo $_SESSION['user']['lastName']; ?>" required><br>

            <label class="label">Username:</label>
            <input class="value" type="text" name="username" value="<?php echo $_SESSION['user']['username']; ?>" required><br>

            <label class="label">Email:</label>
            <input class="value" type="text" name="email" value="<?php if(isset($_SESSION['user']['email'])){ echo $_SESSION['user']['email']; }?>"><br>

            <label class="label">Password:</label>
            <input class="value" type="text" name="pass" value="<?php echo $_SESSION['user']['password']; ?>" required><br>

            <label class="label">&nbsp;</label>
            <input class="value" type="submit" value="Update Profile"><br>

            <div style="clear:both;"></div>
        </form>
    </div>
    

<?php include '../utilities/footer.php'; ?>

<script defer>
    document.addEventListener("DOMContentLoaded", function() {
        //changes style of body element in order to restrict size
        var body = document.getElementById("base_body");
        body.style.minWidth = "800px";

        //changes style of footer element in order to restrict size
        var footer = document.getElementById("base_footer");
        footer.style.minWidth = "800px";
    });
</script>