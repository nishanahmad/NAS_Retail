<?php
	namespace Phppot;
	use \Phppot\Member;	
	require '../class/Member.php';
	
	$member = new Member();
    $memberResult = $member->getMemberById($_SESSION["userId"]);
    if(!empty($memberResult[0]["display_name"]))
        $displayName = ucwords($memberResult[0]["display_name"]);
	else
        $displayName = $memberResult[0]["user_name"];
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous"/>
<link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet"/>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/742221945b.js" crossorigin="anonymous"></script>
<style>
body{
	font-family: 'Ubuntu', sans-serif;
	overflow-x: hidden;
}
.main-brand{
	font-family:'GlacialIndifferenceRegular';
	font-weight:normal;
	font-style:normal;
	margin-left:20px;
}
.btn:hover {
  background-color: #343A40 !important;
}

.navbar-icon-top .navbar-nav .nav-link > .fa {
  position: relative;
  width: 36px;
  font-size: 20px;
}

.navbar-icon-top .navbar-nav .nav-link > .fa > .badge {
  font-size: 0.75rem;
  position: absolute;
  right: 0;
  font-family: sans-serif;
}

.navbar-icon-top .navbar-nav .nav-link > .fa {
  top: 3px;
  line-height: 12px;
}

.navbar-icon-top .navbar-nav .nav-link > .fa > .badge {
  top: -10px;
}

@media (min-width: 576px) {
  .navbar-icon-top.navbar-expand-sm .navbar-nav .nav-link {
	text-align: center;
	display: table-cell;
	height: 70px;
	vertical-align: middle;
	padding-top: 0;
	padding-bottom: 0;
  }

  .navbar-icon-top.navbar-expand-sm .navbar-nav .nav-link > .fa {
	display: block;
	width: 48px;
	margin: 2px auto 4px auto;
	top: 0;
	line-height: 24px;
  }

  .navbar-icon-top.navbar-expand-sm .navbar-nav .nav-link > .fa > .badge {
	top: -7px;
  }
}

@media (min-width: 768px) {
   #content-mobile{
	   display:none;
   }
  .navbar-icon-top.navbar-expand-md .navbar-nav .nav-link {
	text-align: center;
	display: table-cell;
	height: 70px;
	vertical-align: middle;
	padding-top: 0;
	padding-bottom: 0;
  }

  .navbar-icon-top.navbar-expand-md .navbar-nav .nav-link > .fa {
	display: block;
	width: 48px;
	margin: 2px auto 4px auto;
	top: 0;
	line-height: 24px;
  }

  .navbar-icon-top.navbar-expand-md .navbar-nav .nav-link > .fa > .badge {
	top: -7px;
  }
}

@media (max-width: 768px) {
   #content-desktop{
	   display:none;
   }
}

@media (min-width: 992px) {
  .navbar-icon-top.navbar-expand-lg .navbar-nav .nav-link {
	text-align: center;
	display: table-cell;
	height: 70px;
	vertical-align: middle;
	padding-top: 0;
	padding-bottom: 0;
  }

  .navbar-icon-top.navbar-expand-lg .navbar-nav .nav-link > .fa {
	display: block;
	width: 48px;
	margin: 2px auto 4px auto;
	top: 0;
	line-height: 24px;
  }

  .navbar-icon-top.navbar-expand-lg .navbar-nav .nav-link > .fa > .badge {
	top: -7px;
  }
}

@media (min-width: 1200px) {
  .navbar-icon-top.navbar-expand-xl .navbar-nav .nav-link {
	text-align: center;
	display: table-cell;
	height: 70px;
	vertical-align: middle;
	padding-top: 0;
	padding-bottom: 0;
  }

  .navbar-icon-top.navbar-expand-xl .navbar-nav .nav-link > .fa {
	display: block;
	width: 48px;
	margin: 2px auto 4px auto;
	top: 0;
	line-height: 24px;
  }

  .navbar-icon-top.navbar-expand-xl .navbar-nav .nav-link > .fa > .badge {
	top: -7px;
  }
}

.glow {
  color: #fff;
  text-align: center;
  -webkit-animation: glow 2s ease-in-out infinite alternate;
  -moz-animation: glow 2s ease-in-out infinite alternate;
  animation: glow 2s ease-in-out infinite alternate;
}

.glow-mobile {
  color: #B0E0E6;
  text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px white;
}

@-webkit-keyframes glow {
  from {
	text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px #e60073, 0 0 40px #e60073, 0 0 50px #e60073, 0 0 60px #e60073;
  }
  to {
	text-shadow: 0 0 20px #fff, 0 0 30px #ff4da6, 0 0 40px #ff4da6, 0 0 50px #ff4da6, 0 0 60px #ff4da6, 0 0 70px #ff4da6;
  }
}
a {
  color: inherit; /* blue colors for links too */
  text-decoration: inherit; /* no underline */
}
</style>
<nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark sticky-top top-nav" id="content-desktop">
  <a class="navbar-brand main-brand" href="#"><img src="images/logo.svg" height="50" width="160"></img></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	<div class="float-right" style="margin-left:90%;">	
		<ul class="navbar-nav mr-auto">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fa fa-user-circle"></i>
					<?php echo $displayName;?>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
				</div>
			</li>
		</ul>			
	</div>
  </div>
</nav>