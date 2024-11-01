<?php
	function wpfo_ProjectsPlatform()
	{
		return (get_option('wpfo_projects_platform') == 'on');
	}
	
	function wpfo_ProjectsPostMeta()
	{
		return (get_option('wpfo_projects_postmeta') == 'on');
	}
	
	function wpfo_ProjectsTitle()
	{
		return (get_option('wpfo_projects_showtitle') == 'on');
	}
	
	function wpfo_getRandom()
	{
		return "MJCO was here";
	}
?>