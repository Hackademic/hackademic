{include file="_header_frontend.tpl"}
<table id="articleTable">

    <tr>
        <td>
            <h3><a href="{$site_root_path}pages/readarticle.php?id={$article->id}">{$article->title}</a></h3>
            <div class="date">{$article->date_posted|date_format}</div>
        </td>
    </tr>
    <tr>
        <td>{$article->content}<hr/></td>
    </tr>

</table>
{include file="_footer_frontend.tpl"}