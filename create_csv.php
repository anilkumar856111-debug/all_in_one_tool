<!-- EXPORT MODAL BODY -->
<div class="agent-modal-body" style="background:#f9f9f9;padding:20px;border-radius:8px;box-shadow:0 0 8px rgba(0,0,0,0.1);margin: auto;margin-top: 15px;">

	<div style="margin-bottom:18px;">
		<label>Export Type</label>
		<select class="call_log_export_type" style="width:280px;">
			<option value="last_100">Last 100 Records</option>
			<option value="last_500">Last 500 Records</option>
			<option value="last_1000">Last 1000 Records</option>
			<option value="last_2000">Last 2000 Records</option>
			<option value="last_3000">Last 3000 Records</option>
			<option value="between">Between Records</option>
			<option value="custom">Custom Record Count</option>
		</select>
	</div>

	<div class="call_log_between_box" style="display:none;margin-bottom:18px;">
		<label>Record Range</label>
		<input type="number" class="call_log_range_from" placeholder="From (eg: 1000)" style="width:120px;">
		<span style="margin:0 8px;">to</span>
		<input type="number" class="call_log_range_to" placeholder="To (eg: 2000)" style="width:120px;">
	</div>

	<div class="call_log_custom_count_box" style="display:none;margin-bottom:18px;">
		<label>Custom Record Count</label>
		<input type="number" class="call_log_custom_count" placeholder="Enter record count" style="width:220px;">
	</div>

	<div style="margin-bottom:18px;">
		<label>Sort Order</label>
		<select class="call_log_sort_order" style="width:200px;">
			<option value="latest">Latest First</option>
			<option value="oldest">Oldest First</option>
		</select>
	</div>

	<div style="text-align:right;border-top:1px solid #ddd;padding-top:15px;">
		<button class="call_log_export_btn" style="background:#2f6f95;color:#fff;">Export Records</button>
	</div>

</div>


<script>

$(document).ready(function () {
/* ==========================DUMMY JSON DATA (10k)========================== */
	const jsonData = {
		success: true,
		data: {
			data: [
				{
					id: "1",
					agent_name: "Agent 1",
					customer_name: "Anil",
					customer_phone: "+917807794041",
					direction: "outbound",
					body: "Test message",
					status: "sent",
					sent_at: "2025-12-24 02:49:46"
				},
				...Array.from({ length: 100000 }, (_, i) => ({
					id: (131147 - i).toString(),
					agent_name: `Agent ${(i % 5) + 1}`,
					customer_name: `Customer ${i + 1}`,
					customer_phone: `+91${9000000000 + i}`,
					direction: i % 2 === 0 ? "outbound" : "inbound",
					body: `Dummy message ${i + 1}`,
					status: i % 3 === 0 ? "sent" : "received",
					sent_at: `2025-12-${String((i % 28) + 1).padStart(2, '0')} ${String(i % 23).padStart(2, '0')}:30:00`
				}))
			].flat()
		}
	};

	/* ==========================SHOW / HIDE FIELDS========================== */
	$('.call_log_export_type').on('change', function(){
		const type = $(this).val();
		$('.call_log_between_box').hide();
		$('.call_log_custom_count_box').hide();

		if(type === 'between'){
			$('.call_log_between_box').show();
		}
		if(type === 'custom'){
			$('.call_log_custom_count_box').show();
		}
	});

	/* ==========================CSV EXPORT FUNCTION========================== */
	function exportToCsv(filename, rows) {
		if (!rows.length) {
			showToaster('No records found','info');
			//alert('No records found');
			return;
		}

		const keys = Object.keys(rows[0]);
		const csv =
			keys.join(',') + '\n' +
			rows.map(row =>
				keys.map(k => `"${(row[k] ?? '').toString().replace(/"/g,'""')}"`).join(',')
			).join('\n');

		const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
		const link = document.createElement('a');
		link.href = URL.createObjectURL(blob);
		link.download = filename;
		document.body.appendChild(link);
		link.click();
		document.body.removeChild(link);
		
		hideLoader();
	}

	/* ==========================MAIN EXPORT LOGIC========================== */
	$('.call_log_export_btn').on('click', function(){
		showLoader();
		let records = [...jsonData.data.data];

		const exportType = $('.call_log_export_type').val();
		const sortOrder  = $('.call_log_sort_order').val();

		// SORT
		records.sort((a,b) => {
			return sortOrder === 'latest'
				? new Date(b.sent_at) - new Date(a.sent_at)
				: new Date(a.sent_at) - new Date(b.sent_at);
		});

		// EXPORT TYPE
		if(exportType === 'last_100') records = records.slice(0,100);
		if(exportType === 'last_500') records = records.slice(0,500);
		if(exportType === 'last_1000') records = records.slice(0,1000);
		if(exportType === 'last_2000') records = records.slice(0,2000);
		if(exportType === 'last_3000') records = records.slice(0,3000);

		if(exportType === 'between'){
			const from = parseInt($('.call_log_range_from').val());
			const to   = parseInt($('.call_log_range_to').val());

			if(!from || !to || from >= to){
				showToaster('Enter valid From and To values','error');
				//alert('Enter valid From and To values');
				return;
			}
			records = records.slice(from - 1, to);
		}

		if(exportType === 'custom'){
			const count = parseInt($('.call_log_custom_count').val());
			if(!count || count <= 0){
				showToaster('Enter valid record count','error');
				//alert('Enter valid record count');
				return;
			}
			records = records.slice(0, count);
		}
		
		function generateExportName() {
			const now = new Date();
			const uniqueId = now.getHours().toString().padStart(2, '0') +
							 now.getMinutes().toString().padStart(2, '0') +
							 now.getSeconds().toString().padStart(2, '0');
			const ampm = now.getHours() >= 12 ? 'PM' : 'AM';
			return 'Exported_CallLogs_' + uniqueId + ' ' + ampm+'.csv';
		}

		// Example use
		let fileName = generateExportName();

		exportToCsv(fileName, records);
	});
	
});
</script>