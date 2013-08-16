<script type="text/javascript" src="{$site_root_path}extlib/jQuery/jquery1.7.2.min.js"></script>
<script type="text/javascript">
    var path = "{$site_root_path}challenges/{$pkg_name}/";
    $(document).ready(function () {
        $("img").each(function () {
            var src = $(this).attr("src");
            if (src.substring(0, 4) != "http" ) {
                var length = src.length;
                for (var i=0; i<length; i++) {
                    if ((src[i] >= "a" && src[i] <= "z") || (src[i] >= "A" && src[i] <= "Z")) {
                        break;
                    }
                }
                new_src = src.substring(i, length);
                $(this).attr("src", path+new_src);
            }
        });
        $("form").each(function() {
            var action = $(this).attr("action");
            if (typeof action != 'undefined') {
                if (action.substring(0,4) != "http") {
                    var length = action.length;
                    for (var i=0; i<length; i++) {
                        if ((action[i] >= "a" && action[i] <= "z") || (action[i] >= "A" && action[i] <= "Z")) {
                            break;
                        }
                    }
                    new_action = path+action.substring(i, length);
                    $(this).attr("action", new_action);
                }
            }
        });
    });
</script>
