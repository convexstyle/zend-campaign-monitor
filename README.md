This is the small library to integrate with Campaign Monitor API using Zend_Http_Request in Zend Framework 1 (ZF 2 is not supported yet). It covers only the subscribe and unsubscribe APIs, that are often used in projects, so far.

The step to send the basic user information (email and username) to campaign monitor is pretty easy.

<pre>
$email = 'hoge@email.com';
$name  = 'your name';

$values = array(
	'EmailAddress' => $email,
	'Name'         => $name,
	'Resubscribe'  => 'true'
);
$campaignMonitor = new Convexstyle_Service_CampaignMonitor_Subscribe('Your Campaign Monitor API Key', 'Your Compaign Monitor List ID', Convexstyle_Service_CampaignMonitor_Subscribe::JSON);
try {
	$campaignMonitor->addSubscriber($values);
} catch(Exception $e) {
	// Deal with errors 
}
</pre>

## How to get started
<ul>
<li><a href="http://framework.zend.com/downloads/latest" target="_blank">Download Zend Framework Library</a>. (Please be aware that this libary is compatible with Zend Framework 1.+.)</li>
</ul>


## Example Usage

### JSON Request

### XML Request

### JSON Request with some custom fields
<pre>
$email = 'hoge@email.com';
$name  = 'your name';

$values = array(
	'EmailAddress' => $email,
	'Name'         => $name,
	'CustomFields' => array(
		array('Key' => 'website', 'Value' => 'http://www.hoge.com'),	
		array('Key' => 'interests', 'Value' => 'snowboard')	
	),
	'Resubscribe'  => 'true'
);
$campaignMonitor = new Convexstyle_Service_CampaignMonitor_Subscribe('Your Campaign Monitor API Key', 'Your Compaign Monitor List ID', Convexstyle_Service_CampaignMonitor_Subscribe::JSON);
try {
	$campaignMonitor->addSubscriber($values);
} catch(Exception $e) {
	// Deal with errors 
}
</pre>
