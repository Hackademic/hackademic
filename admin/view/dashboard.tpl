{include file="_header.tpl"}

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">{t}Dashboard{/t}</h3></div>
    </div><br/>

    <table id="dashboard_table">
	<tr>
	    <td>
		<p>
		    <a href="{$site_root_path}?url=admin/addarticle"  title="add article">
			<p><img src="{$site_root_path}admin/assets/images/addarticle.jpg"/></p>
			{t}Add New Article{/t}
		    </a>
		</p>
	    </td>
	    <td>
		<p>
		    <a href="{$site_root_path}?url=admin/articlemanager" title="articlemanager">
			<p><img src="{$site_root_path}admin/assets/images/articlemanager.jpg"/></p>
			{t}Article Manager{/t}
		    </a>
		</p>
	    </td>
	    <td>
		<p>
		    <a href="{$site_root_path}?url=admin/usermanager" title="add user">
			<p><img src="{$site_root_path}admin/assets/images/usermanager.jpg"/></p>
			{t}User Manager{/t}
		    </a>
		</p>
	    </td>
	</tr>
	<tr>
	    <td>
		<p>
		    <a href="{$site_root_path}?url=admin/addchallenge" title="add challenge">
			<p><img src="{$site_root_path}admin/assets/images/addchallenge2.PNG"/></p>
			{t}Add New Challenge{/t}
		    </a>
		</p>
	    </td>
	    <td>
		<p>
		    <a href="{$site_root_path}?url=admin/challengemanager" title="challenge manager"> 
			<p><img src="{$site_root_path}admin/assets/images/challengemanager.jpg"/></p>
			{t}Challenge Manager{/t}
		    </a>
		</p>
	    </td>
	   <!-- <td>
		<p>
		    <a href="{$site_root_path}?url=admin/globalconfiguration" title="configuration">
			<p><img src="{$site_root_path}admin/assets/images/configuration.jpg"/></p>
			Configuration
		    </a>
		</p>
	    </td>-->
	</tr>
    </table>
</div>
{include file="_footer.tpl"}
