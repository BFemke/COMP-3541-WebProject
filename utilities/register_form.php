<!--
    Author: Barbara Emke
    Date:   July 6, 2023
   -->

    <!-- Popup form to login if not logged in -->
	<div class="form_popup" id="register_form">
		<form class="form-container" action="../utilities/register.php" method="post">
			<h3>Register</h3>

            <div class="field">
				<label for="firstName"><p>*First Name</p></label>
				<input type="text" name="firstName" id="firstName" required />
			</div>

            <div class="field">
				<label for="lastName"><p>*Last Name</p></label>
				<input type="text" name="lastName" id="lastName" required />
			</div>

			<div class="field">
				<label for="username"><p>*Username</p></label>
				<input type="text" name="username" id="username" required />
			</div>

            <div class="field">
				<label for="email"><p>Email</p></label>
				<input type="text" name="email" id="email" />
			</div>
			
			<div class="field">
				<label for="pass"><p>*Password</p></label>
				<input type="password" name="pass" id="pass" required />
			</div>
			<?php if(isset($_SESSION['register_error'])){ 
			echo "<script> document.getElementById(\"register_form\").style.display = \"block\"; </script>";
			echo "<p class=\"error\">".$_SESSION['register_error']."</p>";
			unset($_SESSION['register_error']); 
			} ?>  
			<div class="btns">
				<button type="submit" class="btn" id="register">Register</button>
				<button type="button" class="btn cancel" onclick="closeRegisterForm()">Cancel</button>
			</div>
            <p class="link"><a id="login_link" href="#">Login</a></p>
            <script>
				document.getElementById("login_link").addEventListener("click", function(event) {
					event.preventDefault(); // Prevent the default behavior of the link
					document.getElementById("login_form").style.display = "block";
					document.getElementById("register_form").style.display = "none";
				});
			</script>
		</form>
	</div>