<h2><?= $title ?></h2>
<button class="btn btn-primary" data-toggle="add_new_modal" id="add_new_modal_btn">Add new</button>
<hr>
<table class="display" id="departmentsList" style="width: 100%"></table>

<!-- Modal -->
<div class="modal fade" role="dialog" id="add_new_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 id="modal_header_title">Modal Data Entry | New Department</h5>
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
						<input type="text" name="descriptions" id="descriptions" class="form-control" placeholder="Description">
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

<script type="text/javascript">
	$(document).ready(function() {

		loadDepartments();

		// Loads data into the table
		function loadDepartments() {

			$("#departmentsList").DataTable({
				"pageLength": 10,
				"processing": true,
				"ajax": {
					url: 'departments/get_departments',
					dataSrc: ''
				},
				"columns":[
				{
					"title": 'Code',
					"data": 'code'	
				},
				{
					"title": 'Description',
					"data": 'descriptions'
				},
				{
					"title": "Control",
					"data": 'sysid',
					"render": function(data) {
						return "<button class='row_update btn btn-sm btn-default' href='' sysid='"+data+"'>Update</button> | <button class='row_delete btn btn-sm btn-default' sysid='"+data+"'>Delete</button>";
					}
				}
				]
			});

		}

		function refresh() {
			var table = $('#departmentsList').DataTable( {
				ajax: "data.json"
			} );
			table.ajax.reload();
		}

		$("#add_new_modal_btn").on("click", function(){
			$("#add_new_modal").modal("show");
			$("#submit").text("Save");
			$("#entry_form")[0].reset();
			$("#modal_header_title").text("Modal Data Entry | New Department");
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
				'url':'departments/add',
				'type':'post',
				'data': new FormData(form),
				contentType: false,
				processData: false,
				success: function(data) {
					alert(data);
					$("#add_new_modal").modal("hide");
					$("#departmentsList").DataTable().ajax.reload(null, false);
				}
			});
		}

		function update(form) {
			$.ajax({
				'url': 'departments/update',
				'type': 'post',
				'data': new FormData(form),
				contentType: false,
				processData: false,
				success: function(data) {
					alert(data);
					$("#add_new_modal").modal("hide");
					$("#departmentsList").DataTable().ajax.reload(null, false);
				}
			});
		}

		$(document).on("click", ".row_update", function(){
			$("#add_new_modal").modal("show");

			var sysid = $(this).attr('sysid');
			$("#sysid").val(sysid);

			$("#submit").text("Update");
			$("#modal_header_title").text("Modal Data Entry | Update Department");

			queryDepartment(sysid);
		});	

		function queryDepartment(sysid) {
			$.ajax({
				'url': 'departments/get_department',
				'type': 'post',
				'data':{'sysid':sysid},
				success:function(data) {
					var deparment = JSON.parse(data)[0]
					$("#sysid").val(deparment['sysid']);
					$("#code").val(deparment['code']);
					$("#descriptions").val(deparment['descriptions']);
				}
			})
		}

		$(document).on("click", ".row_delete", function() {
			var sysid = $(this).attr('sysid');
			$.ajax({
				'method': 'POST',
				'url': 'departments/delete',
				'data': {sysid:sysid},
				success:function(data) {
					alert(data);
					$("#departmentsList").DataTable().ajax.reload(null, false);
				}
			});
		});

		$(document).on("click", ".close", function(){
			$("#add_new_modal").modal("hide");
		});

	});
</script>