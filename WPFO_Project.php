<?php
class WPFO_Project
{
	private $clientName;
	private $url;
	private $date;
	private $punp;
	private $clurl;
	private $clsec;
	private $pluginUrl;
	
	function WPFO_Project($clientName, $url, $date, $punp, $clurl, $clsec)
	{
		$this->clientName = $clientName;
		$this->url = $url;
		$this->date = $date;
		$this->punp = $punp;
		$this->clurl = $clurl;
		$this->clsec = $clsec;
		$url = get_bloginfo('wpurl');
		$this->pluginUrl = $url."/wp-content/plugins/wp-foliolio";
	}
	
	public static function getProject($projectID)
	{
		$custom = get_post_custom($projectID);
		$project = new WPFO_Project($custom["folio-clientname"][0], $custom["folio-url"][0], $custom["folio-date"][0], $custom["folio-punp"][0], $custom["folio-clurl"][0], $custom["folio-clsec"][0]);
		return $project;
	}
	
	/*Accessors*/
	public function getClient()
	{
		return $this->clientName;
	}
	
	public function getURL()
	{
		return $this->url;
	}
	
	public function getDate()
	{
		return date("jS F Y", strtotime($this->date));
	}
	public function getPunp()
	{
		return $this->punp;
	}
	public function getClurl()
	{
		return $this->clurl;
	}
	public function getClsec()
	{
		return $this->clsec;
	}
}