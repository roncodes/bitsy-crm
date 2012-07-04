<h2>Success!</h2>

<p>Your payment was received using Paypal.</p>

<?php if ($this->input->post()): ?>
<p>Here's its information:</p>
<p><code>
<?php	
	foreach ($this->input->post() as $key => $value)
		echo '<strong>$key</strong>: $value <br/>';
?>
</code></p>
<?php endif; ?>
