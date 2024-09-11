<?php

class Check extends CI_Controller
{   
    public function __construct()
    {
        parent::__construct();
        $this->load->model('check_model');
        $this->load->model('LendSocialmodel');
    }

    public function check($scheme_id) // dated 11-Sep-2024
    {
        // Trigger point when the lender invests its money 
        // this function updates the data of tables of p2p_borrower_priority_queue and p2p_lender_priority_queue
        
        $schemeData = $this->LendSocialmodel->getSchemeDataById($scheme_id);

        // Set the values
        $stepUp = $schemeData['step_up_value'];
        $minimumLoanAmount = $schemeData['minimum_loan_amount'];

        // Find the minimum lenders required to create a batch 
        $minimumLenderRequired = $minimumLoanAmount / $stepUp;

        // Get the number of available lenders
        $noOfAvailableLenders = $this->check_model->getNoOfLendersAvailInScheme($scheme_id);

        if ($noOfAvailableLenders >= $minimumLenderRequired) {

            // Get the available and borrowers
           
            $availableBorrowers = $this->check_model->getborrowersAvailInScheme($scheme_id);

            // Initialize allocation details array
            $allocationDetails = [];

            foreach ($availableBorrowers as $borrower) {

                $availableLenders = $this->check_model->getLendersAvailInScheme($scheme_id);
                $borrowerAmountNeeded = $borrower['remaining_amount_needed'];

                // Calculate the number of lenders needed
                $lendersNeedToLendMoney = $borrowerAmountNeeded / $stepUp;

                if ($noOfAvailableLenders >= $lendersNeedToLendMoney) {
                    foreach ($availableLenders as $key => $lender) {
                        if ($lender['rem_amount'] >= $stepUp && $borrowerAmountNeeded > 0) {
                            // echo "<pre>";print_r($lender);
                            $amountToAllocate = $stepUp;

                            // Update lender and borrower amounts
                            $lender['rem_amount'] = $lender['rem_amount'] - $amountToAllocate;
                            $this->check_model->updateLenderAmount($lender['id'], $lender['rem_amount']);

                            $borrowerAmountNeeded = $borrowerAmountNeeded - $amountToAllocate;
                            $borrower['borrowing_amount'] = $borrower['borrowing_amount'] + $amountToAllocate;
                            // Update the lender and borrower in the database
                            
                            $this->check_model->updateBorrowerAmount($borrower['id'], $borrowerAmountNeeded,$borrower['borrowing_amount'] );

                            // Store allocation details
                            $allocationDetails[] = [
                                'lender_id' => $lender['id'],
                                'borrower_id' => $borrower['id'],
                                'allocated_amount' => $amountToAllocate
                            ];

                            // Remove lender if their amount is depleted
                            if ($lender['rem_amount'] <= 0) {
                                unset($availableLenders[$key]);
                                $noOfAvailableLenders--;
                            }

                            // Exit the lender loop if borrower needs are fully satisfied
                            if ($borrowerAmountNeeded <= 0) {
                                break;
                            }
                        }
                    }

                    // if ($borrowerAmountNeeded > 0) {
                    //     echo "Not enough lenders to meet the full requirement of Borrower ID: {$borrower['id']}<br>";
                    // }
                } else {
                    echo "Not enough lenders to start lending for Borrower ID: {$borrower['id']}<br>";
                }
            }

            // Display allocation details
            echo "<h3>Allocation Details</h3>";
            foreach ($allocationDetails as $allocation) {
                echo "Lender ID: " . $allocation['lender_id'] . " allocated " . $allocation['allocated_amount'] . " to Borrower ID: " . $allocation['borrower_id'] . "<br>";
            }

        } else {
            echo "Not enough lenders available to start a batch.";
        }

        die();
    }
}
