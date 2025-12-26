<div style="display:flex;height:calc(100vh - 55px);">
    <div style="flex:1;display:flex;flex-direction:column;padding:10px;">
        <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
            <button onclick="beautify()" style="padding:6px 10px;border-radius:4px;border:none;cursor:pointer;background:#4b7bec;color:#fff;">Beautify HTML</button>

            <label style="font-size:14px;"><input type="checkbox" class="code_beatify_auto" checked> Auto</label>
            <select id="indent" style="padding:6px 10px;border-radius:4px;border:none;cursor:pointer;">
                <option value="2">2 Space</option>
                <option value="4" selected>4 Space</option>
            </select>
            <input type="file" accept=".html" onchange="loadFile(event)">
        </div>
        <textarea class="code_beatify_input" placeholder="Paste or type HTML here..." style="flex:1;resize:none;padding:10px;font-size:14px;border:1px solid #ccc;border-radius:4px;"></textarea>
    </div>

    <div style="flex:1;display:flex;flex-direction:column;padding:10px;">
        <div style="display:flex;align-items:center;gap:8px;margin-top: 20px;margin-bottom: 5px;">
            <button onclick="copyHTML()" style="padding:6px 10px;border-radius:4px;border:none;cursor:pointer;background:#20bf6b;color:#fff;">Copy</button>
            <button onclick="loadURL()" style="padding:6px 10px;border-radius:4px;border:none;cursor:pointer;background:#4b7bec;color:#fff;">Load URL</button>
        </div>
        <textarea class="code_beatify_output" readonly style="flex:1;resize:none;padding:10px;font-size:14px;border:1px solid #ccc;border-radius:4px;"></textarea>
    </div>

</div>
<script>
$(document).ready(function () {
	$('.new_toaster_sucess').css({'background-color': 'green'});

    const $input   = $(".code_beatify_input");
    const $output  = $(".code_beatify_output");
    const $preview = $(".code_beatify_preview");

    $input.on("input", function () {
        if ($(".code_beatify_auto").is(":checked")) {
            beautify();
        }
    });

    window.beautify = function () {
        let indentSize = parseInt($("#indent").val());

        if (isNaN(indentSize) || indentSize < 0) {
            indentSize = 2;
        }

        const beautified = html_beautify($input.val(), {
            indent_size: indentSize,
            indent_inner_html: true,
            wrap_line_length: 0,
            preserve_newlines: true,
            max_preserve_newlines: 2
        });

        $output.val(beautified);
        $preview.attr("srcdoc", beautified);
    };

    window.copyHTML = function () {
        $output.trigger("select");
        document.execCommand("copy");
		showToaster('Beautified HTML copied!','sucess');
        //alert("Beautified HTML copied!");
    };

    window.loadFile = function (e) {
        const reader = new FileReader();
        reader.onload = function () {
            $input.val(reader.result);
            beautify();
        };
        reader.readAsText(e.target.files[0]);
    };

    window.loadURL = function () {
        const url = prompt("Enter HTML URL:");
        if (!url) return;

        $.ajax({
            url: url,
            method: "GET",
            dataType: "text",
            success: function (data) {
                $input.val(data);
                beautify();
            },
            error: function () {
				showToaster('Failed to load URL','error');
                //alert("Failed to load URL");
            }
        });
    };

});
</script>