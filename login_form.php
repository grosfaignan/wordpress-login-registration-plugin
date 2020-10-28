

<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">


<?php
	$label       = "";
	$error_class = "";
	if (isset($reg_errors) && $reg_errors->get_error_message('invalid_username')) {
		$label       = " est incorrect";
		$error_class = "auth_errors";
	}
?>
<label for="user_login" class="<?php echo $error_class; ?>">votre login <?php echo $label; ?></label>
<input type="text" autocomplete ="username" required name="user_login" id="user_login" value ="<?php echo (isset($_POST['user_login'])) ? $username : null; ?>"/>


<?php
	$label       = "";
	$error_class = "";
	if (isset($reg_errors) && $reg_errors->get_error_message('incorrect_password')) {
		$label       = " est incorrect";
		$error_class = "auth_errors";
	}
?>
<label for="user_password" class="<?php echo $error_class; ?>" >votre mot de passe<?php echo $label; ?></label>
<input type="password" autocomplete="current-password" required name="user_password" id="user_password" value="<?php echo (isset($_POST['user_password'])) ? $username : null; ?>"/>


<input type="checkbox" name="rememberme" id="login_rememberme"/>
<label for="rememberme" value="forever">se souvenir de moi</label>

<!-- <input type="hidden" name="login"/> -->

<input type="submit" name="login_submit" value="Se Connecter">
</form>