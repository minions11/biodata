<section class="content">
	<div>
		<div>
			<div>
				<center>
					<!-- Default box -->
					<div class="row">
						<div class="col-md-3" style="margin-left: 425px;">
							<div class="box box-info collapse-box">
								<div class="box-header with-border">
									<h3 class="box-title">Data Penting</h3>

									<div class="box-tools">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
									</div>
									<!-- /.box-tools -->
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<label>Tanggal Transaksi: </label><input type="date" class="form-control" name="tglTransaksi" id="tglTransaksi">
									<label>No. Faktur: </label><input type="text" class="form-control" name="noFaktur" id="noFaktur">
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
						</div>
						<div class="col-md-12">
							
						</div>
						<!-- /.col -->
					</div>
				<div class="table-responsive">
				<table class="table table-bordered table-striped table-dark table-hover display dataTables" id="table1">
					<center>
					<thead>
						<tr>
							<td><input type="number" name="no" id="no" class="form-control"></td>
							<td>
								<select id="rekening" class="form-control select2">
									<?php foreach ($rekening as $row) : ?>
										<option value="<?= $row->nomor_rekening ?>"><?= $row->nomor_rekening ?></option>
									<?php endforeach?>
								</select>
							</td>
							<td><input type="text" name="nama_perkiraan" id="nama_perkiraan" class="form-control"></td>
							<td><input type="text" name="keterangan_buku_besar" id="keterangan_buku_besar" class="form-control"></td>
							<td><input type="number" name="debet" id="debet" class="form-control"></td>
							<td><input type="number" name="kredit" id="kredit" class="form-control"></td>
							<td><button class="add_cart btn btn-info btn-xs center-block">Submit</button></td>
							
						</tr>
					</thead>
					<tr>
						<th>No</th>
						<th>Rekening</th>
						<th>Nama Perkiraan</th>
						<th>Keterangan Buku Besar</th>
						<th>Debet</th>
						<th>Kredit</th>
						<th>Action</th>
					</tr>
					<tbody id="detail_cart">

	                </tbody>
	                <tfoot>
	                	<tr>
	                		<td><button id="simpansemua" class="btn btn-primary">Simpan Semua</button></td>
	                		<td><a href="<?= base_url() ?>transaksi_induk/delete" onclick="return confirm('Yakin ingin membatalkan semuanya?')" class="btn btn-danger">Batalkan Semua</a></td>
	                	</tr>
	                </tfoot>
					</center>
				</table>
				</div>
				</center>
			</div>
		</div>
	</div>
</section>
	<script type="text/javascript">
		$('#table1 tbody').on('click', 'tr', function() {
			var trid = $(this).attr('id');
			$.ajax({
				type : "POST",
				data: {rowid:trid},
				dataType:'json',
				url: '<?= base_url() ?>transaksi_induk/getitem',
				success: function(data) {
					$("#no").val(data.no);
					$("#rekening").val(data.rekening);
					$("#nama_perkiraan").val(data.nama_perkiraan);
					$("#keterangan_buku_besar").val(data.keterangan_buku_besar);
					$("#debet").val(data.debet);
					$("#kredit").val(data.kredit);
					console.log(data);
				}
			});
			// console.log(trid);
		});

	    $('.add_cart').click(function(){
	        var noF = $("#noFaktur").val();
	        var no = $("#no").val();
	        var rekening = $("#rekening").val();
	        var nama_perkiraan = $("#nama_perkiraan").val();
	        var keterangan_buku_besar = $("#keterangan_buku_besar").val();
	        var debet = $("#debet").val();
	        var kredit = $("#kredit").val();
	        $.ajax({
	            url : "<?php echo base_url();?>transaksi_induk/add",
	            method : "POST",
	            data : {noF:noF,no:no,rekening:rekening,nama_perkiraan:nama_perkiraan,keterangan_buku_besar:keterangan_buku_besar,debet:debet,kredit:kredit},
	            success: function(data){
	            	console.log(data);
	            	$("#noFaktur").val("");
	            	$("#no").val("");
	            	$("#rekening").val("");
	            	$("#nama_perkiraan").val("");
	            	$("#keterangan_buku_besar").val("");
	            	$("#debet").val("");
	            	$("#kredit").val("");
	                $('#detail_cart').html(data);
	            }
	        });
	    });

	    // Load shopping cart
	    $('#detail_cart').load("<?= base_url();?>transaksi_induk/load_cart");

	    //Hapus Item Cart
	    $(document).on('click','.hapus_cart',function(){
	        var row_id = $(this).attr("id"); //mengambil row_id dari artibut id
	        $.ajax({
	            url : "<?php echo base_url();?>transaksi_induk/delete_cart",
	            method : "POST",
	            data : {row_id : row_id},
	            success :function(data){
	            	console.log(data);
	                $('#detail_cart').html(data);
	            }
	        });
	    });
	    $('#simpansemua').click(function() {
	    	var tanggal = $('#tglTransaksi').val();
	    	var noFaktur = $('#noFaktur').val();
	    	if (tanggal == "" || noFaktur == "") {
	    		let timerInterval
				Swal({
				  title: 'Yang teliti',
				  type: 'error',
				  text: 'Tanggal atau No faktur masih kosong',
				  showConfirmButton: false,
				  timer: 1600,
				  onClose: () => {
				    clearInterval(timerInterval)
				  }
				}).then((result) => {
				  if (
				    // Read more about handling dismissals
				    result.dismiss === Swal.DismissReason.timer
				  ) {
				    console.log('I was closed by the timer')
				  }
				})
	    	}else {
	    		$.ajax({
	    			url: "<?= base_url(); ?>transaksi_induk/simpan",
	    			type: "POST",
	    			data: {tanggal:tanggal,noFaktur:noFaktur},
	    			success: function(data) {
	    				window.location.reload();
	    			}
	    		});
	    	}
	    });
	</script>