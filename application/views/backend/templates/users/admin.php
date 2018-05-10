<div class="blockquote blockquote-danger">
	MANAGE ADMIN
</div>
<button onclick="showAjaxModal('<?= url("modal/popup/user.admin_modal"); ?>')" class="btn btn-raised btn-info">
	ADD ADMIN
</button>
<div class="row">

	<div class="col-md-12">

		<table class="table table-bordered table_export">
			<thead>
			<tr>
				<th>
					<div>#</div>
				</th>
				<th>
					<div>Name</div>
				</th>
				<th>
					<div>Email</div>
				</th>
				<th>
					<div>Phone</div>
				</th>
				<th>
					<div>Type</div>
				</th>
				<th>
					<div>Status</div>
				</th>
				<th>
					<div>Option</div>
				</th>
			</tr>
			</thead>
			<tbody>
			<?php $count = 1;

			d()->order_by("name", "ASC");
			$admin = c()->get("admin")->result_array();

			$role = get_arrange_id_name("role", "role_id", "name");

			foreach ($admin as $row):?>
				<tr>
					<td><?php echo $count++; ?></td>
					<td><?php echo c()->get_full_name($row); ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo $row['phone']; ?></td>
					<td><?php echo getIndex($role, $row['access']); ?></td>
					<td>
						<a onclick="return confirm_dialog(this, '<?= $row['disabled'] == 0 ? "Disable Admin!" : "Enable Admin!"; ?>');"
						   href='<?= url("user/admin/status/" . ($row['disabled'] == 0 ? 1 : 0) . "/$row[admin_id]"); ?>'
						   class="btn btn-raised btn-<?= $row['disabled'] == 0 ? 'secondary' : 'primary'; ?>">
							<?= $row['disabled'] == 0 ? "Disable" : "Enable"; ?>
						</a>
					</td>
					<td>
						<div class="btn-group">
							<a href="javascript:void(0)"
							   onclick="showAjaxModal('<?= url("modal/popup/user.admin_modal/$row[admin_id]"); ?>');"
							   class="btn btn-raised btn-warning m-r-10">
								Edit
							</a>
							<a href="javascript:void(0)" onclick="confirm_delete('<?= url("user/admin/delete/$row[admin_id]"); ?>')"
							   class="btn btn-raised btn-danger">
								Delete
							</a>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</div>
