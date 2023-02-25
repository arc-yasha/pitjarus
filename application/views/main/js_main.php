<script>
	const baseUrl = "<?php echo base_url(); ?>";

	const notif = (message) => {
		$('.notif').html(message);
		setTimeout(() => {
			$('.notif').html('');
		}, 2000);
	}

	$('.dateFrom').datepicker({
		format: 'dd-mm-yyyy',
	});
	$('.dateTo').datepicker({
		format: 'dd-mm-yyyy',
	});

	const ctx = document.getElementById('myChart').getContext("2d");
	const myChartJS = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: [],
			datasets: [{
				label: 'Nilai',
				data: [],
				backgroundColor: ["#3e95cd"],
				datalabels: {
					color: 'white',
					anchor: 'end',
					align: 'bottom',
					font: {
						weight: 'bold'
					}
				}
			}],
		},
		plugins: [ChartDataLabels],
		options: {
			plugins: {
				legend: {
					labels: {
						usePointStyle: true,
						pointStyle: true,
					},
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'Percentage (%)',
					position: 'left'
				},
			},
		}
	});

	const showChartAndTable = async (dataParams = '') => {
		notif(`<b class="text-success">Mohon tunggu, data sedang diload...</b>`)
		let options = {};
		if (dataParams == '') {
			options = {
				method: 'GET'
			}
		} else {
			options = {
				headers: {
					'Content-Type': 'application/json'
				},
				mode: 'no-cors',
				method: 'POST',
				body: dataParams
			}
		}
		await fetch(`${baseUrl}main/get_data`, options)
			.then((response) => response.json())
			.then((result) => {
				showChart(result);
				showTable(result);
				notif(`<b class="text-success">Data berhasil diload...</b>`)
			})
	}

	const showChart = (result) => {
		const areas = result.areas
		const percentages = result.percentage
		myChartJS.data.labels = [];
		myChartJS.data.datasets[0].data = [];
		areas.forEach(area => myChartJS.data.labels.push(area.area_name))
		percentages.forEach(percentage => myChartJS.data.datasets[0].data.push(percentage))
		myChartJS.update();
	}

	const showTable = (result) => {
		const areas = result.areas
		const brands = result.brands
		let headerTable = `<tr><th scope="col">Brand</th>`;
		areas.map(area => {
			headerTable += `<th scope="col">${area.area_name}</th>`
		});
		headerTable += `</tr>`;
		$('.table-head').html(headerTable);

		let bodyTableContent = '';
		brands.map((brand, brand_idx) => {
			let bodyTable = `<tr><td>${brand.brand_name}</td>`;
			areas.map((area, area_idx) => {
				bodyTable += `<td>${result.compliance_area_brand[brand_idx][area_idx]} %</td>`
			});
			bodyTable += `</tr>`;
			bodyTableContent += bodyTable;
		});

		$('.table-data').html(bodyTableContent);
	}

	showChartAndTable();
	$('.submit-button').click(function () {
		const area_id = $('.area').val();
		const dateFrom = $('.dateFrom').val();
		const dateTo = $('.dateTo').val();
		if (area_id != '' && dateFrom != '' && dateTo != '') {
			var dataParams = new FormData();
			dataParams.append('area_id', area_id);
			dataParams.append('dateFrom', dateFrom);
			dataParams.append('dateTo', dateTo);
			showChartAndTable(dataParams);
		} else {
			notif(`<b class="text-danger">Mohon lengkapi semua inputan diatas...</b>`)
		}
	})

</script>
