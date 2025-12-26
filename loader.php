<style>
    .main_loader_loader {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(0,0,0,0.7); 
		z-index: 9999;
		display: flex;
		justify-content: center;
		align-items: center;    
		transition: opacity 0.3s ease;
	}
	.main_loader_wrapper {
		text-align: center; 
	}
	.main_loader_dots-container {
		display: flex;
		justify-content: center; 
		gap: 12px;
	}
	.main_loader_dot {
		width: 15px;
		height: 15px;
		background-color: #0078d7;
		border-radius: 50%;
		animation: main_loader_bounceDot 1.2s infinite ease-in-out;
	}
	.main_loader_dot:nth-child(1) { animation-delay: 0s; }
	.main_loader_dot:nth-child(2) { animation-delay: 0.2s; }
	.main_loader_dot:nth-child(3) { animation-delay: 0.4s; }
	@keyframes main_loader_bounceDot {
		0%, 80%, 100% { transform: scale(0); }
		40% { transform: scale(1); }
	}
	.main_loader_text {
		margin-top: 15px;
		font-family: Segoe UI, sans-serif;
		font-size: 18px;
		color: #fff;
	}
	.main_loader_wrapper {
		display: inline-flex;
		flex-direction: column;
		align-items: center;
	}
    .main_loader_dots-container {
        display: flex;
        gap: 12px;
    }
    @keyframes main_loader_bounceDot {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
    .main_loader_content {
        padding: 20px;
        text-align: center;
    }
    .main_loader_extraContent {
        display: none;
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #0078d7;
        border-radius: 5px;
        background-color: #e6f0fa;
    }
    .main_loader_toggleContent {
        margin-top: 15px;
        padding: 10px 20px;
        font-size: 16px;
        background-color: #0078d7;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    .main_loader_toggleContent:hover {
        background-color: #005a9e;
    }
	
	
	
	
	.new_toaster_container {
		position: fixed;
		top: 60px;
		right: 30px;
		min-width: 260px;
		padding: 15px 20px;
		color: #fff;
		border-radius: 6px;
		display: none;
		box-shadow: 0 8px 20px rgba(0,0,0,0.25);
		z-index: 9999;
	}
	.new_toaster_success { background: green; }
	.new_toaster_error   { background: #dc3545; }
	.new_toaster_info    { background: #007bff; }
	.new_toaster_container .new_toaster_close {
		position: absolute;
		right: 12px;
		top: 60px;
		cursor: pointer;
		font-size: 18px;
	}
</style>
<div class="main_loader_loader" style="display:none;background-color:green;">
    <div class="main_loader_wrapper">
        <div class="main_loader_dots-container">
            <div class="main_loader_dot"></div>
            <div class="main_loader_dot"></div>
            <div class="main_loader_dot"></div>
        </div>
        <p class="main_loader_text">Loading, please wait...</p>
    </div>
</div>

<!-- Toaster -->
<div class="new_toaster_container">
    <span class="new_toaster_close" onclick="hideToaster()">×</span>
    <span class="new_toaster_msg"></span>
</div>

<script>
    function showLoader() {
        $('.main_loader_loader').fadeIn(300);
    }
    function hideLoader() {
        $('.main_loader_loader').fadeOut(300);
    }
	
	function showToaster(message = 'Hello Toaster!', type = 'info') {
		
		let $toaster = $(".new_toaster_container");

		$toaster.removeClass("new_toaster_success new_toaster_error new_toaster_info");
		$toaster.addClass("new_toaster_" + type);
		$(".new_toaster_msg").text(message);
		$toaster.stop(true,true).fadeIn(300);
		
		$('.new_toaster_sucess').css({'background-color': 'green'});
		setTimeout(function(){
			hideToaster();
		}, 1500); 
	}

	function hideToaster() {
		$(".new_toaster_container").fadeOut(300);
	}
</script>

