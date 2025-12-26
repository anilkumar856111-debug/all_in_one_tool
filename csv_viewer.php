<div class="file-container">
	<input type="file" id="csvFile" accept=".csv">
	<button id="resetBtn" style="padding:5px 10px; margin-left:10px; cursor:pointer; background:#dc3545; color:#fff; border:none; border-radius:5px;">Reset</button>
</div>

<div class="summary-cards">
	<div class="card">
		<i class='bx bx-list-ol'></i>
		<h3 id="totalRecords">0</h3>
		<p>Total Records</p>
	</div>
	<div class="card">
		<i class='bx bx-data'></i>
		<h3 id="fileSize">0 KB</h3>
		<p>File Size</p>
	</div>
	<div class="card">
		<i class='bx bx-show'></i>
		<h3 id="rowsPreview">0</h3>
		<p>Rows Preview</p>
	</div>
</div>

<div id="gotoPageContainer">
	<label for="gotoPage">Jump to Page: </label>
	<input type="number" id="gotoPage" min="1">
	<button id="gotoBtn">Go</button>
</div>

<table id="csvTable" class="display nowrap" style="width:100%">
	<thead></thead>
	<tbody></tbody>
</table>


<script>

$(document).ready(function () {
	let dataTable;

	function clearTable() {
		if ($.fn.DataTable.isDataTable('#csvTable')) {
			dataTable.clear().destroy();
			$('#csvTable thead').empty();
			$('#csvTable tbody').empty();
		}
	}

	function resetDashboard() {
		$('#totalRecords').text('0');
		$('#fileSize').text('0 KB');
		$('#rowsPreview').text('0');
		$('#gotoPage').val('');
		$('#csvFile').val(''); // reset file input
		clearTable();
	}

	$('#csvFile').on('change', function(e) {
		const file = e.target.files[0];
		if (!file) return;
		
		showLoader();
		
		clearTable();

		const sizeKB = (file.size / 1024).toFixed(2);
		$('#fileSize').text(`${sizeKB} KB`);

		const reader = new FileReader();
		reader.onload = function(event) {
			const text = event.target.result;
			const rows = text.split(/\r?\n/).filter(r => r.trim() !== '');
			if(rows.length === 0){
				hideLoader();
				showToaster('CSV is empty!','error');
				//alert("CSV is empty!");
				return;
			}

			let tableHead = '';
			let tableBody = '';
			let totalRecords = 0;

			const headerCols = rows[0].split(',').map(c => c.replace(/"/g, '').trim());
			const colCount = headerCols.length;

			tableHead += '<tr>';
			headerCols.forEach(col => tableHead += `<th>${col}</th>`);
			tableHead += '</tr>';

			for(let i=1; i<rows.length; i++){
				const cols = rows[i].split(',').map(c => c.replace(/"/g, '').trim());
				while(cols.length < colCount) cols.push('');
				while(cols.length > colCount) cols.splice(colCount);

				tableBody += '<tr>';
				cols.forEach(c => tableBody += `<td>${c}</td>`);
				tableBody += '</tr>';
				totalRecords++;
			}

			$('#csvTable thead').html(tableHead);
			$('#csvTable tbody').html(tableBody);

			$('#totalRecords').text(totalRecords);
			$('#rowsPreview').text(Math.min(totalRecords, 5));

			dataTable = $('#csvTable').DataTable({
				responsive: true,
				paging: true,
				searching: true,
				info: false,
				lengthChange: false
			});

			$('#gotoBtn').off('click').on('click', function() {
				const pageNumber = parseInt($('#gotoPage').val(), 10);
				if (!isNaN(pageNumber) && pageNumber > 0 && pageNumber <= dataTable.page.info().pages) {
					dataTable.page(pageNumber - 1).draw(false);
				} else {
					showToaster('Invalid page number!','error');
					//alert('Invalid page number!');
				}
			});
			
			hideLoader();
		};

		reader.readAsText(file);
	});

	// Reset button
	$('#resetBtn').on('click', function() {
		resetDashboard();
	});
});
</script>