<div class="base_64_converter_card" style="background:#fff;margin-top:15px;padding:25px;border-radius:15px;box-shadow:0 15px 40px rgba(0,0,0,0.25);
">
    <h2 class="base_64_converter_title" style="text-align:center;margin-bottom:20px;color:#333;">🔐 Base64 Converter</h2>
    <textarea class="base_64_converter_input" placeholder="Text ya Base64 yahan likho..." style="width:100%;height:110px;padding:12px;border-radius:10px;border:1px solid #ccc;resize:none;font-size:14px;margin-bottom:15px;outline:none;"></textarea>
    <div class="base_64_converter_btn_group" style=" display:flex;gap:10px;margin-bottom:15px;">
        <button class="base_64_converter_encode" style="flex:1; padding:12px;border:none;border-radius:10px;font-size:15px;color:#fff;cursor:pointer;background:linear-gradient(135deg,#43cea2,#185a9d);
        ">Encode</button>
        <button class="base_64_converter_decode" style="flex:1;padding:12px;border:none;border-radius:10px;font-size:15px;color:#fff;cursor:pointer;background:linear-gradient(135deg,#ff758c,#ff7eb3);">Decode</button>
    </div>
    <textarea class="base_64_converter_output" placeholder="Result yahan dikhega..." style=" width:100%; height:110px;padding:12px;border-radius:10px;border:1px solid #ccc;resize:none;font-size:14px;outline:none;"></textarea>
</div>

<script>
$(document).ready(function () {

    $(".base_64_converter_encode").on("click", function () {
		//showLoader();
        let text = $(".base_64_converter_input").val();
        let encoded = btoa(unescape(encodeURIComponent(text)));
        $(".base_64_converter_output").val(encoded);
		//hideLoader();
    });

    $(".base_64_converter_decode").on("click", function () {
		//showLoader();
        let base64 = $(".base_64_converter_input").val();
        try {
            let decoded = decodeURIComponent(escape(atob(base64)));
            $(".base_64_converter_output").val(decoded);
        } catch (e) {
            //alert("Invalid Base64 String");
			showToaster('Invalid Base64 String','error');
        }
		//hideLoader();
    });

});
</script>