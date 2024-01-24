<div class="container">
    <h1>Add Loan Proposal</h1>
    
    <div class="col-md-6">
        <input type="text" name="loan_amount" id="loan_amount" placeholder="Loan Amount">
    </div>
    <div class="col-md-6">
        <input type="text" name="loan_tenor" id="loan_tenor" placeholder="Loan Tenor">
    </div>
    
    <div class="col-md-12">
        <input type="text" name="loan_interest_rate" id="loan_interest_rate" placeholder="Loan Interest Rate">
    </div>

    <div class="col-md-12">
        <input type="text" name="loan_description" id="loan_description" placeholder="Loan Description">
    </div>
    <div class="col-md-12">
        <button type="button" id="submit" class="btn btn-primary">Submit</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#submit').on('click', function(event) {
        event.preventDefault();
        console.log("Submit clicked");

        // Get data from the input fields
        var loanAmount = $('#loan_amount').val();
        var loanTenor = $('#loan_tenor').val();
        var loanInterestRate = $('#loan_interest_rate').val();
        var loanDescription = $('#loan_description').val();

        // Prepare data to be sent
        var requestData = {
            borrower_id:<?=$_SESSION['borrower_id']?>,
            loan_amount: loanAmount,
            loan_tenor: loanTenor,
            loan_interest_rate: loanInterestRate,
            loan_description: loanDescription
        };
        console.log(requestData);

        // Perform AJAX request to submit data
        $.ajax({
            url: 'borrowwer/proposal_submit', // Update with your server-side script URL
            type: 'POST',
            data: requestData,

            success: function(response) {
                
                var resp = JSON.parse(response);
                console.log(resp);
                // Process the response data
                alert(resp.msg);
                window.location.href = 'borrowwer/loan_agreement';
                // location.reload();
                // You can update the HTML or perform actions based on the response here
            },
            error: function(xhr, status, error) {
                // Handle errors if the AJAX request fails
                console.error(error);
            }
        });
    });
});
</script>
