<?php
class Entryledger extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

	public function addlenderstatementEntry($ledger_array)
	{
		$this->db->insert('p2p_lender_statement_entry', $ledger_array);
	}

}
?>
