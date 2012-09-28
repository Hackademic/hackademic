{include file="_header_frontend.tpl"}
<table id="articleTable">
{foreach from=$articles item=article}
    <tr>
        <td>
            <h3><a href="{$site_root_path}pages/readarticle.php?id={$article->id}">{$article->title}</a></h3>
            <div class="date">{$article->date_posted|date_format}</div>
        </td>
    </tr>
    <tr>
        <td>{$article->content|truncate:500}<br/><a href="{$site_root_path}pages/readarticle.php?id={$article->id}">Read More</a><hr/></td>
    </tr>
{/foreach}
</table>

<div id="paginate_div">{include file="_pagination_frontend.tpl"}</div>
<script type="text/javascript">
	if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
	  //  alert('you are browsing with firefox');
	}
        if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){
           // alert('you are browsing with ie');
        }
        if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
            //alert('you are browsing with opera browser');
        }
         if (/Chrome[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
            //alert('you are browsing with chrome browser');
        }
</script>
{include file="_footer_frontend.tpl"}