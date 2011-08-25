<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<link rel="stylesheet" href="css/jquery.mobile.css" />
<link rel="stylesheet" href="css/min.css" />
<script src="js/jquery-1.6.1.js"></script>
<script src="js/jquery-mobile.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/script.js"></script>
<script src="../js/error_mess.js"></script>
<title>XRSize.me Mobile</title>
</head>

<body>


<div data-role="page" id="login" data-theme="a">
    
  <div data-role="header">
     <h1>XRSize.me</h1>
  </div>
    
  <div data-role="content">
        
    <form id="frmLogin" method="post" action="#">
      <div data-role="fieldcontain">
        <label for="uname"><em>* </em> Användarnamn: </label>
          <input type="text" id="uname" name="uname" class="required user_name" />
      </div>
            
      <div data-role="fieldcontain">
        <label for="password"><em>* </em>Lösenord	: </label>
          <input type="password" id="password" name="password" class="required" />
      </div>
        <button id="login" data-role="button" type="submit" data-theme="b" >Logga in</button>
    </form>
        
  </div>
    
</div>

<div data-role="page" id="loginok" data-theme="a">
	<div data-role="header"><h1>XRSize.me</h1></div>
	<div data-role="content">
		<p>Inloggningen lyckades</p>
	</div>
</div>
</body>

</html> 


