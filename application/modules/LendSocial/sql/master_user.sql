ALTER TABLE `master_user` ADD `loan_purpose` VARCHAR(200) NULL AFTER `net_monthly_income`, ADD `loan_amount` VARCHAR(50) NULL AFTER `loan_purpose`, ADD `loan_tenure` VARCHAR(20) NULL AFTER `loan_amount`; 

