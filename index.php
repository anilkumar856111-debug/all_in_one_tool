<?php
include('loader.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	
	<!-- DataTables CSS & JS -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	
	<script src="https://cdn.jsdelivr.net/npm/js-beautify@1.15.1/js/lib/beautify-html.min.js"></script>

	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">

	<title>All In One Tool</title>
</head>
<body>
	
	<?php include('parts/sidebar.php'); ?>

	<!-- CONTENT -->
	<section id="content">
		<?php include('parts/header.php'); ?>

		<!-- MAIN -->
		<main>
			<div class="head-title card">
				<div class="left">
					<h1 class="side_menu_title_class">Dashboard</h1>
					<ul class="breadcrumb">
						<li class="side_menu_class" data-side_menu_status="main_dashboard" data-side_menu_title="Dashboard">
							<a>Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<p class="side_menu_title_class">Home</p>
						</li>
					</ul>
				</div>
				<!--<a href="https://codepen.io/saglik216/pen/LEVjwBV" class="btn-download" target="_blink">
					<i class='bx bxs-cloud-download bx-fade-down-hover' ></i>
					<span class="text">V2.5 Released</span>
				</a>-->
			</div>
			<div class="main_dashboard_container">
				<?php include('module/dashboard.php'); ?>
			</div>
			
			<div class="main_create_csv_container">
				<?php include('module/create_csv.php'); ?>
			</div>
			
			<div class="main_view_csv_container">
				<?php include('module/csv_viewer.php'); ?>
			</div>
			<div class="main_html_viewer_container">
				<?php include('module/html_viewer.php'); ?>
			</div>
			<div class="main_Base64_container">
				<?php include('module/Base64.php'); ?>
			</div>
			
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<!--<button onclick="showToaster('Data Saved Successfully','success')">Show Success</button>
	<button onclick="showToaster('Something went wrong','error')">Show Error</button>
	<button onclick="showToaster('This is an info message','info')">Show Info</button>
	<button onclick="hideToaster()">Hide Toaster</button> -->


	<script>
		$(document).ready(function () {
			
			$('.main_create_csv_container').hide();
			$('.main_view_csv_container').hide();
			$('.main_html_viewer_container').hide();
			$('.main_Base64_container').hide();
			
			$(document).on('click' , '.side_menu_class' , function(){
				console.log($(this).data('side_menu_status'));
				var side_menu_status = $(this).data('side_menu_status');
				$('.side_menu_title_class').text($(this).data('side_menu_title'));
				
				if(side_menu_status == 'main_dashboard'){
					$('.main_dashboard_container').show();
					$('.main_create_csv_container').hide();
					$('.main_view_csv_container').hide();
					$('.main_html_viewer_container').hide();
					$('.main_Base64_container').hide();
				}else if(side_menu_status == 'create_csv'){
					$('.main_create_csv_container').show();
					$('.main_dashboard_container').hide();
					$('.main_view_csv_container').hide();
					$('.main_html_viewer_container').hide();
					$('.main_Base64_container').hide();
				}else if(side_menu_status == 'view_csv'){
					$('.main_view_csv_container').show();
					$('.main_create_csv_container').hide();
					$('.main_dashboard_container').hide();
					$('.main_html_viewer_container').hide();
					$('.main_Base64_container').hide();
				}else if(side_menu_status == 'html_viewer'){
					$('.main_html_viewer_container').show();
					$('.main_view_csv_container').hide();
					$('.main_create_csv_container').hide();
					$('.main_dashboard_container').hide();
					$('.main_Base64_container').hide();
				}else if(side_menu_status == 'Base64'){
					
					$('.main_html_viewer_container').hide();
					$('.main_view_csv_container').hide();
					$('.main_create_csv_container').hide();
					$('.main_dashboard_container').hide();
					$('.main_Base64_container').show();
				}
			});
			
			
			// Sidebar menu active state
			$('#sidebar .side-menu.top li a').click(function () {
				$('#sidebar .side-menu.top li').removeClass('active');
				$(this).parent().addClass('active');
			});

			// Toggle sidebar
			const $sidebar = $('#sidebar');
			$('#content nav .bx.bx-menu').click(function () {
				$sidebar.toggleClass('hide');
			});

			// Adjust sidebar on load and resize
			function adjustSidebar() {
				if ($(window).width() <= 576) {
					$sidebar.addClass('hide').removeClass('show');
				} else {
					$sidebar.removeClass('hide').addClass('show');
				}
			}
			$(window).on('load resize', adjustSidebar);

			// Search button toggle
			const $searchForm = $('#content nav form');
			const $searchButtonIcon = $('#content nav form .form-input button .bx');
			$('#content nav form .form-input button').click(function (e) {
				if ($(window).width() < 768) {
					e.preventDefault();
					$searchForm.toggleClass('show');
					if ($searchForm.hasClass('show')) {
						$searchButtonIcon.removeClass('bx-search').addClass('bx-x');
					} else {
						$searchButtonIcon.removeClass('bx-x').addClass('bx-search');
					}
				}
			});

			// Dark mode switch
			$('#switch-mode').change(function () {
				if ($(this).is(':checked')) {
					$('body').addClass('dark');
				} else {
					$('body').removeClass('dark');
				}
			});

			// Notification menu toggle
			$('.notification').click(function () {
				$('.notification-menu').toggleClass('show');
				$('.profile-menu').removeClass('show');
			});

			// Profile menu toggle
			$('.profile').click(function () {
				$('.profile-menu').toggleClass('show');
				$('.notification-menu').removeClass('show');
			});

			// Close menus if clicked outside
			$(window).click(function (e) {
				if (!$(e.target).closest('.notification, .profile').length) {
					$('.notification-menu, .profile-menu').removeClass('show');
				}
			});

			// Toggle menus
			window.toggleMenu = function (menuId) {
				const $menu = $('#' + menuId);
				$('.menu').not($menu).hide();
				$menu.toggle();
			};

			// Initially hide all menus
			$('.menu').hide();
		});

	</script>
</body>
</html>