<!DOCTYPE html>
<html>
<head>
	<title>Rooms</title>
	<link rel="stylesheet" type="text/css" href="/<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/<?php echo base_url(); ?>assets/css/style.css">
	<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="/<?php echo base_url(); ?>assets/css/datatables.min.css">
</head>
<body>
	<!-- Temporary Navigation -->
	<?php require(APPPATH.'views/templates/nav.php'); ?>
	<div class="container"><br>

		<h2><?= $title ?></h2>
		<button class="btn btn-primary" data-toggle="add_new_modal" id="add_new_modal_btn">Add new</button>
		<hr>
		<table class="display" id="roomList" style="width: 100%">

		</table>

		<!-- Modal -->
		<div class="modal fade" role="dialog" id="add_new_modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 id="modal_header_title">Modal Data Entry | New Class Room</h5>
					</div>
					<div class="modal-body">
						<form id="entry_form">
							<input type="hidden" id="sysid" name="sysid">
							<div class="form-group">
								<label>Code</label>
								<input type="text" name="code" id="code" class="form-control" placeholder="Code">
							</div>
							<div class="form-group">
								<label>Description</label>
								<input type="text" name="descs" id="descs" class="form-control" placeholder="Description">
							</div>
							<div class="form-group">
								<label>Location</label>
								<input type="text" name="locations" id="locations" class="form-control" placeholder="Locations">
							</div>
							<div class="form-group">
								<label>Capacity</label>
								<input type="text" name="capacity" id="capacity" class="form-control" placeholder="Capacity">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-warning close" data-dismiss="modal">Cancel</button>
								<button type="submit" id="submit" class="btn btn-primary">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="/<?php echo base_url(); ?>assets/js/jquery-3.5.1.min.js"></script>
		<script type="text/javascript" src="/<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" src="/<?php echo base_url(); ?>assets/js/datatables.min.js"></script>

		<script type="text/javascript">
			$(document).ready(function() {

				loadRooms();

				// Loads data into the table
				function loadRooms() {

					$("#roomList").DataTable({
						"pageLength": 10,
						"processing": true,
						"ajax": {
							url: 'rooms/find_all',
							dataSrc: ''
						},
						"columns":[
						// {
						// 	"title": 'SYSID',
						// 	'data': 'sysid'
						// },
						{
							"title": 'Code',
							"data": 'code'	
						},
						{
							"title": 'Description',
							"data": 'descs'
						},
						{
							"title": 'Locations',
							"data": 'locations'
						},
						{
							"title": 'Capacity',
							"data": 'capacity'
						},
						{
							"title": "Control",
							"data": 'sysid',
							"render": function(data) {
								return "<button class='row_update btn btn-sm btn-default' href='' sysid='"+data+"'>Update</button> | <button class='row_block btn btn-sm btn-default' sysid='"+data+"'>Block</button> | <button class='row_delete btn btn-sm btn-default' sysid='"+data+"'>Delete</button>";
							}
						}
						]
					});

				}

				function refresh() {
					var table = $('#roomList').DataTable( {
					    ajax: "data.json"
					} );
					table.ajax.reload();
				}

				$("#add_new_modal_btn").on("click", function(){
					$("#add_new_modal").modal("show");
					$("#submit").text("Save");
					$("#entry_form")[0].reset();
					$("#modal_header_title").text("Modal Data Entry | New Class Room");
				});

				$("#entry_form").on("submit", function(e){
					e.preventDefault();
					if ($("#submit").text() == 'Save') {
						add(this);
					}
					if ($("#submit").text() == 'Update') {
						update(this);
					}
				});

				function add(form) {
					$.ajax({
						'url':'rooms/add_room',
						'type':'post',
						'data': new FormData(form),
						contentType: false,
						processData: false,
						success: function(data) {
							alert(data);
							$("#add_new_modal").modal("hide");
							$("#roomList").DataTable().ajax.reload(null, false);
						}
					});
				}

				function update(form) {
					$.ajax({
						'url': 'rooms/update_room',
						'type': 'post',
						'data': new FormData(form),
						contentType: false,
						processData: false,
						success: function(data) {
							alert(data);
							$("#add_new_modal").modal("hide");
							$("#roomList").DataTable().ajax.reload(null, false);
						}
					});
				}

				$(document).on("click", ".row_update", function(){
					$("#add_new_modal").modal("show");

					var sysid = $(this).attr('sysid');
					$("#sysid").val(sysid);

					$("#submit").text("Update");
					$("#modal_header_title").text("Modal Data Entry | Update Class Room");

					queryRoom(sysid);
				});	

				function queryRoom(sysid) {
					$.ajax({
						'url': 'rooms/get_room',
						'type': 'post',
						'data':{'sysid':sysid},
						success:function(data) {
							var room = JSON.parse(data)[0]
							$("#sysid").val(room['sysid']);
							$("#code").val(room['code']);
							$("#descs").val(room['descs']);
							$("#locations").val(room['locations']);
							$("#capacity").val(room['capacity']);
						}
					})
				}

				$(document).on("click", ".row_delete", function() {
					var sysid = $(this).attr('sysid');
					$.ajax({
						'method': 'POST',
						'url': 'rooms/delete_room',
						'data': {sysid:sysid},
						success:function(data) {
							alert(data);
							$("#roomList").DataTable().ajax.reload(null, false);
						}
					});
				});

				$(document).on("click", ".row_block", function(){
					var sysid = $(this).attr('sysid');
					$.ajax({
						'method': 'POST',
						'url': 'rooms/block_room',
						'data': {sysid:sysid},
						success:function(data) {
							alert(data);
						}
					});
				});

				$(document).on("click", ".close", function(){
					$("#add_new_modal").modal("hide");
				});

			});
		</script>
	</body>
	</html>