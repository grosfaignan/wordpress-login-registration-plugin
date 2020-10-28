<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">



    <?php
	$label       = "";
	$error_class = "";
	if (isset($reg_errors) && ($reg_errors->get_error_message('username') || $reg_errors->get_error_message('username_invalid'))){
		$label       = " est incorrect";
		$error_class = "auth_errors";
	}
    ?>
    
    <label for="username" class="<?php echo $error_class; ?>"> Votre pseudo <?php echo $label;?> </label>
    <input type="text" required name="username" value=""/>


    <?php
	$label       = "";
	$error_class = "";
	if (isset($reg_errors) && $reg_errors->get_error_message('email_invalid')){
		$label       = " est invalide";
		$error_class = "auth_errors";
	}
    ?>
    <label for="email" class="<?php echo $error_class; ?>"> Votre email <?php echo $label;?></label>
    <input type="email" autocomplete ="email" required name="email" value=""/>

    <label for="password">Mot-de-passe </label>
    <input type="password" autocomplete ="new-password" required name="password" value="">

    <?php
	$label       = "Confirmez";
	$error_class = "";
	if (isset($reg_errors) && $reg_errors->get_error_message('pwd_error')){
		$label       = "Confirmation différente";
		$error_class = "auth_errors";
	}
    ?>
    <label for="password_2" class="<?php echo $error_class; ?>"><?php echo $label; ?> </label>
    <input type="password" autocomplete ="new-password" required name="password_2" value="">

    <input type="submit" name="register_submit" value="Register"/>
    
</form>