<?php
if(strtolower($sslcommerz_currency) !== 'bdt') {
?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_currency_error; ?></div>
<?php
} else {
?>
    <?php if ($testbox) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $text_testbox; ?></div>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post">
      <input type="hidden" name="total_amount" value="<?php echo number_format( $sslcommerz_amount, 2 ); ?>" />
      <input type="hidden" name="store_id" value="<?php echo $sslcommerz_username; ?>" />
      <input type="hidden" name="tran_id" value="<?php echo $sslcommerz_transaction_id; ?>" />
      <input type="hidden" name="success_url" value="<?php echo $sslcommerz_success_url; ?>" />
      <input type="hidden" name="fail_url" value="<?php echo $sslcommerz_fail_url; ?>" />
      <input type="hidden" name="cancel_url" value="<?php echo $sslcommerz_cancel_url; ?>" />
      <input type="hidden" name="version" value="2.00" />
      <?php
        foreach($products as $key => $product) {
          echo '<input type="hidden" name="cart['.$key.'][product]" value="'.$product['name'].'" />';
          echo '<input type="hidden" name="cart['.$key.'][amount]" value="'.$product['price'].'" />';
        }
      ?>
      <div class="buttons">
        <div class="pull-right">
          <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary" />
        </div>
      </div>
    </form>
<?php
}
?>