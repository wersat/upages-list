<?php $data = Inventor_Stripe_Logic::get_data($_POST['payment_type'], $_POST['object_id']); ?>
<script
  src="https://checkout.stripe.com/checkout.js"
  class="stripe-button"
  data-key="<?php echo $data['key'] ?>"
  data-name="<?php echo $data['name'] ?>"
  data-description="<?php echo $data['description'] ?>"
  data-amount="<?php echo $data['amount'] ?>"
  data-locale="<?php echo $data['locale'] ?>"
  data-currency="<?php echo $data['currency'] ?>">
</script>
