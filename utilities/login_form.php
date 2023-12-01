<!--
    Author: Barbara Emke
    Date:   July 6, 2023
   -->

    <!-- Popup form to login if not logged in -->
	<div class="form_popup" id="login_form">
		<form class="form-container" action="../utilities/login.php" method="post">
			<h3>Login</h3>
			<p>To add a resource or review you must be logged in.</p>

			<div class="field">
				<label for="username"><p>Username</p></label>
				<input type="text" name="username" id="username" required />
			</div>
			
			<div class="field">
				<label for="pass"><p>Password</p></label>
				<input type="password" name="pass" id="pass" required />
			</div>
			<?php if(isset($_SESSION['login_error'])){ 
			echo "<script> document.getElementById(\"login_form\").style.display = \"block\"; </script>";
			echo "<p class=\"error\">".$_SESSION['login_error']."</p>";
			unset($_SESSION['login_error']); 
			} ?>   
			<div class="btns">
				<button type="submit" class="btn" id="login">Login</button>
				<button type="button" class="btn cancel" onclick="closeLoginForm()">Cancel</button>
			</div>
			<p class="link"><a id="register_link" href="#">Register</a></p>
			<script>
				document.getElementById("register_link").addEventListener("click", function(event) {
					event.preventDefault(); // Prevent the default behavior of the link
					document.getElementById("login_form").style.display = "none";
					document.getElementById("register_form").style.display = "block";
				});
			</script>
		</form>
	</div>