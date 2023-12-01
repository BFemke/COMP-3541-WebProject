<!--
    Author: Barbara Emke
    Date:   July 6, 2023

-->
<?php 
session_start();

require_once('../utilities/database.php');

$userID = filter_input(INPUT_POST, 'userID');

//set values for later use
$_SESSION['userID'] = $userID;
$_SESSION['path'] = $_SERVER['HTTP_REFERER'];

if($userID == 0){

}
else{
    try{
        //gets incident details
        $query = 'SELECT * FROM users
                    WHERE userID = :userID
                    LIMIT 1';
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();
    } catch (PDOException $e) {
        // Handle database error
        $error_message = $e->getMessage();
        include('../utilities/database_error.php');
        exit();
    }
}
?>

<?php include '../utilities/header.php'; ?>

<link href="../utilities/styles.css" rel="stylesheet" />
    
    <p class="admin_option"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a></p>
    <h2><?php echo ($userID == 0) ? "Add New Admin" : "Update User/Admin"; ?></h2>
    <div class="edit_form">
        <form class="edit_user" action="update_user.php" method="post">
            <?php if(isset($user)) : ?>
            <label class="label">User ID:</label>
            <label class="value"><?php echo $user['userID'];?></label><br>
            <?php endif; ?>

            <label class="label">First Name:</label>
            <input class="value" type="text" name="firstName" value="<?php if(isset($user)){ echo $user['firstName']; }?>" required><br>

            <label class="label">Last Name:</label>
            <input class="value" type="text" name="lastName" value="<?php if(isset($user)){ echo $user['lastName']; }?>" required><br>

            <label class="label">Username:</label>
            <input class="value" type="text" name="username" value="<?php if(isset($user)){ echo $user['username']; }?>" required><br>

            <label class="label">Email:</label>
            <input class="value" type="text" name="email" value="<?php if(isset($user) && isset($user['email'])){ echo $user['email']; }?>"><br>

            <label class="label">Password:</label>
            <input class="value" type="text" name="pass" value="<?php if(isset($user)){ echo $user['password']; }?>" required><br>

            <label class="label">&nbsp;</label>
            <input class="value" type="submit" value="<?php echo ($userID == 0) ? "Add Admin" : "Update User"; ?>"><br>

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