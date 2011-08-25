<?php

	if(isset($_POST['pass'])) {
		$pass = sha1($_POST['pass']);
		echo 'SHA1 kryptarat lösen är: '.$pass.'<br />';
	}
	echo '	<form action="" method="post">
					Lösen som ska krypteras <input type="text" name="pass" /><br />
					<input type="submit" value="Skicka" />
			</form>';