<?
  require_once("header.php");
  $_SESSION[ord_ID] = $_GET[id];

?>

    <div id="all">

        <div id="content">
            <div class="container">

                <div class="col-md-12">

                    <ul class="breadcrumb">
                        <li><a href="index.html">Home</a>
                        </li>
                        <li><a href="#">My order</a>
                        </li>
                        <li>Order # <?echo $_SESSION[ord_ID];?></li>
                    </ul>

                </div>



                <?
                require_once("customer-menu.php");
                ?>


                <div class="col-md-9" id="customer-order">
                    <div class="box">
                        <h1>Order #<?echo $_SESSION[ord_ID];?></h1>
                        <?
                          $date = $userObject->getOrderDate($_SESSION[ord_ID]);
                          foreach($date as $track)
                          {
                            $_SESSION[ord_date] = $track[order_date];
                            $trackNum = $track[ord_track];
                          }
                        ?>
                        <p class="lead">Order #<?echo $_SESSION[ord_ID];?> was placed on <strong><?echo $_SESSION[ord_date];?></strong> and the shipping # is <strong><?echo $trackNum;?></strong>.</p>
                        <p class="text-muted">If you have any questions, please feel free to <a href="contact.php">contact us</a>, our customer service center is working for you 24/7.</p>

                        <hr>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                      <th>Product</th>
                                      <th>Model</th>
                                      <th>Quantity</th>
                                      <th>Unit price</th>
                                      <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?$order = $userObject->getOrder();

                                    foreach($order as $ord)
                                    {

                                      $_SESSION[add_Bill] = $ord[add_Bill];
                                      $_SESSION[add_ID] = $ord[add_Ship];



                                  ?>
                                  <tr >
                                      <td>

                                            <img src="../../products/<?echo $ord[pro_ID];?>.jpg" alt="" class="img-responsive">

                                      </td>
                                      <td>

                                        <?echo $ord[pro_Manufacturer] . "<br/>" . $ord[pro_Model];?>

                                       </td>


                                       <td ><span class = 'move-right' id='<?echo $ord[pro_ID];?>optqty' ><span   id = '<?echo $ord[pro_ID];?>' ><?echo $ord[ord_Qty];?></span></span></td>

                                  <td>$<span id = '<?echo $ord[pro_ID];?>_price'><?echo $ord[pro_Price];?></span></td>

                <td>$<span id = '<?echo $ord[pro_ID];?>_total'><?echo number_format($ord[pro_Price] * $ord[ord_Qty],2);?></span></td>

              </tr >
              <?
              $ordOpts = $userObject->getOrderOpt();
              foreach($ordOpts as $opts)
              {
                if($opts[pro_ID] == $ord[pro_ID])
                {
                ?>
              <tr id = '<?echo $opts[pro_ID];?>options'>

                <td></td>
                <td><?echo $opts[opt_Name];?><br/><?echo $opts[opt_Value]; ?></td>



                <td ><span class = 'move-right' id='<?echo $opts[pro_ID];?>optqty' ><span   id = '<?echo $opts[pro_ID];?>' ><?echo $ord[ord_Qty];?></span></span></td>

                <td>$<span id = '<?echo $opts[pro_ID];?>_optionprice'><?echo $opts[opt_Price];?></span></td>

                  <td >$<span id = '<?echo $opts[pro_ID];?>_opttotal'><?echo number_format($ord[ord_Qty] * $opts[opt_Price],2);?></span></td>

              </tr>

                                    <?



                                  }
                                    $option_tot = $option_tot + $ord[ord_Qty] * $opts[opt_Price];

                                  }
                                  $random_prod = $random_prod + $ord[pro_Price] * $ord[ord_Qty];

                                  }
                                  $sum = $random_prod + $option_tot;


                                  ?>
                                </tbody>
                                <tfoot>
                                  <?$tax = $sum * .06;
                                    $total = $sum + $tax + $ord[ord_ship];?>
                                    <tr>
                                        <th colspan="4" class="text-right">Order subtotal</th>
                                        <th>$<?echo number_format($sum,2);?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Shipping and handling</th>
                                        <th>$<?echo $ord[ord_ship];?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Tax</th>
                                        <th>$<?echo number_format($tax,2);?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">Total</th>
                                        <th>$<?echo number_format($total,2);?></th>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                        <!-- /.table-responsive -->

                        <div class="row addresses">
                            <div class="col-md-6">
                              <?

                              $invoice = $userObject->getShipAddress($_SESSION[add_Bill]);
                              foreach($invoice as $bill)
                              {
                                ?>
                                <h2>Invoice address</h2>
                                <p>
                                    <?echo  $bill[add_Street];?>
                                    <br><?echo $bill[add_City];?>
                                    <br><?echo $bill[add_State];?>
                                    <br><?echo $bill[add_Zip];?></p>

                                <?
                              }
                              ?>
                              </div>
                              <div class="col-md-6">
                                <?
                              $ship = $userObject->getShipAddress($_SESSION[add_ID]);
                              foreach($ship as $add)
                              {
                              ?>
                                <h2>Shipping address</h2>
                                <p>
                                      <?echo  $add[add_Street];?>
                                      <br><?echo $add[add_City];?>
                                      <br><?echo $add[add_State];?>
                                      <br><?echo $add[add_Zip];?></p>
                                  <?
                                  }
                                  ?>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->


      <?
        require_once("footer.php");
      ?>
