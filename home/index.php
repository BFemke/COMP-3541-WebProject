   <!--
    Author: Barbara Emke
    Date:   July 6, 2023
-->

<?php
session_start();
?>

<?php include '../utilities/header.php'; ?>
   
   <link href="../utilities/styles.css" rel="stylesheet" />
	
	<h1>Welcome</h1>
	<div id="options">
		<div class="options" id="reviews_option">
			<p class="option_text">Find reviews of businesses regarding their accessibility!</p>
			<button type="button" class="option_button" onclick="location.href = '../reviews/find_business.php';">Find Reviews</button>
		</div>
		<div class="options" id="resources_option">
			<p class="option_text">Find out about the resources and services that others have 
			found and shared!</p>
			<button type="button" class="option_button" onclick="location.href = '../resources/view_resources.php';">Find Resources</button>
		</div>
	</div>
	<div class="divider"></div>
	<h2>About</h2>
	<p class="about">Welcome to our website dedicated to providing services and resources for individuals with 
	disabilities! Our goal is to create a community where people with disabilities can come 
	together to share reviews on businesses and services, as well as access valuable resources to 
	help navigate the world with a disability.</p>

	<p class="about">We understand that finding businesses that are accessible and accommodating for people with 
	disabilities can be a challenge. That's why we've created a platform where members can share 
	their experiences and reviews of businesses, including information on accessibility, 
	customer service, and overall experience. By doing so, we hope to empower individuals with 
	disabilities to make informed decisions and feel confident when choosing where to shop, 
	dine, and access services.</p>

	<p class="about">In addition to our review platform, we offer a variety of resources to support individuals 
	with disabilities. Our resources include information on disability rights, accessibility 
	laws, and tips for navigating different environments.</p>

	<p class="about">At our website, we believe that everyone deserves access to the same opportunities and 
	experiences, regardless of their disability. We strive to create a community where people 
	with disabilities can come together to support each other and share valuable information. 
	Thank you for visiting our site, and we hope you find it helpful and informative!</p>
	
	<h2>Contact Us</h2>
	<!-- Displays form for contact request, disappears after successful contact submitted -->
	<?php if(!isset($_SESSION['confirmed'])) : ?>
	<form id="contact" class="form-container" action="submit_contact_form.php" method="POST">
		<label for="name">Name:</label>
		<input type="text" id="name" name="name" required>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" required>
	
		<label for="msg">Message:</label>
		<textarea id="msg" name="msg" rows="6" required></textarea>

		<?php if(isset($_SESSION['error'])){ echo "<p class=\"error\">".$_SESSION['error']."</p>"; unset($_SESSION['error']); } ?>

		<button type="submit">Submit</button>
	</form>
	<?php endif;?>

	<!-- Shows confirmation message after a succesful contact form submission -->
	<?php if(isset($_SESSION['confirmed'])) : ?>
		<div id="form_submitted">
			<h3 id="contact_thank">Thank you for reaching out. We will get back to you as soon as possible!</h3>
		</div>
		<?php unset($_SESSION['confirmed']);
	endif;
	?>

	
<?php include '../utilities/footer.php'; ?>