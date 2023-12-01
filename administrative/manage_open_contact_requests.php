   <!--
    Author: Barbara Emke
    Date:   July 6, 2023

-->
<?php

session_start();

require_once('../utilities/database.php');

try{
    $query = 'SELECT *
            FROM contact_requests
            WHERE dateAddressed IS NULL';
    $statement = $db->prepare($query);
    $statement->execute();
    $requests = $statement->fetchAll();
    $statement->closeCursor();
} catch (PDOException $e) {
    // Handle database error
    $error_message = $e->getMessage();
    include('../utilities/database_error.php');
    exit();
}

?>


<?php include '../utilities/header.php'; ?>

<link href="../utilities/styles.css" rel="stylesheet" />

    <h1>Admin</h1>
    <h3 class="admin_menu">Menu</h3>
    <p class="admin_option"><a href="manage_users.php">Manage Users</a></p>
    <p class="admin_option"><a href="manage_admins.php">Manage Administrators</a></p>
    <p class="admin_option" ><a href="manage_open_contact_requests.php">Manage Open Contact Requests</a></p>
    <p class="admin_option"><a href="view_closed_contact_requests.php">View Closed Contact Requests</a></p>

    <h2 class="admin_heading">Open Contact Requests</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date Submitted</th>
            <th>&nbsp;</th>
        </tr>

        <?php foreach ($requests as $request) : ?>
        <tr class="aligned">
            <td class="open"><?php echo $request['name']; ?></td>
            <td class="open"><?php echo $request['email']; ?></td>
            <td class="open"><?php echo $request['message']; ?></td>
            <td class="open"><?php echo $request['dateSubmitted']; ?></td>
            <td><form action="close_contact_request.php" method="post">
                    <input type="hidden" name="requestID"
                           value="<?php echo $request['requestID']; ?>">
                    <input type="submit" value="Close">
                </form></td>
        </tr>
        <?php endforeach; ?>
    </table>
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