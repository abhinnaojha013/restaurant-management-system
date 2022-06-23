<?php

    if(isset($_POST['logout']))
    {
        setcookie('login');
        header('Location: index.php');
    }
    
    date_default_timezone_set("Asia/Kathmandu");

    $tot_charge = 0;
    $bc = 0;
    $wn = '0';
    $tn = '0';
    $bs = 0;
    $bd = 0;
    $wid = 0;
    $bdt = 0;
    $c_f = 0;
    $dt_old = 0;
    $empty = 0;
    $wait_st = -1;
    $tab_st = -1;  
    $tr = 0;
    $cid = $_COOKIE['cid'];
    $oid = -1;
    $bid = 0;
    $pid = 0; 
    $o_s = 0;
    $qty_flag = 1;
    $match_flag = 0;

    $conn = mysqli_connect('localhost', 'r_new_customer', 'X0YTTtF3GTMvSpLR', 'restaurant');

    if(!empty($_POST['book']))
    {

        if(empty($_POST['res_dt']) || empty($_POST['res_dur']))
        {
            $empty = 1;
        }
        else if(strtotime($_POST['res_dt']) < strtotime(date("YmdHi")) + 10800)
        {
            $dt_old = 1;
        }
        else
        {
            $wait_st = 0;
            $tab_st = 0;
                        
            $query_select_waiter = 'SELECT waiter_id, name, waiter_status FROM waiters';
            $query_select_table = 'SELECT table_no, rate, table_status FROM tables';
            
            $result_waiter = mysqli_query($conn, $query_select_waiter);
            $result_table = mysqli_query($conn, $query_select_table);
            
            
            $final_waiter = mysqli_fetch_all($result_waiter, MYSQLI_ASSOC);
            $final_table = mysqli_fetch_all($result_table, MYSQLI_ASSOC);

            foreach ($final_waiter as $wait)
            {
                if ($wait['waiter_status'] == 0)
                {
                    $wait_st = 1;
                    $wn = $wait['waiter_id'];
                    break;		
                }					
            }

            foreach ($final_table as $tab)
            {
                if ($tab['table_status'] == 0)
                {
                    $tab_st = 1;
                    $tn = $tab['table_no'];
                    $tr = $tab['rate'];
                    break;		
                }
            }

            if($wait_st == 1 && $tab_st == 1)
            {
                $bc = $tr * $_POST['res_dur'];
                $pn = 0;

                $bid = date("YmdHis", time()) * 10000 + $cid;

                $booking_id = mysqli_real_escape_string($conn, $bid);
                $customer_id = mysqli_real_escape_string($conn, $_COOKIE['cid']);
                $table_no = mysqli_real_escape_string($conn, $tn);
                $booking_dt = mysqli_real_escape_string($conn, strtotime($_POST['res_dt']));
                $duration = mysqli_real_escape_string($conn, $_POST['res_dur'] * 100);
                $booking_charge = mysqli_real_escape_string($conn, $bc);
                $waiter_id = mysqli_real_escape_string($conn, $wn);
                $payment_id = mysqli_real_escape_string($conn, $pn);

                $insert_query = "INSERT INTO bookings (booking_id, customer_id, table_no, booking_dt, duration, booking_charge, waiter_id, payment_id)
                VALUES ($booking_id, $customer_id, $table_no, $booking_dt, $duration, $booking_charge, $waiter_id, $payment_id)";

                $update_waiter = "UPDATE waiters SET waiter_status = 1 WHERE waiter_id = $wn";
                $update_table = "UPDATE tables SET table_status = 1 WHERE table_no = $wn";
                $update_customer = "UPDATE customers SET booking_status = 1 WHERE customer_id = $cid";

                if(mysqli_query($conn, $insert_query))
                {
                    mysqli_query($conn, $update_waiter);
                    mysqli_query($conn, $update_table);
                    mysqli_query($conn, $update_customer);
                }

                $bs = 1;
            }
        }
    }

    if(isset($_POST['pay']))
    {
        
        $select_charge = "SELECT booking_charge, table_no, waiter_id FROM bookings WHERE customer_id = $cid AND payment_id = 0";

        $result_booking = mysqli_query($conn, $select_charge);
        $final_res_book = mysqli_fetch_all($result_booking, MYSQLI_ASSOC);
        
        $bc;
        $wn;
        $tn = 0;
        $wid = 0;
        foreach($final_res_book as $b_c)
        {
            $bc = $b_c['booking_charge'];
            $tn = $b_c['table_no'];
            $wid = $b_c['waiter_id'];    
        }
        
        $tot_charge += $bc;

        date_default_timezone_set("Asia/Kathmandu");
        $pid = date("YmdHis", time()) * 10000 + $cid;
        $payment_timestamp = mysqli_real_escape_string($conn, 'NULL');

        $insert_payment = "INSERT INTO payments(payment_id, amount, payment_timestamp) VALUES ($pid, $tot_charge, $payment_timestamp)";
        $update_booking = "UPDATE bookings SET payment_id = $pid WHERE customer_id = $cid AND payment_id = 0";
        $update_order = "UPDATE orders SET payment_id = $pid WHERE customer_id = $cid AND payment_id = 0";        
        $update_waiter = "UPDATE waiters SET waiter_status = 0 WHERE waiter_id = $wid";
        $update_table = "UPDATE tables SET table_status = 0 WHERE table_no = $tn";
        $update_customer = "UPDATE customers SET booking_status = 0, order_status = 0 WHERE customer_id = $cid";

        mysqli_query($conn, $insert_payment);
        mysqli_query($conn, $update_booking);
        mysqli_query($conn, $update_order);
        mysqli_query($conn, $update_waiter);
        mysqli_query($conn, $update_table);
        mysqli_query($conn, $update_customer);

        $bs = 0;
        $o_s = 0;

    }
 
    $select_cust = 'SELECT customer_id, order_status, booking_status FROM customers';
    $result_cust = mysqli_query($conn, $select_cust);
    $final_cust = mysqli_fetch_all($result_cust, MYSQLI_ASSOC);

    foreach($final_cust as $cust)
    {
        if($cust['customer_id'] == $_COOKIE['cid'] && $cust['booking_status'] == 1)
        {
            $bs = 1;
            $select_charge = "SELECT booking_id, booking_dt, bookings.booking_charge, bookings.table_no, bookings.waiter_id, waiters.name
                                FROM bookings
                                JOIN waiters ON bookings.waiter_id = waiters.waiter_id 
                                WHERE customer_id = $cid AND payment_id = 0";
            $result_booking = mysqli_query($conn, $select_charge);
            $final_res_book = mysqli_fetch_all($result_booking, MYSQLI_ASSOC);
            
            foreach($final_res_book as $b_c)
            {
                $bid = $b_c['booking_id'];
                $bdt = $b_c['booking_dt'];
                $bc = $b_c['booking_charge'];
                $tn = $b_c['table_no'];
                $wn = $b_c['name'];  
                $wid = $b_c['waiter_id'];  
            }

            if(isset($_POST['cancel_booking']))
            {
                $del_book = "DELETE FROM bookings WHERE booking_id = $bid";
                $update_customer = "UPDATE customers SET booking_status = 0 WHERE customer_id = $cid";
                $update_waiter = "UPDATE waiters SET waiter_status = 0 WHERE waiter_id = $wid";
                $update_table = "UPDATE tables SET table_status = 0 WHERE table_no = $tn";
                
                mysqli_query($conn, $del_book);
                mysqli_query($conn, $update_customer);
                mysqli_query($conn, $update_waiter);
                mysqli_query($conn, $update_table);

                
                $bs = 0;
            }
        }
    }

    foreach($final_cust as $cust)
    {
        if($cust['customer_id'] == $_COOKIE['cid'] && $cust['order_status'] == 1)
        {
            $o_s = 1;
            
            $select_oid = 'SELECT order_id, customer_id, payment_id FROM orders';
            $result_oid = mysqli_query($conn, $select_oid);
            $final_oid = mysqli_fetch_all($result_oid, MYSQLI_ASSOC);

            foreach($final_oid as $f_oid)
            {
                if($f_oid['customer_id'] == $cid && $f_oid['payment_id'] == 0)
                {
                    $oid = $f_oid['order_id'];
                    break;
                }
            }

            $counter = 0;
                
            $select_order_items = "SELECT order_items.menu_id, order_items.amount_ordered, menu_item.item_name, menu_item.selling_price
                                    from order_items
                                    JOIN menu_item on order_items.menu_id=menu_item.menu_id
                                    WHERE order_id = $oid
                                    ORDER BY order_items.menu_id";
            $result_select = mysqli_query($conn, $select_order_items);
            $final_select = mysqli_fetch_all($result_select, MYSQLI_ASSOC);
            
            foreach($final_select as $fs)
            {
                $tot_charge += $fs['amount_ordered'] * $fs['selling_price'];
                $counter ++;
            }
        
        }
    }
   

    

    if(isset($_POST['add']))
    {
        if(empty($_POST['quantity']))
        {
            $qty_flag = 0;
        }
        else
        {
            if($o_s == 0)
            {
                $z = 0;

                $oid = date("YmdHis", time()) * 10000 + $cid;

                $order_id = mysqli_real_escape_string($conn, $oid);
                $order_date = mysqli_real_escape_string($conn, 'NULL');
                $customer_id = mysqli_real_escape_string($conn, $_COOKIE['cid']);
                $payment_id = mysqli_real_escape_string($conn, $z);

                $insert_order = "INSERT INTO orders(order_id, order_date, customer_id, payment_id)
                VALUES($order_id, $order_date, $customer_id, $payment_id)";

                mysqli_query($conn, $insert_order);

                
                $select_order_id = "SELECT order_id, customer_id, payment_id FROM orders";
                $result_order_id = mysqli_query($conn, $select_order_id);
                $final_order_id = mysqli_fetch_all($result_order_id, MYSQLI_ASSOC);

                foreach($final_order_id as $f_order_id)
                {
                    if($f_order_id['customer_id'] == $cid && $f_order_id['payment_id'] == 0)
                    {
                        $oid = $f_order_id['order_id'];
                    }
                }

                $item_id = mysqli_real_escape_string($conn, 'NULL');
                $menu_id = mysqli_real_escape_string($conn, $_POST['menu']);
                $order_id = mysqli_real_escape_string($conn, $oid);
                $amount_ordered = mysqli_real_escape_string($conn, $_POST['quantity']);
                
                $insert_item = "INSERT INTO order_items(item_id, menu_id, order_id, amount_ordered)
                VALUES($item_id, $menu_id, $order_id, $amount_ordered)";

                mysqli_query($conn, $insert_item);

        
                $update_customer = "UPDATE customers SET order_status = 1 WHERE customer_id = $cid";

                mysqli_query($conn, $update_customer);
                $o_s = 1;
            }
            else
            {
                $select_item = "SELECT menu_id, amount_ordered FROM order_items WHERE order_id = $oid";
                $result_select_item = mysqli_query($conn, $select_item);
                $final_select_item = mysqli_fetch_all($result_select_item, MYSQLI_ASSOC);
                
                $qty_input = $_POST['quantity'];
                $menu_input = $_POST['menu'];

                foreach($final_select_item as $f_sel_it)
                {
                    if($menu_input == $f_sel_it['menu_id'])
                    {
                        $amt_there = $f_sel_it['amount_ordered'];
                        $match_flag = 1;
                        break;
                    } 
            
                }

                if($match_flag == 1)
                {
                    $amt_tot = $amt_there + $qty_input;

                    $amount_ordered = mysqli_real_escape_string($conn, $amt_tot);

                    $update_order_item = "UPDATE order_items SET amount_ordered = $amount_ordered WHERE order_id = $oid AND menu_id = $menu_input";

                    mysqli_query($conn, $update_order_item);
                }
                else
                {
                    $item_id = mysqli_real_escape_string($conn, 'NULL');
                    $menu_id = mysqli_real_escape_string($conn, $_POST['menu']);
                    $order_id = mysqli_real_escape_string($conn, $oid);
                    $amount_ordered = mysqli_real_escape_string($conn, $_POST['quantity']);
                    
                    $insert_item = "INSERT INTO order_items(item_id, menu_id, order_id, amount_ordered)
                    VALUES($item_id, $menu_id, $order_id, $amount_ordered)";

                    mysqli_query($conn, $insert_item);
                }
            }
        }
    }

    $counter = 0;

    $select_menu_items = "SELECT menu_id
                            from menu_item";
    $result_select = mysqli_query($conn, $select_menu_items);
    $final_select = mysqli_fetch_all($result_select, MYSQLI_ASSOC);;
    foreach($final_select as $fs)
    {
        $counter ++;
    }

    for($i = 1; $i <= $counter; $i++)
    {
        $del = 'delete'.$i;
        if(isset($_POST[$del]))
        {	
            $select_item = "SELECT menu_id, amount_ordered FROM order_items WHERE order_id = $oid";
            $result_select_item = mysqli_query($conn, $select_item);
            $final_select_item = mysqli_fetch_all($result_select_item, MYSQLI_ASSOC);

            foreach($final_select_item as $f_sel_it)
            {
                if($i == $f_sel_it['menu_id'])
                {
                    $amt_there = $f_sel_it['amount_ordered'];
                    $match_flag;
                    break;
                } 
        
            }
            $amt_tot = $amt_there - 1;
            $amount_ordered = mysqli_real_escape_string($conn, $amt_tot);
            $update_order_item = "UPDATE order_items SET amount_ordered = $amount_ordered WHERE order_id = $oid AND menu_id = $i";
            mysqli_query($conn, $update_order_item);

            $delete_query = "DELETE FROM order_items WHERE amount_ordered = 0";
            mysqli_query($conn, $delete_query);

            $sel_empty_orders = "SELECT order_id FROM order_items WHERE order_id IN 
                                (SELECT order_id FROM orders WHERE customer_id = $cid AND payment_id = 0)";

            $result_sel_e_ord = mysqli_query($conn, $sel_empty_orders);
            $final_s_e_o = mysqli_fetch_all($result_sel_e_ord, MYSQLI_ASSOC);

            $count = 0;
            foreach($final_s_e_o as $fseo)
            {
                $oid = $fseo['order_id'];
                $count++;
            }

            if($count == 0)
            {
                $delete_old = "DELETE FROM orders WHERE order_id = $oid";
                $update_customer = "UPDATE customers SET order_status = 0 WHERE customer_id = $cid";
                mysqli_query($conn, $delete_old);
                mysqli_query($conn, $update_customer);
                $o_s = 0;
            }
        }
    }

    if($o_s == 0 && $bs == 0)
    {
        $c_f = 0;
    }
    else
    {
        $c_f = 1;
    }
?>


<!DOCTYPE html>
<html>
	<!-- This is the Head-->
	<head>
	 	<!-- title of the page-->
		<title>Members Area</title>

		<meta charset="utf-8">
		
		<!--CSS section-->
		<link rel="stylesheet" type="text/css" href="scss/style.css">
	
	</head>

	<!-- Body starts here -->
	<body>
        <form action="members.php" method="POST">
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
                        <input type="submit" value="Logout" name="logout">
                    </div>
                </div>

                <div class="break">
                </div>
                <div class="margin margin-vert1">
                </div>
            </div>

            <div class="break">
            </div>
            <div class="margin margin-vert3">
            </div>
            <div class="break">
            </div>


            <?php
                if($bs == 0)
                {
                    echo "<script>var bs = 0;</script>";
                }
                else
                {
                    echo "<script>var bs = 1;</script>";
                }

                if($c_f == 1)
                {
                    echo '<script>var c_f = 1;</script>';
                }
                else
                {
                    echo '<script>var c_f = 0;</script>';
                }
            ?>
            <div class="flexbox">
                <div style="width: 20%;"></div>
                <div style="width: 30%;">
                    <div class="flexbox centre centre-lr width width-box">
                        
                    
                        <div class="flexbox centre centre-lr centre-text" id="booked_yes">
                        
                            <div class="centre centre-lr centre-text heading">
                                BOOKING DETAILS
                            </div>

                            <div class="break">
                            </div>
                            <div class="margin margin-vert1">                            
                            </div>
                            <div class="break"></div>

                            <script src="js/booking.js"></script>
                            <div class="width width-box">
                            </div>

                            <div class="flexbox centre centre-right">

                                <div class="width width-box20">
                                </div>

                                <div class="centre">
                                    Date: 
                                </div>
                                <div class="centre centre-lr">
                                    <?php
                                        echo date("M d, Y",$bdt);
                                    ?>
                                </div>

                                <div class="break"></div>

                                <div class="width width-box20">
                                </div>
                                <div class="centre centre">
                                    Time: 
                                </div>

                                <div class="centre centre-lr">
                                    <?php
                                        echo date("h:i a",$bdt);
                                    ?>
                                </div>

                                <div class="break"></div>

                                <div class="width width-box20">
                                </div>
                                <div class="centre centre">
                                    Charge: 
                                </div>

                                <div class="centre centre-lr">
                                    <?php
                                        echo 'Rs. ' . $bc ;
                                    ?>
                                </div>

                                <div class="break"></div>
                                

                                <div class="width width-box20">
                                </div>
                                <div class="centre centre">
                                    Table: 
                                </div>

                                <div class="centre centre-lr">
                                    <?php
                                        echo '# ' . $tn ;
                                    ?>
                                </div>

                                <div class="break"></div>

                                <div class="width width-box20">
                                </div>
                                <div class="centre centre">
                                    Waiter: 
                                </div>

                                <div class="centre centre-lr">
                                    <?php
                                        echo 'ID#' . $wid . ', ' . $wn ;
                                    ?>
                                </div>

                                
                            </div>

                            <div class="margin margin-mid1">
                            </div>

                            <div class="break">
                            </div>

                            <div class="width wisdth-box">
                            </div>
                            <div class="button centre centre-lr">
                                <input type="submit" value="Cancel Booking" name='cancel_booking'>
                            </div>
                        </div>


                        <div class="flexbox" id="booked_no">

                            <script src="js/booking.js"></script>

                            <div class="heading centre centre-lr">
                                BOOK TABLE
                            </div>

                            <div class="break"></div>
                            <div class="margin margin-vert1"></div>
                            <div class="break"></div>

                            <div class="flexbox warning centre centre-text centre-lr">

                                <div class="width width-box20">
                                </div>
                        
                                <?php
                                    if($empty == 1)
                                    {
                                        $wm = '<div class="break"></div><div class="margin margin-vert1"></div>';
                                        echo "At least one field is empty.";
                                        echo $wm;
                                    }
                                    else if($dt_old == 1)
                                    {
                                        $wm = '<div class="break"></div><div class="margin margin-vert1"></div>';
                                        echo "Reservation must be made<br>at least 3 hours before.";
                                        echo $wm;
                                    }
                                    else if($wait_st == 0)
                                    {
                                        $wm = '<div class="break"></div><div class="margin margin-vert1"></div>';
                                        echo "All waiters are reserved, sorry to disappoint you.";
                                        echo $wm;
                                    }
                                    else if($tab_st == 0)
                                    {
                                        $wm = '<div class="break"></div><div class="margin margin-vert1"></div>';
                                        echo "All tables are reserved, sorry to disappoint you.";
                                        echo $wm;
                                    }
                                    
                                ?>
                            </div>

                        <div class="break">
                        </div>
                        
                        <div class="flexbox">

                            <div class="centre centre-lr">
                                <label for="res_dt">Reservation date and time:</label>
                                <br>
                                <input type="datetime-local" name="res_dt" id="res_dt">    
                            </div>

                                <div class="break">
                                </div>
                                
                                <div class="margin margin-vert1">
                                </div>

                                <div class="break">
                                </div>

 
                                <div class="centre centre-lr">
                                    <label for="res_dur">Reservation duration<br>(30 minutes to 120 minutes):</label>
                                    <br>
                                    <input type="number" name="res_dur" id="res_dur" min="30" max="120">
                                    
                                </div>

                                <div class="break">
                                </div>
                                
                                <div class="">
                                </div>
                                <div class="centre centre-lr button">
                                    <input type="submit" name="book" value="Book">
                                </div>
                            </div>

                            <div class="break">
                            </div>
                        </div>
                    </div>
                </div>


                <div style="width: 50%;">
                    <div class="centre centre-right width wdidth-box50">
                        <div class="warning centre centre-text centre-lr">
                            <?php
                                if($qty_flag == 0)
                                {
                                    $wm = '<div class="break"></div><div class="margin margin-vert1"></div>';
                                    echo "Quantity cannot be empty.";
                                    echo $wm;
                                    
                                }
                            ?>
                        </div>
                        
                        <div class="break">
                        </div>


                        <div class="flexbox ">
                            <div class="heading centre centre-lr">
                                PLACE MENU ORDER
                            </div>
                            
                            <div class="break"></div>
                            <div class="margin margin-vert1"></div>
                            <div class="break"></div>
                            
                            <div class="flexbox centre centre-vert centre-left">
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
                                </select>  
                            </div>

                            <div class="margin margin-mid1">
                            </div>        

                            <div class="flexbox centre centre-vert width width-num4">
                                <input type="number" name="quantity" id="quantity" min=1 max=5 placeholder="qty">
                            </div>     
                            
                            <div class="margin margin-mid1">
                            </div>

                            <div class="button centre centre-right">
                                <input type="submit" value="Add" name="add">
                            </div>				
                        </div>
                        
                        <div class="break">
                        </div>

                        <div class="heading centre centre centre-text">
                            CURRENT ORDERS
                        </div>

                        <div class="break">
                        </div>

                        <div class="flexbox centre centre-lr centre-text">
                            <?php
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
                                    $name_qty = '<div class="flexbox centre-left centre-vert">' . $fs['item_name'] . ' : ' . $fs['amount_ordered'] . ' plates.</div>';
                                    $submit_delete = '<div class="margin margin-mid1"></div><div class="button centre centre-right"><input type="submit" value="Remove 1" name="delete'. $fs['menu_id'] .'"></div><div class="break"></div>';
                                    
                                    echo $name_qty . $submit_delete;
                                    $counter ++;
                                }

                                if($counter == 0)
                                {
                                $none= '<div class="centre centre-lr centre-text">None.</div>';
                                echo $none;
                                }
                            ?>						
                        </div>
                    </div>

                    <div class="break">
                    </div>

                </div>
            </div>

            <div class="button centre centre-lr" id="pay">
                <input type="submit" value="Make Payment" name="pay">
                <script>
                    if(c_f == 0)
                    {
                        var pay = document.getElementById("pay");
                        pay.classList.add("invisible");
                    }
                    else if(c_f == 1)
                    {
                        var pay = document.getElementById("pay");
                        pay.classList.remove("invisible");
                    }
                </script>
            </div>
        </form>

        <?php
            mysqli_close($conn);
        ?>
    </body>
</html>