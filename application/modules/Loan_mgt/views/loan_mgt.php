<div class="container">
<?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?= $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?= $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>


    <form action="<?=base_url('/loan_mgt/post');?>" method="post" id="loanForm">
        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" required min="1" step="0.01">
        
        <label for="interest">Interest Rate (%):</label>
        <input type="number" name="interest" id="interest" required min="0" step="0.01">
        
        <label for="tenor">Tenor (days):</label>
        <select name="tenor" id="tenor" required>
            <option value="">Choose your plan tenor (days)</option>
            <option value="30">30 Days</option>
            <option value="60">60 Days</option>
            <option value="90">90 Days</option>
        </select>
        
        <input type="submit" value="Submit">
    </form>
</div>

<script>
document.getElementById('loanForm').addEventListener('submit', function(event) {
    var amount = document.getElementById('amount').value;
    var interest = document.getElementById('interest').value;
    var tenor = document.getElementById('tenor').value;
    if (amount === '') {
        alert("Please enter a amount.");
        event.preventDefault();
    }
    if (amount <= 0) {
        alert("Please enter a valid amount greater than 0.");
        event.preventDefault();
    }

    if (interest === '') {
        alert("Please enter interest rate.");
        event.preventDefault();
    }

    if (interest < 0) {
        alert("Please enter a valid interest rate greater than or equal to 0.");
        event.preventDefault();
    }

    if (tenor === "") {
        alert("Please select a valid tenor.");
        event.preventDefault();
    }
});
</script>
