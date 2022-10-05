<?php
$query = $_SERVER["QUERY_STRING"];
$string = preg_replace('/action=edit&gid=/','',$query);
$db = MySql::getInstance();
$data = $db->query("SELECT * FROM ".DB_PREFIX."markdown WHERE logid ='".$string."'");
$row = $db->fetch_array($data);
if($row != ""){
    $content = $row["content"];
    echo '<textarea id="markdown_emlog_xiaocao" style="display:none;">'.$content.'</textarea>';
}
?>
<link rel="stylesheet" href="<?php echo BLOG_URL; ?>content/plugins/emlog_markdown/styles/editormd.css" />
<header>
                <p>
                    <select id="editormd-theme-select">
                        <option selected="selected" value="">select Editor.md themes</option>
                    <option value="default">default</option><option value="dark">dark</option></select>
                    <select id="editor-area-theme-select">
                        <option selected="selected" value="">select editor area themes</option>
                    <option value="default">default</option><option value="3024-day">3024-day</option><option value="3024-night">3024-night</option><option value="ambiance">ambiance</option><option value="ambiance-mobile">ambiance-mobile</option><option value="base16-dark">base16-dark</option><option value="base16-light">base16-light</option><option value="blackboard">blackboard</option><option value="cobalt">cobalt</option><option value="eclipse">eclipse</option><option value="elegant">elegant</option><option value="erlang-dark">erlang-dark</option><option value="lesser-dark">lesser-dark</option><option value="mbo">mbo</option><option value="mdn-like">mdn-like</option><option value="midnight">midnight</option><option value="monokai">monokai</option><option value="neat">neat</option><option value="neo">neo</option><option value="night">night</option><option value="paraiso-dark">paraiso-dark</option><option value="paraiso-light">paraiso-light</option><option value="pastel-on-dark">pastel-on-dark</option><option value="rubyblue">rubyblue</option><option value="solarized">solarized</option><option value="the-matrix">the-matrix</option><option value="tomorrow-night-eighties">tomorrow-night-eighties</option><option value="twilight">twilight</option><option value="vibrant-ink">vibrant-ink</option><option value="xq-dark">xq-dark</option><option value="xq-light">xq-light</option></select>
                    <select id="preview-area-theme-select">
                        <option selected="selected" value="">select preview area themes</option>
                    <option value="default">default</option><option value="dark">dark</option></select>
                </p>
            </header>
<div id="aaaaa">
<textarea style="display:none;" >
</textarea>
</div>
        </div>
        <script src="<?php echo BLOG_URL; ?>content/plugins/emlog_markdown/scripts/editormd.min.js"></script>
        <script type="text/javascript">
            function themeSelect(id, themes, lsKey, callback)
            {
                var select = $("#" + id);
                
                for (var i = 0, len = themes.length; i < len; i ++)
                {                    
                    var theme    = themes[i];
                    var selected = (localStorage[lsKey] == theme) ? " selected=\"selected\"" : "";
                    
                    select.append("<option value=\"" + theme + "\"" + selected + ">" + theme + "</option>");
                }
                
                select.bind("change", function(){
                    var theme = $(this).val();
                    
                    if (theme === "")
                    {
                        alert("theme == \"\"");
                        return false;
                    }
                    
                    console.log("lsKey =>", lsKey, theme);
                    
                    localStorage[lsKey] = theme;
                    callback(select, theme);
                }); 
                
                return select;
            }
            
			var testEditor;

            $(function() {
                
                $('.ke-container').hide();
                $(".show_advset:first").hide();
                $("#tag_label").hide();
                var context = $('#markdown_emlog_xiaocao').val()?$('#markdown_emlog_xiaocao').val():$('#content').val();
                $('#content').parent().remove();
                $('#FrameUpload').hide();
                testEditor = editormd("aaaaa", {
                    width   : "100%",
                    height  : 640,
                    value   : context,
                    theme        : (localStorage.theme) ? localStorage.theme : "default",
                    // Preview container theme, added v1.5.0
                    // You can also custom css class .editormd-preview-theme-xxxx
                    previewTheme : (localStorage.previewTheme) ? localStorage.previewTheme : "default", 
                    // Added @v1.5.0 & after version is CodeMirror (editor area) theme
                    editorTheme  : (localStorage.editorTheme) ? localStorage.editorTheme : "default", 
                    syncScrolling : "single",
                    path    : "<?php echo BLOG_URL; ?>content/plugins/emlog_markdown/scripts/lib/",
                    htmlDecode : "style,script,iframe,sub,sup|on*",  // Filter tags, and all on* attributes
                    saveHTMLToTextarea : true,
                    toolbarAutoFixed : false,
                    htmlDecode : "style,script,iframe,sub,sup,embed|onclick,title,onmouseover,onmouseout,style", // Filter tags, and your custom attributes
                    imageUpload : true,
                    imageFormats : ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
                    imageUploadURL : "<?php echo BLOG_URL; ?>content/plugins/emlog_markdown/upload/upload1.php?action=upload"
                });
                
                themeSelect("editormd-theme-select", editormd.themes, "theme", function($this, theme) {
                    testEditor.setTheme(theme);
                });
                
                themeSelect("editor-area-theme-select", editormd.editorThemes, "editorTheme", function($this, theme) {
                    testEditor.setCodeMirrorTheme(theme); 
                    // or testEditor.setEditorTheme(theme);
                });
                
                themeSelect("preview-area-theme-select", editormd.previewThemes, "previewTheme", function($this, theme) {
                    testEditor.setPreviewTheme(theme);
                }); 
            });
        </script>
        </script>