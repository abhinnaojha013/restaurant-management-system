<?php
include('lc.php');
$empty_flag = 0;
$login_flag = -1;

if (!empty($_POST['submit']))
{
	$conn = mysqli_connect('localhost', 'r_new_customer', 'X0YTTtF3GTMvSpLR', 'restaurant');

	$query_login_vefification = 'SELECT username, password, customer_id FROM customers';

	$result = mysqli_query($conn, $query_login_vefification);

	$final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);


	if(empty($_POST['username']) || empty($_POST['password']))
	{
		$empty_flag = 1;
	}
	else
	{
		$login_flag = 0;
		foreach ($final_result as $login)
		{
			if (($login['username'] == $_POST['username']) && password_verify($_POST['password'],$login['password']))
			{					
				$login_flag = 1;
				
				setcookie('login', $login['username'], time() + 86400 * 3);
				setcookie('cid', $login['customer_id'], time() + 86400 * 3);
				
				
				break;
			}
		}
	}
}
?>


<!DOCTYPE html>
<html>
	<!-- This is the Head-->
	<head>
	 	<!-- title of the page-->
		<title>Login</title>

		<meta charset="utf-8">
		
		<!--CSS section-->
		<link rel="sty lesheet" href="scss/style.css">
	
	</head>

	<!-- Body starts here -->
	<body>
		<div class="flexbox headerimage">
			<div class="margin margin-vert1">
			</div>
			<div class="break">
			</div>

			<div class="flexbox centre centre-left centre-vert">
				<a href="index.php">
					<div class="logoimage">

					</div>
				</a>	
			</div>
			
			<div class="flexbox restaurant_name centre centre-lr centre-vert">
				<h1 class="centre">
					<a href="index.php">	
						RESTAURANT
					</a>
				</h1>
			</div>
			
			<div class="flexbox centre centre-right centre-vert">				
				<div class="button">
					<a href="signup.php">
						Signup
					</a>
				</div>
			</div>

			<div class="break">
			</div>
			<div class="margin margin-vert1">
			</div>
		</div>



		
		<div class="margin margin-vert3">
		</div>
		<div class="margin margin-vert3">
		</div>

		<div class="break">
		</div>

		<form action="login.php" method="POST">
			
			<div class="flexbox">
				
				<div class="centre centre-left centre-vert" style="width:10%;">
				</div>

				<div class="margin margin-mid1">
				</div>

				<div class="warning centre-right centre-vert centre-text">
					<?php
						if($empty_flag == 1)
						{
							echo "At least one of the field is missing<br>";
						}
						else if($login_flag == 0)
						{
							echo "Username or Password incorrect<br>";
						}
						else if($login_flag == 1)
						{
							
							header('Location: members.php');
						}

					?>
				</div>
				
				<div class="break">
				</div>

				<div class="margin margin-vert1">
				</div>

				<div class="centre centre-left centre-vert" style="width:10%;">
					<label for="username">Username: </label>
				</div>

				<div class="margin margin-mid1">
				</div>

				<div class="centre centre-right centre-vert">
					<input type="textbox" name="username" id="username">
						
				</div>

				<div class="break">
				</div>

				<div class="centre centre-left centre-vert" style="width:10%;">
					<label for="password">Password: </label>
				</div>

				<div class="margin margin-mid1">
				</div>
				
				<div class="centre centre-right centre-vert">
					<input type="password" name="password" id="password">
				</div>

				<div class="break"></div>

				<div class="centre centre-left centre-vert" style="width:10%;">
				</div>
				<div class="center centre-right centre-vert button">
					<input type="submit" name="submit" value="Login">
				</div>
			</div>
		</form>
	</body>

</html>