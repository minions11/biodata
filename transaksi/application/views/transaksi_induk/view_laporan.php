<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary">
	            <div class="box-header">
					<h3 class="box-title">Data Table</h3>
					<button class="btn btn-info pull-right" style="display: none;" id="button1"><i class="fa fa-arrow-left"></i></button>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	            	<div id="shtable1">
						<table class="table dataTables table-striped table-hover" id="table1">
							<thead>
								<tr>
									<th>No Faktur</th>
									<th>Tanggal Transaksi</th>
									<th>Total Debet</th>
									<th>Total Kredit</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($items as $key) : ?>
									<tr id="<?= $key->no_faktur ?>">
										<td><?= $key->no_faktur ?></td>
										<td><?= $key->tanggal_transaksi ?></td>
										<th><?= number_format($key->total_debet) ?></th>
										<th><?= number_format($key->total_kredit) ?></th>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
					<table class="table table-striped table-hover" id="table2" style="display: none;">
						
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$('#table1 tbody').on('click', 'tr', function() {
		var trid = $(this).attr('id');
		$.ajax({
			url: '<?= base_url() ?>transaksi_induk/getdetail',
			type: 'POST',
			data: {trid:trid},
			success:function (f) {
				console.log(f);
				$('#table2').show();
				$('#table2').html(f);
				$('#shtable1').hide();
				$('#button1').show();
			}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});

	$("#button1").click(function() {
		$('#shtable1').show();
		$('#table2').hide();
		$('#button1').hide();
	});
</script>