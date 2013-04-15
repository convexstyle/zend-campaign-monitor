<?php
/**
 * Convexstyle_Service_CampaignMonitor_Subscribe_ResultSet class.
 * 
 * @author:    Hiroshi Tazawa
 * @version:   1.0
 * @copyright: 2011, canvasgroup.com.au
 * @license:   canvasgroup.com.au
 * @version:   Release: @1.0@
 * @since:     Class available Since Release 1.0
 */


class Convexstyle_Service_CampaignMonitor_Subscribe_ResultSet
{

	
	public function __construct($data, $type)
	{
		switch($type) {
			case Convexstyle_Service_CampaignMonitor_Subscribe::XML:
				$this->_result = simplexml_load_string($data);
				break;
			case Convexstyle_Service_CampaignMonitor_Subscribe::JSON:
				$this->_result = json_decode($data);
				break;
			default:
				break;
		}
	}
	
	
	public function result()
	{
		return $this->_result;
	}
	
	
	public function __destruct()
	{
		
	}

	
	private $_result;
	
	
}