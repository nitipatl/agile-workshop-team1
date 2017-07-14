<!doctype html>
<html>
<head>
<link href="css/bootstrap.css" rel="stylesheet">
<meta charset="windows-874">
<link rel="stylesheet" type="text/css" href="css/login.css">
<title>login</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <div class="account-wall">
                <img class="profile-img" src="images/logo.png"
                    alt="">
                <form action="css/CheckLogin.php" method="post" class="form-signin">
                <input type="text" class="form-control" placeholder="Username" name="user" >
                <input type="password" class="form-control" placeholder="Password" name="password">
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Log in</button>
                <span class="clearfix"></span>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>