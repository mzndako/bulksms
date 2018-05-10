<?php
class payment_bank extends my_payment_methods
{
	public $options = array();
	public $name = "paystack";
	public $setting_name = "bank";
	public $payment_method = "";
	public $payment_gateway = "bank";
	function __construct($options = array()){
		$this->options = $options;
	}

	function connect()
	{

	}

	public function show(){
//		$this->show_proceed = false;
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
				$this->show_proceed = false;
				$recipient = $banks[$s_bank]['bank']."<br>".$banks[$s_bank]['account']."<br>".$banks[$s_bank]['name'];
				$id = $this->save_transaction(array("payment_method"=>"bank","recipient"=>$recipient, "amount"=>parse_amount(this()->input->post("amount"))));
//				$name = $this->get_user_name();
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