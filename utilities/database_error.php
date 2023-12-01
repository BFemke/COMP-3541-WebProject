<!--Barbara Emke (T00721475) -->

<!DOCTYPE html>
<html>

<?php include '../utilities/header.php'; ?>

<link href="../utilities/styles.css" rel="stylesheet" />

    <main>
        <h1>Database Error</h1>
        <p class="back"><a href="<?php echo$_SERVER['HTTP_REFERER'];?>";>Back</a></p>
        <p>An error occurred while attempting to work with the database.</p>
        <p>Message: <?php echo $error_message; ?></p>
        <p>&nbsp;</p>
    </main>

<?php include 'footer.php'; ?>