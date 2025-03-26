<?php if (isset($_GET['status']) && $_GET['status'] == "success") : ?>
<div class="alert alert-success" role="alert">
    Training data saved successfully!
</div>
<?php elseif (isset($_GET['status']) && $_GET['status'] == "error") : ?>
<div class="alert alert-danger" role="alert">
    Failed to save training data. Please try again.
</div>
<?php endif; ?>