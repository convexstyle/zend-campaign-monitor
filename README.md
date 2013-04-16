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
$campaignMonitor = new Convexstyle_Service_CampaignMonitor_Subscribe('API Key', 'List ID', Convexstyle_Service_CampaignMonitor_Subscribe::JSON);
try {
	$campaignMonitor->addSubscriber($values);
} catch(Exception $e) {
	// Deal with errors 
}
</pre>

## How to get started
<ul>
<li><a href="http://framework.zend.com/downloads/latest" target="_blank">Download Zend Framework Library</a>. (Please be aware that this libary is compatible with Zend Framework 1.+.)</li>
<li>Read <a href="http://www.campaignmonitor.com/api/getting-started/" target="_blank">Campaign Monitor Get Started Documentation</a>.</li>
</ul>


## Example Usage

### JSON Request
<pre>
$email = 'hoge@email.com';
$name  = 'your name';

$values = array(
	'EmailAddress' => $email,
	'Name'         => $name,
	'Resubscribe'  => 'true'
);
$campaignMonitor = new Convexstyle_Service_CampaignMonitor_Subscribe('API Key', 'List ID', <b>Convexstyle_Service_CampaignMonitor_Subscribe::JSON</b>);
try {
	$campaignMonitor->addSubscriber($values);
} catch(Exception $e) {
	// Deal with errors 
}
</pre>

### XML Request
<pre>
$email = 'hoge@email.com';
$name  = 'your name';

$values = array(
	'EmailAddress' => $email,
	'Name'         => $name,
	'Resubscribe'  => 'true'
);
$campaignMonitor = new Convexstyle_Service_CampaignMonitor_Subscribe('API Key', 'List ID', <b>Convexstyle_Service_CampaignMonitor_Subscribe::XML</b>);
try {
	$campaignMonitor->addSubscriber($values);
} catch(Exception $e) {
	// Deal with errors 
}
</pre>

### JSON Request with custom fields
<pre>
$email = 'hoge@email.com';
$name  = 'your name';

$values = array(
	'EmailAddress' => $email,
	'Name'         => $name,
	<b>'CustomFields' => array(
		array('Key' => 'website', 'Value' => 'http://www.hoge.com'),	
		array('Key' => 'interests', 'Value' => 'snowboard')	
	),</b>
	'Resubscribe'  => 'true'
);
$campaignMonitor = new Convexstyle_Service_CampaignMonitor_Subscribe('API Key', 'List ID', Convexstyle_Service_CampaignMonitor_Subscribe::JSON);
try {
	$campaignMonitor->addSubscriber($values);
} catch(Exception $e) {
	// Deal with errors 
}
</pre>

### Validate the success and error status
<pre>
$email = 'hoge@email.com';
$name  = 'your name';

$values = array(
    'EmailAddress' => $email,
    'Name'         => $name,
    'Resubscribe'  => 'true'
);
$campaignMonitor = new Convexstyle_Service_CampaignMonitor_Subscribe('API Key', 'List ID', Convexstyle_Service_CampaignMonitor_Subscribe::XML);
try {
    // Create a new contact
    <b>/*
    if($subscribe->status() == 200  && $subscribe->result() == $values['EmailAddress']) {
    	echo 'success';	
    }
    */
    
    // Resubscribe a contact
    if($subscribe->status() == 201  && $subscribe->result() == $values['EmailAddress']) {
    	echo 'success';	
    }</b>
} catch(Exception $e) {
    // Deal with errors 
    <b>Zend_Debug::dump($e->getBody());</b>
}
</pre>

### Unsubscribe with JSON Request
<pre>
$value = array(
    'EmailAddress' => 'hoge@email.com'
);
$campaignMonitor = new Convexstyle_Service_CampaignMonitor_Subscribe('Your API Key', 'Your List ID', <b>Convexstyle_Service_CampaignMonitor_Subscribe::JSON</b>);
try {
    $subscribe = $campaignMonitor->unsubscribe($value);
    if($subscribe->status() == 200) {
    	echo 'success';	
    }
} catch(Exception $e) {
    // Deal with errors 
    Zend_Debug::dump($e->getBody());
}
</pre>

### Unsubscribe with XML Request
<pre>
$value = array(
    'EmailAddress' => 'hoge@email.com'
);
$campaignMonitor = new Convexstyle_Service_CampaignMonitor_Subscribe('Your API Key', 'Your List ID', <b>Convexstyle_Service_CampaignMonitor_Subscribe::XML</b>);
try {
    $subscribe = $campaignMonitor->unsubscribe($value);
    if($subscribe->status() == 200) {
    	echo 'success';	
    }
} catch(Exception $e) {
    // Deal with errors 
    Zend_Debug::dump($e->getBody());
}
</pre>
