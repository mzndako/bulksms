<div class="row">
	<ul class="nav nav-tabs bordered">
		<li class="nav-item active">
			<a data-target="#bulksms" class="nav-link active" data-toggle="tab"> <i class="fa fa-envelope-o"
			                                                                        aria-hidden="true"></i>
				Pages
			</a>
		</li>


	</ul>
	<!------CONTROL TABS END------>

	<div class="tab-content">
		<!----TABLE LISTING STARTS-->
		<div class="tab-pane box active" id="bulksms">
			<br>
			<br>
			<button class="btn btn-raised btn-warning pull-right"
			        onclick="showFullAjaxModal('<?= url("modal/popup/setting.page_modal"); ?>')">
				Add New Page
			</button>
			<br>
			<br>

			<table class="table table-bordered table-striped partial-datatable ">
				<thead class="center">
				<tr>
					<th >#</th>
					<th >Title</th>
					<th >Content Summary</th>
					<th >Status</th>
					<th >Date</th>
					<th class="no-print">Option</th>
				</tr>
				</thead>
				<tbody>
				<?php

				$gateway = c()->get("page")->result_array();
				$count = 1;
				foreach ($gateway as $row):
					?>
					<tr>
						<td><?= $count++; ?></td>
						<td><?= $row['title']; ?></td>
						<td><?= substr(strip_tags($row['content']), 0, 100); ?></td>

						<td class="center">
							<i onclick="loadContainer(this)" data-toggle="tooltip" title="Enable/Disable this Page?"
							   href="<?= url('setting/page/disabled/'.$row['id']); ?>"
							   class="fa fa-toggle-<?=$row['disabled']==0?"on":"off";?> fa-2x cursor"></i>

						</td>
						<td>
							<?= convert_to_datetime($row['date']); ?>
						</td>
						<td class="center" align="center">
							<button data-toggle="tooltip" title="Edit Page" onclick="showFullAjaxModal('<?= url("modal/popup/setting.page_modal/$row[id]"); ?>')" class="btn btn-sm btn-raise btn-warning">
								<i class="fa fa-edit" aria-hidden="true"></i>
							</button>
							<button data-toggle="tooltip" title="Delete Page"  onclick="confirm_delete('<?= url("setting/page/delete/$row[id]"); ?>', this, true)" class="btn btn-sm btn-raise btn-danger">
								<i class="fa fa-trash" aria-hidden="true"></i>
							</button>
						</td>
					</tr>
					<?php
				endforeach;
				?>
				</tbody>
			</table>

		</div>
		<!----TABLE LISTING ENDS--->


		<div class="tab-pane box" id="billpayment">

			<div class="panel panel-primary">

				<div class="panel-heading">
					<div class="panel-title">
						<i class="fa fa-desktop" aria-hidden="true"></i>
						Template
					</div>
				</div>

				<div class="panel-body">
					<div class="row">


						<div class="col-sm-6">

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

</div>


<script type="text/javascript">





</script>