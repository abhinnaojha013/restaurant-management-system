<?php

	include('lc.php');
	//variables decleration
	$un_flag = 0;#
	$mob_flag = 0;
	$em_flag = 0;
	$cn_flag = 0;
	$empty_flag = 0;
	$password_flag = 0;

//checking if sumbit button is pressed or not. if pressed, it will not be empty and will execure the PHP 
if(!empty($_POST['submit']))
{
	//checking if the values in form are empty or not
	if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['c_password']) || empty($_POST['mobile_no']) || empty($_POST['email']) || empty($_POST['house_no']) || empty($_POST['street']) || empty($_POST['ward_no']) || empty($_POST['card_no']) || empty($_POST['cvv_no']))
	{
		$empty_flag = 1;
	}
	//checking if password and confirm password values are same or not
	else if ($_POST['c_password'] != $_POST['password'])
	{
		$password_flag = 1;
	}
	//if both pws are same and no empty field is present
	else
	{		
		//creating connection ot the database
		$conn = mysqli_connect('localhost', 'r_new_customer', 'X0YTTtF3GTMvSpLR', 'restaurant');

		//storing query in a variable
		$query_select_unique_vefification = 'SELECT username, mobile_no, email, card_no FROM customers';

		//storing quer result in variable	
		$result = mysqli_query($conn, $query_select_unique_vefification);
		
		//feeding the result into readable and maniputable array
		$final_result = mysqli_fetch_all($result, MYSQLI_ASSOC);


		//unique username check
		foreach ($final_result as $un)
		{
			if ($un['username'] == $_POST['username'])
			{
				$un_flag = 1;
				break;		
			}
		}

		//unique mobile no check
		foreach ($final_result as $un)
		{
			if ($un['mobile_no'] == $_POST['mobile_no'])
			{
				$mob_flag = 1;
				break;		
			}
		}

		//unique email check
		foreach ($final_result as $un)
		{
			if ($un['email'] == $_POST['email'])
			{
				$em_flag = 1;
				break;		
			}
		}

		//unique card no check
		foreach ($final_result as $un)
		{
			if ($un['card_no'] == $_POST['card_no'])
			{
				$cn_flag = 1;
				break;		
			}
		}

		//freeing space tot avoid unnecessart retention of memory 
		mysqli_free_result($result);

		//checking if all values which need to be unique are unique
		if($un_flag == 0 && $em_flag == 0 && $mob_flag == 0 && $cn_flag == 0)
		{

			//encrypting password
			$h_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$h_card_no = password_hash($_POST['card_no'], PASSWORD_DEFAULT);
			$h_cvv = password_hash($_POST['cvv_no'], PASSWORD_DEFAULT);
			//creating a SQL writable form of all values in form
			$customer_id = mysqli_real_escape_string($conn, 'NULL');
			$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
			$middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
			$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
			$username = mysqli_real_escape_string($conn, $_POST['username']);
			$password = mysqli_real_escape_string($conn, $h_password);
			$mobile_no = mysqli_real_escape_string($conn, $_POST['mobile_no']);
			$house_no = mysqli_real_escape_string($conn, $_POST['house_no']);
			$street = mysqli_real_escape_string($conn, $_POST['street']);
			$district = mysqli_real_escape_string($conn, $_POST['district']);
			$ward_no = mysqli_real_escape_string($conn, $_POST['ward_no']);
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$card_no = mysqli_real_escape_string($conn, $h_card_no);
			$cvv_no = mysqli_real_escape_string($conn, $h_cvv);
			$bank = mysqli_real_escape_string($conn, $_POST['bank']);
			$exp_year = mysqli_real_escape_string($conn, $_POST['exp_year']);
			$exp_month = mysqli_real_escape_string($conn, $_POST['exp_month']);
			$card_type = mysqli_real_escape_string($conn, $_POST['card_type']);
			$booking_status = mysqli_real_escape_string($conn, 0);
			$order_status = mysqli_real_escape_string($conn, 0);

			//storing quere in variable
			$query_insert_new_user = "INSERT INTO customers(customer_id, first_name, middle_name, last_name, username, password, mobile_no, house_no, street, district, ward_no, email, card_no, cvv_no, bank, exp_year, exp_month, card_type, booking_status, order_status) 
			VALUES ($customer_id, '$first_name', '$middle_name', '$last_name','$username', '$password', '$mobile_no', '$house_no', '$street', '$district', '$ward_no', '$email', '$card_no', '$cvv_no', '$bank', '$exp_year', '$exp_month', '$card_type', $booking_status, $order_status)";

			//checking sussessful execution of query and providing message ro user
			if(mysqli_query($conn, $query_insert_new_user))
				{
					echo "<script>alert('Successfully created new account, login to continue')</script>";
				}

		}
		//closing SQL connection
		mysqli_close($conn);
	}

}

?>
<!--------------------------------------------------------------------------------------------------------------->
<!--HTML starts-->


<!DOCTYPE html>
<html>
	<!-- This is the Head-->
	<head>
	 	<!-- title of the page-->
		<title>Sign up</title>

		<meta charset="utf-8">
		
		<!--CSS section-->
		<link rel="stylesheet" type="text/css" href="scss/style.css">
	
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
					<a href="login.php">
						Login
					</a>
				</div>
			</div>

			<div class="break">
			</div>
			<div class="margin margin-vert1">
			</div>
		</div>



		<form action="signup.php" method="post">
			<div class="flexbox">
				<div class="margin margin-vert1">
				</div>
				<div class="break">
				</div>


				<div class="centre centre-vert centre-lr">
					<h2>Enter Details:</h2>
				</div>

				<div class="break">
				</div>

				<div class="warning centre centre-lr centre-text">
					<?php
						if($empty_flag == 1)
						{
							echo "At least one of the field is missing";
						}
					?>
				</div>

				<div class="break">
				</div>
				<div class="margin margin-vert1">
				</div>
				<div class="break">
				</div>

				<div class="centre centre-left">
					<input type="text" placeholder="First name" name="first_name" maxlength="20">
				</div>

				<div class="margin margin-mid1">
				</div>
				
				<div class="">
					<input type="text" placeholder="Middle name(s)" name="middle_name" maxlength="50">
				</div>
	
				<div class="margin margin-mid1">
				</div>
				
				<div class="centre centre-right">
					<input type="text" placeholder="Last name" name="last_name" maxlength="50">
				</div>

				<div class="break">
				</div>				
				<div class="margin margin-vert1">
				</div>
				<div class="break">
				</div>

				<div class="centre centre-left">
					<input type="text" placeholder="Username" name="username" minlength="8" maxlength="23">
				</div>

				<div class="margin margin-mid1">
				</div>
				
				<div class="">
					<input type="password" placeholder="Password" name="password" minlength="10" maxlength="25">
				</div>

				<div class="margin margin-mid1">
				</div>
				
				<div class="centre centre-right">
					<input type="password" placeholder="Confirm password" name="c_password" minlength="10" maxlength="25">
				</div>

				<div class="break">
				</div>
				<div class="margin margin-vert1">
				</div>
				<div class="break">
				</div>

				
				<?php
					if($un_flag == 1)
					{
						$d= '<div class="warning centre centre-text centre-lr">
							Username already exists
							</div>
							<div class="break">
							</div>
							<div class="margin margin-vert1">
							</div>
							<div class="break">
							</div>';
						echo $d;
					}
				?>
				

				<?php
					if($password_flag == 1)
					{
						$d= '<div class="warning centre centre-text centre-lr">
							Passwords do not match
							</div>
							<div class="break">
							</div>
							<div class="margin margin-vert1">
							</div>
							<div class="break">
							</div>';
						echo $d;
					}
				?>
	

				

				<div class="centre centre-left">
					<input type="Number" placeholder="Mobile no" name="mobile_no" min="9800000000" max="9899999999">
				</div>

				<div class="margin margin-mid1">
				</div>

				<div class="">
					<input type="Email" placeholder="E-mail" name="email">
				</div>

				<div class="margin margin-mid1">
				</div>

				<div class="">
					<input type="Number" placeholder="Card No" name="card_no" min="1000000000000000" max="999999999999999999">
				</div>

				<div class="margin margin-mid1">
				</div>

				<div class="centre centre-right width width-num7">
					<input type="Number" placeholder="CVV No" name="cvv_no" min="000" max="999">
				</div>

				<div class="break">
				</div>
				<div class="margin margin-vert1">
				</div>
				<div class="break">
				</div>

				<?php
					if($mob_flag == 1)
					{
						$d= '<div class="warning centre centre-text centre-lr">
							Mobile number already exists
							</div>
							<div class="break">
							</div>
							<div class="margin margin-vert1">
							</div>
							<div class="break">
							</div>';
						echo $d;
					}
				?>



				<?php
					if($em_flag == 1)
					{
						$d= '<div class="warning centre centre-text centre-lr">
							Email already exists
							</div>
							<div class="break">
							</div>
							<div class="margin margin-vert1">
							</div>
							<div class="break">
							</div>';
						echo $d;
					}
				?>

					<?php
						if($cn_flag == 1)
						{
							$d= '<div class="warning centre centre-text centre-lr">
								Card already exists
								</div>
								<div class="break">
								</div>
								<div class="margin margin-vert1">
								</div>
								<div class="break">
								</div>';
							echo $d;
						}
					?>


				<div class="centre centre-left">
					<label for="exp_year">Expiry Date:</label>
				</div>

				<div class="margin margin-mid4px">
				</div>

				<div class="">
					<select name="exp_year" id="exp_year">
						<option value="2022">2020</option>
						<option value="2023">2021</option>
						<option value="2024">2022</option>
						<option value="2025">2023</option>
						<option value="2026">2024</option>
					</select>
					/
					<select name="exp_month">
						<option value="1">01</option>
						<option value="2">02</option>
						<option value="3">03</option>
						<option value="4">04</option>
						<option value="5">05</option>
						<option value="6">06</option>
						<option value="7">07</option>
						<option value="8">08</option>
						<option value="9">09</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
					</select>
				</div>

				<div class="margin margin-mid1">
				</div>

				<div class="">
					<label for="bank">Issuer Bank:</label>
				</div>

				<div class="margin margin-mid4px">
				</div>

				<div class="">
					<select name="bank" id="bank">
						<option value="1">NIC Asia Bank</option>
						<option value="2">Nepal Bank</option>
						<option value="3">Nabil Bank</option>
						<option value="4">Machhapuchhre Bank</option>
						<option value="5">Standard Chartered Bank</option>
						<option value="6">Nepal SBI Bank</option>
						<option value="7">Nepal Bangladesh Bank</option>
					</select>
				</div>

				<div class="margin margin-mid1">
				</div>

				<div class="">
					<label for="card_type">Card Type:</label>
				</div>

				<div class="margin margin-mid4px">
				</div>

				<div class="centre centre-right">
					<select name="card_type" id="card_type">
						<option value="1">Credit</option>
						<option value="2">Debit</option>
						<option value="3">VISA</option>
						<option value="4">Mastercard</option>
						<option value="5">Payoneer</option>
					</select>
				</div>
					
				<div class="break">
				</div>
				<div class="margin margin-vert1">
				</div>
				<div class="break">
				</div>


				<div class="centre centre-left width width-num7">
					<input type="Number" placeholder="House no" name="house_no" min="001" max="999">
				</div>

				<div class="margin margin-mid1">
				</div>

				<div class="">
					<input type="text" placeholder="Street" name="street">
				</div>

				<div class="margin margin-mid1">
				</div>

				<div class="">
					<label for="district">District:</label>
				</div>

				<div class="margin margin-mid4px">
				</div>
				
				<div class="">
					<select name="district" id="district">
						<option value="0">Kathmandu</option>
						<option value="1">Bhaktapur</option>
						<option value="2">Lalitpur</option>
					</select>
				</div>

				<div class="margin margin-mid1">
				</div>

				<div class="centre centre-right width width-num7">
					<input type="Number" placeholder="Ward No" name="ward_no" min="01" max="32">
				</div>
				
				<div class="break">
				</div>

				<div class="centre centre-lr button">
					<input type="submit" name="submit" value="Signup">
				</div>
			</div>	
		</form>
	</body>
</html>