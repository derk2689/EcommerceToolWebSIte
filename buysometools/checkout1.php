<?

  require_once("header.php");

?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php">Home</a>
                        </li>
                        <li>Checkout - Shipping Address</li>
                    </ul>
                </div>

                <div class="col-md-9" id="checkout">
<? //may come back and fix to pull from db ?>
                    <div class="box">

                            <h1>Checkout - Shipping Address</h1>

                            <ul class="nav nav-pills nav-justified">
                              <li class="active"><a href="checkout1.php"><i class="fa fa-truck"></i><br>Shipping Address</a>
                              </li>
                              <li class="disabled"><a href='#'><i class="fa fa-map-marker"></i><br>Billing Address</a>
                              </li>
                              <li class="disabled"><a href = '#'><i class="fa fa-money"></i><br>Payment Method</a>
                              </li>
                              <li class="disabled"><a href="checkout4.php "><i class="fa fa-eye"></i><br>Order Review</a>
                              </li>
                            </ul>

                            <div class="content">
                              <?
								$_SESSION[weight] = $userObject->getShippingWeight();
							  if($_SESSION[weight] > 150)
							  {
								  echo "<h3><strong>Ground shipping cannot weigh more than 150 lbs!</strong></h3>";
							  }
                              $getAddress = $userObject->getUserAddress();
                                if(!empty($getAddress))
                                {
                                  echo "<h3>Use Current Address</h3>";
                                echo "<form class = 'contact-form' action='addAddress.php' method='post'  id = 'current-address'>";
                                echo  "<div class='row'>";

                                  foreach($getAddress as $addy)
                                  {


                              ?>
                                <div class="col-sm-6 col-md-3">
                                    <div class="form-group">
                                      <input type = 'radio' class = 'previous' name = 'previous' id = '<?echo $addy[add_ID];?>' value ='<?echo $addy[add_ID];?>' required = 'required' >
                                      <p>
                                        <?echo $addy[add_Street];?><br/>
                                        <?echo $addy[add_City];?><br/>
                                        <?echo $addy[add_State];?> ,
                                        <? echo $addy[add_Zip];?>
                                       </p>
                                    </div>
                                </div>

                              <?
                                }
                                echo  "</div>";
                                echo "<div class='box-footer'>
                                    <div class='pull-right'>
                                        <button type='submit' class='btn btn-primary'>Continue to Billing<i class='fa fa-chevron-right'></i>
                                        </button>
                                    </div>
                                </div>";
                                echo "</form>";
                              }
                              ?>
                            </div>
                          </div>
                            <div class="box">

                                <form class = "contact-form" action="addAddress.php" method="post"  id = 'checkout-form'>
                                <!-- /.row -->
                                <h3>Enter new Address</h3>
                                <div class="row">
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                        <input id="street" name="street" placeholder="Street" class="[ form-control ]" data-toggle="floatLabel" data-value="no-js">
                                          <label for="street">Street</label>
                                      </div>
                                  </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                          <input id="street2" name="street2" placeholder="Street 2" class="[ form-control ]" data-toggle="floatLabel" data-value="no-js">
                                            <label for="street">Street 2</label>
                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <!-- /.row -->

                                <div class="row">

                                  <div class="col-sm-6 col-md-3">
                                      <div class="form-group">
                                        <input id="city" name="city" placeholder="City" class="[ form-control ]" data-toggle="floatLabel" data-value="no-js">
                                          <label for="company">City</label>
                                      </div>
                                  </div>

                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                          <input type = 'text' id="state" name="state" placeholder="State" class="[ form-control ]" data-toggle="floatLabel" data-value="no-js">
                                            <label for="state">State</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                          <input id="apartment" name="aptNum" placeholder="Apartment Number" class="[ form-control ]" data-toggle="floatLabel" data-value="no-js">
                                            <label for="city">Apartment Number</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="form-group">
                                          <input type = 'text' id="zip" name="zip" placeholder="Zip" class="[ form-control ]" data-toggle="floatLabel" data-value="no-js">
                                            <label for="zip">ZIP</label>
                                        </div>
                                    </div>
                                  </div>

                                <!-- /.row -->


                            <div class="box-footer">
                                <div class="pull-left">
                                    <a href="basket.php" class="btn btn-default"><i class="fa fa-chevron-left"></i> Basket</a>
                                </div>
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-primary">Billing Address<i class="fa fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                          </div>
                    </div>
                    <!-- /.box -->



                <!-- /.col-md-9 -->

                <div class="col-md-3">

                    <div class="box" id="order-summary">
                        <div class="box-header">
                            <h3>Order summary</h3>
                        </div>
                        <p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                  <?
                                    $c = $shop->getCart($tempID);
                                          foreach($c as $cart)
                                      {

                              $opt = $shop->cartOpts($tempID, $cart[pro_ID]);
                                foreach($opt as $opts)
                                {

                                  $opt_tot = $opt_tot + $cart[cart_qty] * $opts[opt_Price];
                                }
                                $rando_prod = $rando_prod + $cart[pro_Price] * $cart[cart_qty];

                                }

                                  $_SESSION[sum] = $rando_prod + $opt_tot;
                                  $tax = $_SESSION[sum] * .06;
                                    $total = $_SESSION[sum] + $tax + $shipping;
                                    ?>
                                    <tr>
                                        <td>Order subtotal</td>
                                        <th>$<?echo number_format( $_SESSION[sum],2);?></th>
                                    </tr>

                                    <tr>
                                        <td>Tax</td>
                                        <th>$<?echo number_format($tax,2);?></th>
                                    </tr>
                                    <tr class="total">
                                        <td>Total</td>
                                        <th>$<?echo number_format($total,2);?></th>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
                <!-- /.col-md-3 -->

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->

      <?
        require_once("footer.php");
      ?>
