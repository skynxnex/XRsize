<?php

	if(isset($_POST['pass'])) {
		$pass = sha1($_POST['pass']);
		echo 'SHA1 kryptarat l�sen �r: '.$pass.'<br />';
	}
	echo '	<form action="" method="post">
					L�sen som ska krypteras <input type="text" name="pass" /><br />
					<input type="submit" value="Skicka" />
			</form>';