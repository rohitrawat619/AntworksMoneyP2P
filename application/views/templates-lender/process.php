<div class="white-box">
    <div class="col-md-12" id="lenderprocess">
        <h2 class="main-hd text-center">Process Guide to Complete your profile</h2>

        <div class="flex-parent">
            <div class="input-flex-container">
                <div class="input <?php if($steps->step_1 == 1 && $this->uri->segment(1) . '/' . $this->uri->segment(2) == $current_step){ echo "active";} ?>">
                    <span data-year="Step 1" data-info="Registration"></span>
                </div>
                <div class="input <?php if($steps->step_2 == 0 && $this->uri->segment(1) . '/' . $this->uri->segment(2) == $current_step){echo "active";} ?>">
                    <span data-year="Step 2" data-info="Payment"></span>
                </div>
                <div class="input <?php if($steps->step_3 == 0 && $this->uri->segment(1) . '/' . $this->uri->segment(2) == $current_step){ echo "active";} ?>">
                    <span data-year="Step 3" data-info="KYC"></span>
                </div>
                <div class="input <?php if($steps->step_4 == 0 && $this->uri->segment(1) . '/' . $this->uri->segment(2) == $current_step){ echo "active";} ?>">
                    <span data-year="Step 4" data-info="Bank Account Details"></span>
                </div>
                <div class="input <?php if($steps->step_5 == 0){ echo "active";} ?>">
                    <span data-year="Step 5" data-info="Preference"></span>
                </div>
            </div>
        </div>

    </div>
</div>
