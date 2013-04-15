<?php
/**
 * Convexstyle_Service_CampaignMonitor_Subscribe class.
 * 
 * @author:    Hiroshi Tazawa
 * @version:   1.0
 * @copyright: 2011, canvasgroup.com.au
 * @license:   canvasgroup.com.au
 * @version:   Release: @1.0@
 * @since:     Class available Since Release 1.0
 */


class Convexstyle_Service_CampaignMonitor_Subscribe
{
	
	
	/**
	 * Base URI of adding a subscriber 
	 */
	const SUBSCRIBER_URI_BASE = 'http://api.createsend.com/api/v3/subscribers/';
	
	/**
	 * Request and response type - XML 
	 */
	const XML  = 'xml';
	
	/**
	 * Request and response type - JSON 
	 */
	const JSON = 'json';
	
	
	const XML_VERSION = '1.0';

	
	const XML_ENCODING = 'UTF-8';
	
	
	public function __construct($apiKey, $listId, $type = self::XML)
	{
		$this->_apiKey = $apiKey;
		$this->_listId = $listId;
		$this->_type   = $type;
	}
	
	
	/**
	 * Function to add a subscriber to the list.
	 * @param Array $values
	 * @return Convexstyle_Service_CampaignMonitor_Subscribe_ResultSet
	 * To use this Api, please keep the following array.
	 * $values = array(
	 *    'EmailAddress' => 'hoge@subscriber.com',
	 *    'Name'         => 'User Name',
     *    'CustomFields' => array(
     *        array('Key' => 'website', 'Value' => 'http://www.hoge.org/'),	
     *        array('Key' => 'interests', 'Value' => 'hoge'),	
     *     ),
     *    'Resubscribe' => 'true'
     * );
	 */
	public function addSubscriber($values)
	{
		// Prepare the post data.
		$values = $this->_prepareValuesForSubscribe($values);
		if($this->_type == self::XML) {
			$values = substr($values, strlen("<?xml version=\"1.0\" encoding=\"UTF-8\"?>"));
		}
		
		// Set the URI.
		$uri  = self::SUBSCRIBER_URI_BASE
		      . $this->_listId
		      . '.'
		      . $this->_type;

		// Create the Zend_Http_Client object.
		$httpClient = $this->getZendHttpClient($uri);
		$httpClient->setAuth($this->_apiKey, 'magic', Zend_Http_Client::AUTH_BASIC);
		$httpClient->setRawData($values);
		$httpClient->setEncType(Zend_Http_Client::ENC_URLENCODED);
		$response = $httpClient->request(Zend_Http_Client::POST);

		if($response->isError()) {
			throw new Convexstyle_Service_Exception($response->getMessage(), $response->getStatus(), $this->_type, $response->getBody());
		}
		
		// Return the Convexstyle_Service_CampaignMonitor3_Result object.
		return new Convexstyle_Service_CampaignMonitor_Subscribe_ResultSet($response->getBody(), $this->_type);
	}
	
	
	/**
	 * Function to unscribe an email address
	 * @param String $email
	 * To use this Api, please keep the following array.
	 * $value = array(
	 *   "EmailAddress": "hoge@subscriber.com"
	 * );
	 */
	public function unsubscribe($value)
	{
		if(!array_key_exists('EmailAddress', $value)) {
			throw new Exception('Key: EmailAddress is not provided in the array.');
		}
		
		// Prepare the post data
		$value = $this->_prepareVariablesForUnsubscribe($value);
		
		// Set the URI
		$uri = self::SUBSCRIBER_URI_BASE
		     . $this->_listId
		     . '/unsubscribe.'
		     . $this->_type;

		// Create the Zend_Http_Client object.
		$httpClient = $this->getZendHttpClient($uri);
		$httpClient->setAuth($this->_apiKey, 'magic', Zend_Http_Client::AUTH_BASIC);
		$httpClient->setRawData($value);
		$httpClient->setEncType(Zend_Http_Client::ENC_URLENCODED);
		$response = $httpClient->request(Zend_Http_Client::POST);
		
		if($response->isError()) {
			throw new Convexstyle_Service_Exception($response->getMessage(), $response->getStatus(), $this->_type, $response->getBody());
		}
		
		// Return the Convexstyle_Service_CampaignMonitor3_Result object.
		return new Convexstyle_Service_CampaignMonitor_Subscribe_ResultSet($response->getBody(), $this->_type);
	}
	
	
	public function getZendHttpClient($uri)
	{
		if(null === $this->_client) {
			$this->_client = new Zend_Http_Client();
			$this->_client->setUri($uri);
		}
		return $this->_client;
	}
	
	
	private function _prepareValuesForSubscribe($values)
	{
		$tmp;
		switch ($this->_type) {
			case self::XML:
				$dom               = new DOMDocument('1.0', 'UTF-8');
				$dom->formatOutput = true;
				$subscriberNode    = $dom->appendChild(new DOMElement('Subscriber'));
				$subscriberNode->appendChild(new DOMElement('EmailAddress', $values['EmailAddress']));
				$subscriberNode->appendChild(new DOMElement('Name', $values['Name']));
				$customFieldsNode = $subscriberNode->appendChild(new DOMElement('CustomFields'));
				if(array_key_exists('CustomFields', $values)) {
					foreach($values['CustomFields'] as $customField) {
						$customFieldNode = $customFieldsNode->appendChild(new DOMElement('CustomField'));
						foreach($customField as $key => $value) {
							$customFieldNode->appendChild(new DOMElement($key, $value));
						}
					}
				}
				$subscriberNode->appendChild(new DOMElement('Resubscribe', $values['Resubscribe']));
				$dom->appendChild($subscriberNode);
				$tmp = $dom->saveXML();
				break;
			case self::JSON:
				$tmp = Zend_Json::encode($values); 
				break;
			default:
				break;
		}
		return $tmp;
	}
	
	private function _prepareVariablesForUnsubscribe($value)
	{
		$tmp;
		switch ($this->_type) {
			case self::XML: {
				$dom               = new DOMDocument(self::XML_VERSION, self::XML_ENCODING);
				$dom->formatOutput = true;
				$subscriberDom = $dom->createElement('subscriber');
				$subscriberDom->appendChild($dom->createElement('EmailAddress', $value['EmailAddress']));
				$dom->appendChild($subscriberDom);
				$tmp = $dom->saveXML();
				break;
			}
			case self::JSON: {
				$tmp = Zend_Json::encode($value);
				break;
			}
			default:
				break;
		}
		return $tmp;
	}
	
	
	private $_apiKey;
	private $_listId;
	private $_type;
	private $_client;

	
}


class CustomDomElement extends DOMElement
{
	
	public function __construct($name, $value, $uri, $isCData = false){
		if($isCData) $value = '<![CDATA[' . $value . ']]>';
		parent::__construct($name, $value, $uri);
	}
	
}