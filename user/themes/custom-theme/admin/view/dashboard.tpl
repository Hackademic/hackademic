{include file="_header.tpl"}

<div class="main_content">
    <div class="header_bar">
	<div class="page_title"><h3 class="left">Dashboard</h3></div>
    </div><br/>
    
    <table id="dashboard_table">
	<tr>
	    <td>
		<p>
		    <a href="{$site_root_path}?url=admin/addarticle"  title="add article">
			<p><img src="{$site_root_path}admin/assets/images/addarticle.jpg"/></p>
			Add New Article
		    </a>
		</p>
	    </td>
	    <td>
		<p>
		    <a href="{$site_root_path}?url=admin/articlemanager" title="articlemanager">
			<p><img src="{$site_root_path}admin/assets/images/articlemanager.jpg"/></p>
			Article Manager
		    </a>
		</p>
	    </td>
	    <td>
		<p>
		    <a href="{$site_root_path}?url=admin/usermanager" title="add user">
			<p><img src="{$site_root_path}admin/assets/images/usermanager.jpg"/></p>
			User Manager
		    </a>
		</p>
	    </td>
	</tr>
	<tr>
	    <td>
		<p>
		    <a href="{$site_root_path}?url=admin/addchallenge" title="add challenge">
			<p><img src="{$site_root_path}admin/assets/images/addchallenge2.PNG"/></p>
			Add New Challenge
		    </a>
		</p>
	    </td>
	    <td>
		<p>
		    <a href="{$site_root_path}?url=admin/challengemanager" title="challenge manager"> 
			<p><img src="{$site_root_path}admin/assets/images/challengemanager.jpg"/></p>
			Challenge Manager
		    </a>
		</p>
	    </td>
	    <td> 
		<p>
		    <a href="{$site_root_path}?url=admin/globalconfiguration" title="configuration">
			<p><img src="{$site_root_path}admin/assets/images/configuration.jpg"/></p>
			Configuration
		    </a>
		</p>
	    </td>
	</tr>
    </table>
</div>
{include file="_footer.tpl"}