<?php
	
?>


<!DOCTYPE html>
<html>
	<head>
		<title>sondbox</title>

		<link rel="stylesheet" type="text/css" href="scss/style.css">
	
	</head>

	<body>
		






		<div class="flexbox">

            <div class="centre centre-lr width width-40per">
				<form action="sandbox.php" method="POST">
						<div class="warning">	
							<?php
								if($empty == 1)
								{
									$p= '<p class="margin margin-vert1 centre centre-lr">
											At least one field is empty
										</p>';
									echo $p;
								}
								else if($dt_old == 1)
								{
									$p= '<p class="margin margin-vert1 centre centre-lr">
											Reservation must be made at least 3 hours before.";
										</p>';
									echo $p;
								}
								else if($wait_st == 0)
								{
									$p= '<p class="margin margin-vert1 centre centre-lr">
											All waiters are reserved, sorry for the inconvinience";
										</p>';
									echo $p;
								}
								else if($tab_st == 0)
								{
								$p= '<p class="margin margin-vert1 centre centre-lr">	
										All tables are reserved, sorry for the inconvinience";
									</p>';
									echo $p;
								}
								
							?>
						</div>

						<div class="break"></div>
						
						<div class="centre centre-left">
							<label for="res_dt">Reservation date and time:</label>
							<br>
							<input type="datetime-local" name="res_dt" id="res_dt">
								
						</div>

						<div class="margin margin-vert3">
						</div>
						
						<div class="centre centre-lr">
							<label for="res_dur">Reservation duration (30 minutes to 120 minutes):</label>
							<br>
							<input type="number" name="res_dur" min="30" max="120">
							
						</div>

						<div class="break"></div>

						<div class="centre centre-lr button">
							<input type="submit" name="book" value="Book">
						</div>
				</form>
            </div>
            










            <div class="centre centre-right width width-40per">
                <div style="width: 100%; text-align:center">
					<div style="color: red; font-size: 22px; margin-bottom: 20px;">
					<?php
						if($qty_flag == 0)
						{
							echo "Quantity cannot be empty.";
						}
					?>
					</div>

					
					
					<form action="sandbox.php" method="POST">
						<select name="menu">
							<?php
								$select_menu = 'SELECT menu_id, item_name, selling_price FROM menu_item';
								$result_select = mysqli_query($conn, $select_menu);
								$final_select = mysqli_fetch_all($result_select, MYSQLI_ASSOC);

								foreach($result_select as $menu_item)
								{
									$it_name = $menu_item['item_name'];
									$m_i = $menu_item['menu_id'];
									$sp = $menu_item['selling_price'];
									$x1 = '<option value="';
									$x2 = '">';
									$x3 = '</option>';
									
									echo $x1;
									echo $m_i;
									echo $x2;
									echo $it_name;
									echo " : Rs. ";
									echo $sp;
									echo $x3;
								}
							
							
								
							?>

								

							
							<input type="number" name="quantity" placeholder="qty" min=1 max=5>
							<div>
								<input type="submit" value="Add" name="add" id="submit_button_login" style="margin-top: 20px;">
							</div>
						</select>				
					

						<div style="color: green; font-size: 20px; margin-top: 30px;">
							<?php

								echo "<u>Current Orders</u><br>";
								$counter = 0;
								
								$select_order_items = "SELECT order_items.menu_id, order_items.amount_ordered, menu_item.item_name
														from order_items
														JOIN menu_item on order_items.menu_id=menu_item.menu_id
														WHERE order_id = $oid
														ORDER BY order_items.menu_id";
								$result_select = mysqli_query($conn, $select_order_items);
								$final_select = mysqli_fetch_all($result_select, MYSQLI_ASSOC);

								foreach($final_select as $fs)
								{
									$submit_delete = '<input type="submit" value="Remove 1" name="delete'. $fs['menu_id'] .'" style = "font-size: 14px; cursor:pointer ">';
									echo $fs['item_name'] . ' : ' . $fs['amount_ordered'] . " plates." . "\t" . $submit_delete . '<br>' ;
									$counter ++;
								}
								if($counter == 0)
								{
									echo "None.<br>";
								}
							
							?>						
						</div>
						
						<div>
							<input type="submit" value="Confirm Orders" name="pay" id="submit_button_login" style="margin-top: 20px;">
						</div>
					</form>
				</div>
            </div>
        </div>

















	</body>

</html>