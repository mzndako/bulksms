<div id="chartdiv">

</div>
<style>
	#chartdiv {
		width: 100%;
		height: 200px;
	}
	#delivery_table .d{
		background: #008000;
		color: white;
	}
	#delivery_table .f{
		background: #ff0000;
		color: white;
	}
	#delivery_table .s{
		background: #ffc843;
		color: black;
	}
	#delivery_table .dnd{
		background: #ff3af3;
		color: black;
	}
	#delivery_table .route td{
		color: #2725ff;
	}
</style>
<div>
	<div class="alert alert-warning alert-dismissable inactive" id="alert_delivery">
		<span href="javascript:void(0)" class="close" onclick="$(this).parent().hide(100)" aria-label="close">&times;</span>
		<span class="alert_content"></span>
	</div>

<div align="center" style="overflow-x: auto">
	<table style="width: auto;" id="delivery_table" class="table table-striped">
		<thead>

		</thead>
		<?php
		$green = '#008000';
		$yellow = '#ffc843';
		$dnd = '#ff3af3';
		$red = '#FF0000';

		$banking = 0;
		$ss = array();

			foreach($recipient as $row) {
				$sid = $row['status'];
				$route = $row['route'];
				$cost = $row['cost'];
				$code = "f";
				switch($sid){
					case 0:
						$ss['sent'] = 1 + getIndex($ss,"sent",0);
						$code = "s";
						break;
					case 1:
						$ss['delivered'] = 1 + getIndex($ss,"delivered",0);
						$code = "d";
						break;
					case 9:
						$ss['dnd'] = 1 + getIndex($ss,"dnd",0);
						$code = "dnd";
						break;
					default:
						$ss['failed'] = 1 + getIndex($ss,"failed",0);
				}

				if($route == 2){
					$banking++;
				}


				$status = getDStatus($sid);

				$s = $status.": ".format_amount($cost, -1);

				if($sid == 9){
					$s = $status;
				}
				$num = $row['phone'];
				$nt = network($row['phone']);
				if(!empty($nt)){
					$num = $num. " (".strtoupper($nt).")";
				}
				?>
			<tr class="<?=$route==2?"route":"";?>">
				<td><?=$num;?></td>
				<td class="<?=$code;?>"><?php
echo $s;
					;?></td>
				<td align="center"><?php
					$d = $row['donedate'];
					$d = empty($d)?"--":convert_to_datetime($d);
					echo $sid == 8?"Sent To Operator":$d;
					?></td>
			</tr>
				<?php
			}


		?>
	</table>
   </div>
</div>

<script>
	var chart = AmCharts.makeChart( "chartdiv", {
		"type": "pie",
		"theme": "light",
		"dataProvider": [ {
			"status": "<?=getIndex($ss, "delivered", 0);?> Delivered",
			"numbers": <?=getIndex($ss, "delivered", 0);?>,
			color: "<?=$green ;?>"
		}, {
			"status": "<?=getIndex($ss, "sent", 0);?> Sent",
			"numbers": <?=getIndex($ss, "sent", 0);?>,
			color: "<?=$yellow;?>"
		}, {
			"status": "<?=getIndex($ss, "dnd", 0);?> DND",
			"numbers": <?=getIndex($ss, "dnd", 0);?>,
			color: "<?=$dnd;?>"
		}, {
			"status": "<?=getIndex($ss, "failed", 0);?> Failed",
			"numbers": <?=getIndex($ss, "failed", 0);?>,
			color: '<?=$red;?>'
		}],
		"valueField": "numbers",
		"titleField": "status",
		"colorField": "color",
		"balloon":{
			"fixedPosition":true
		},
		"export": {
			"enabled": true
		},
		"panEventsEnabled": false
	} );
	<?php
		if($banking > 0){
		?>
	addPageHook(function () {
		$("#alert_delivery").show(100);
		$("#alert_delivery .alert_content").html("<?=$banking;?> Numbers sent through Banking Route in blue color");
		return "destroy";
	});
	<?php
}
 ?>
</script>

