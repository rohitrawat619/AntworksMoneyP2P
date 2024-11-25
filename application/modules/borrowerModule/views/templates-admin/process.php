<div class="white-box">
    <div class="col-md-12">
        <h2 class="main-hd text-center">Process Guide to Complete your profile</h2>

        <div class="flex-parent">
            <div class="input-flex-container">
                <div class="input <?php if($steps->step_1 == 1 && $steps->step_2 == 0){ echo "active";} ?>">
                    <span data-year="Step 1" data-info="Registration"></span>
                </div>
                <div class="input <?php if($steps->step_2 == 1 && $steps->step_3 == 0){ echo "active";} ?>">
                    <span data-year="Step 2" data-info="Payment"></span>
                </div>
                <div class="input <?php if($steps->step_3 == 1 && $steps->step_4 == 0){ echo "active";} ?>">
                    <span data-year="Step 3" data-info="KYC"></span>
                </div>
                <div class="input <?php if($steps->step_4 == 1){ echo "active";} ?>">
                    <span data-year="Step 4" data-info="Escrow Account"></span>
                </div>
            </div>
        </div>

    </div>
</div>