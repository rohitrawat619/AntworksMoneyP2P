
<section class="container">
    <div class="row">
        <div class="col-md-2 col-sm-12 text-center"></div>
        <div class="col-md-8 col-sm-12 text-center">
            <div class="creditline-success">
                <form action="javascript: void(0)" class="otp-form" name="otp-form">
                    <div class="title">
                        <p class="otpverify">OTP Verification</p>
                        <p class="otpinfo">An OTP has been sent to <?=substr_replace($mobile, str_repeat('*', 6), 0, 6); ?></p>
                        <p class="otpmsg">Please enter OTP to verify</p>
                    </div>
                    <div class="otp-input-fields">
                        <input type="number" class="otp__digit otp__field__1" maxlength="1">
                        <input type="number" class="otp__digit otp__field__2" maxlength="1">
                        <input type="number" class="otp__digit otp__field__3" maxlength="1">
                        <input type="number" class="otp__digit otp__field__4" maxlength="1">
                        <input type="number" class="otp__digit otp__field__5" maxlength="1">
                        <input type="number" class="otp__digit otp__field__6" maxlength="1">
                    </div>
                    <div class="result">
                        <p id="_otp" class="_notok"></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>




<script>
    $(document).ready(function() {
        // Function to handle OTP input
        $('.otp__digit').on('input', function() {
            var $this = $(this);
            if ($this.val().length === 1) {
                $this.next('.otp__digit').focus(); // Move focus to the next input field
                checkAndSubmitForm(); // Check if all fields are filled and submit the form
            } else if ($this.val().length === 0) {
                $this.prev('.otp__digit').focus(); // Move focus to the previous input field
            }
        });

        // Function to check if all OTP fields are filled and submit the form
        function checkAndSubmitForm() {
            var otpFilled = true;
            $('.otp__digit').each(function() {
                if ($(this).val().length !== 1) {
                    otpFilled = false;
                    return false; // Exit the loop if any field is not filled
                }
            });

            if (otpFilled) {
                $('.otp-form').submit(); // Submit the form if all fields are filled
            }
        }

        // AJAX call to handle OTP verification
        $('.otp-form').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            // Collect OTP from input fields
            var otp = '';
            $('.otp__digit').each(function() {
                otp += $(this).val();
            });

            // Perform AJAX call to verify OTP
            $.ajax({
                url: 'e_sign_verify_otp_ajax', // Replace with the actual PHP file handling OTP verification
                type: 'POST',
                data: {
                    otp: otp
                },
                success: function(response) {
                    console.log(response);
					console.log("asdfghj");
                    var resp = JSON.parse(response);
					console.log(resp)
                    if (resp.status == 1) {
                        window.location.href = 'e_sign_success';
                    } else {
                        alert("Incorrect OTP");
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
