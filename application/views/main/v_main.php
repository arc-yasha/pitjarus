<div class="container mb-5">
	<div class="mt-5">
		<div class="row">
			<div class="col-md-3">
				<select class="form-select input-sm area" aria-label="Area">
					<option value="" selected>Select Area</option>
					<?php foreach ($areas->result() as $area) {
						echo '<option value="'.$area->area_id.'">'.$area->area_name.'</option>';
					} ?>
				</select>
			</div>
			<div class="col-md-3">
				<input type="text" class="form-control dateFrom" data-provide="datepicker" placeholder="Select dateFrom"
					value="">
			</div>
			<div class="col-md-3">
				<input type="text" class="form-control dateTo" data-provide="datepicker" placeholder="Select dateTo"
					value="">
			</div>
			<div class="col-md-3 d-flex justify-content-start align-items-center">
				<button class="btn btn-primary btn-block submit-button">View</button>
			</div>
		</div>

		<div class="notif mt-2 d-flex justify-content-center justify-item-center text-danger"></div>
	</div>
	<hr>
	<div class="mt-5">
		<canvas id="myChart" style="width:100%;height:300px;"></canvas>
	</div>
	<hr>
	<div class="mt-5">
		<table class="table table-striped">
			<thead class="table-head">
				<tr>
					<th scope="col" rowsapan="6" align="center">Loading data ...</th>
				</tr>
			</thead>
			<tbody class="table-data">
				<tr>
					<td scope="col" rowsapan="6" align="center">Loading data ...</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
