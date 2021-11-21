<?php
    include ('partials/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage-Order</h1>                
                <br /> <br /> <br />

                <?php
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                ?>
                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Food</th>
                        <th>Prce</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
                        $res = mysqli_query($conn,$sql);
                        $count = mysqli_num_rows($res);
                        if($count>0)
                        {
                            $stt=1;
                            while($row = mysqli_fetch_assoc($res))
                            {
                                $id = $row['id'];
                                $food = $row['food'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $total = $row['total'];
                                $order_date = $row['order_date'];
                                $status = $row['status'];
                                $customer_name = $row['customer_name'];
                                $customer_contact = $row['customer_contact'];
                                $customer_email = $row['customer_email'];
                                $customer_address = $row['customer_address'];

                                ?>
                                    <tr>
                                        <td><?php echo $stt++ ; ?></td>
                                        <td><?php echo $food; ?></td>
                                        <td><?php echo $price?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo $total; ?></td>
                                        <td><?php echo $order_date; ?></td>
                                        <td>
                                            <?php 
                                                // Ordered, On Delivery, Delivered, Cancelled

                                                if($status=="Ordered")
                                                {
                                                    echo "<label style='font-weight:bold;' >$status</label>";
                                                }
                                                elseif($status=="On Delivery")
                                                {
                                                    echo "<label style='color: #27ae60; font-weight:bold';>$status</label>";
                                                }
                                                elseif($status=="Delivered")
                                                {
                                                    echo "<label style='color: #2980b9; font-weight:bold';>$status</label>";
                                                }
                                                elseif($status=="Cancelled")
                                                {
                                                    echo "<label style='color: #c0392b; font-weight:bold'>$status</label>";
                                                }

                                            ?>
                                        </td>
                                        <td><?php echo $customer_name; ?></td>
                                        <td><?php echo $customer_contact; ?></td>
                                        <td><?php echo $customer_email; ?></td>
                                        <td><?php echo $customer_address; ?></td>
                                        <td>
                                            <a href="<?php SITEURL; ?>update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a> 
                                        </td>
                                    </tr>
                                <?php
                            }
                        }
                        else
                        {
                            echo "<tr><td colspan='12' class='error'>Order not Available.</td></tr>";
                        }
                    ?>
                    
                    <!-- <tr>
                        <td>2</td>
                        <td>Minh Ha</td>
                        <td>Ha123</td>
                        <td>
                            <a href="" class="btn-secondary">Update Admin</a> 
                            <a href="" class="btn-danger">Update Admin</a> 
                        </td>
                    </tr> -->
                    
                </table>
    </div>
</div>

<?php
    include ('partials/footer.php');
?>