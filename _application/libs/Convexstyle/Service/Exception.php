<?php


require_once('Zend/Exception.php');


class Convexstyle_Service_Exception extends Zend_Exception
{
	public function __construct($message, $code, $type, $body, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->_type = $type;
		$this->_body = $body;
	}
	
	public function getBody()
	{
		$body = '';
		switch ($this->_type)
		{
			case Convexstyle_Service_CampaignMonitor_Subscribe::JSON: {
				$body = json_decode($this->_body);
				break;
			}
			case Convexstyle_Service_CampaignMonitor_Subscribe::XML: {
				$body = simplexml_load_string($this->_body);
				break;
			}
		}
		return $body;
	}
	
	
	protected $_body;
	protected $_type;
}