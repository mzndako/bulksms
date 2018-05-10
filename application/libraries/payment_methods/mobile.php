<?php
class payment_mobile extends my_payment_methods
{
	public $options = array();
	public $name = "mobile";
	public $setting_name = "mobile";
	public $payment_method = "";
	public $payment_gateway = "mobile";
	function __construct($options = array()){
		$this->options = $options;
	}

	function connect()
	{

	}

	public function show(){
		$banks = $this->bank_accounts();
		$s_bank = this()->input->post("bank");
		?>
		<div class="form-group">
			<label class="bmd-label-floating">Bank</label>
			<select name="bank" class="form-control">
				<?php
					foreach($banks as $bank => $row) {
						?>
						<option <?=p_selected($s_bank, $bank);?> ><?=$bank;?></option>
						<?php
					}
						?>
			</select>
		</div>

		<?php
			if(!empty($s_bank)) {
				$recipient = $banks[$s_bank]['bank']."<br>".$banks[$s_bank]['account']."<br>".$banks[$s_bank]['name'];
				$this->save_transaction(array("payment_method"=>"bank","recipient"=>$recipient, "amount"=>parse_amount(this()->input->post("amount"))));
				?>
			<div align="center">
				<span style="color: black"><?=$this->get_setting("detail");?></span>
				<h2><?=$banks[$s_bank]['account'];?></h2>
				<h4><?=$banks[$s_bank]['name'];?></h4>

			</div>
				<?php
			}
				?>


<?php
	}





}