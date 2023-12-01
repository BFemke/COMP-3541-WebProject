<!--
    Author: Barbara Emke
    Date:   July 6, 2023
   -->
<?php 

if(isset($_SESSION['user'])){
   $name = $_SESSION['user']['firstName']." ".$_SESSION['user']['lastName'];
   $username = $_SESSION['user']['username'];
}
?>

<html lang="en">
<head>
   <meta charset="utf-8" />
   <meta name="keywords" content="accessibility, resource, about, reviews, disability" />
   <meta name="viewport" content= "width= device-width, initial-scale=1" /> 

   <title>Accessibility Now</title>

</head>

<body id="base_body">
	<header>
		<div id="logo">
			<img src="../images/logo.png" alt="logo"/>
		</div>
         <div class="profile">
            <?php if(isset($name)){
               echo "<a href=\"../profile/view_profile.php\">";
               $imageBase64 = base64_encode($_SESSION['user']['image']);
               $imageSrc = 'data:image/jpeg;base64,' . $_SESSION['user']['image'];
               echo '<img class="user-image" src="' . $imageSrc . '" alt="profile image">'; 
               echo "</a>";
               echo "<div class=\"text\">";
               echo "<p class=\"name\">{$name}</p>";
               echo "<p class=\"info\">{$username}</p>";
               echo "<form class=\"form-container\" action=\"../utilities/logout.php\" method=\"POST\">";
               echo "<button class=\"logout-btn\" type=\"submit\">Logout</button>";
	            echo "</form>";
               echo "</div>";

            }
            else {
               echo "<p><a id=\"sign-in\" href=\"#\">Login</a>/<a id=\"register\" href=\"#\">Register</a></p>";
            }
            ?>
         </div>
         <nav class="horizontal">
            <ul class="mainmenu">
               <li><a href="../home/index.php">Home</a></li>
               <li><a href="../reviews/find_business.php">Reviews</a></li>
               <li><a href="../resources/view_resources.php">Resources</a></li>
               <?php if(isset($_SESSION['user']) && $_SESSION['user']['isAdmin'] == TRUE){
                  echo "<li><a href=\"../administrative/manage_open_contact_requests.php\">Admin</a></li>";
               } ?>
            </ul>
         </nav>
	</header>
   <main>
      <?php if(!(isset($_SESSION['user']))) : ?>

         <script defer src="../utilities/profile_forms.js"></script>
         <?php 
         include '../utilities/login_form.php'; 
         include '../utilities/register_form.php'; 
         
      endif; ?>