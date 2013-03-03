<?php
namespace Redacted;

require_once 'vendor/autoload.php';
require_once 'bootstrap_doctrine.php';

use Guzzle\Http\Client;

\Slim\Slim::registerAutoloader();

// This should really be in the entity repostory
function ourMostRecentStatus() {
  global $entityManager;
	// Find the most recent status we have using DQL.
	$query = $entityManager->createQuery('SELECT max(s.id_str) FROM Redacted\StatusEntity s');
  $highest_id_str = $query->getSingleScalarResult();
  return $highest_id_str;
}

// Grabs the latest tweets
function gleanNewestStatus() {
  global $entityManager;

	// Guzzle....
	$client = new Client('http://search.twitter.com');
	$request = $client->get('/search.json?q=%23secondlife&include_entities=true&result_type=recent&since_id=' . ourMostRecentStatus());
	$response = $request->send();
	
	$statuses = json_decode($response->getBody(), TRUE);
	$statuses = $statuses['results'];

	$statusEntities = array();
	
	foreach($statuses as $status) {
		$statusEntity = new StatusEntity();
		$statusEntity->initFromArray($status);
		$statusEntities[] = $statusEntity;
		$entityManager->persist($statusEntity);
  }
	$entityManager->flush();
}

$app = new \Slim\Slim();

$app->get('/',
  'Redacted\gleanNewestStatus',
	function () use ($app, $entityManager) {
	  $new_highest = ourMostRecentStatus();

	  // get the newest one
		$aStatus = $entityManager->getRepository('Redacted\StatusEntity')
		              ->findOneBy(array('id_str' => $new_highest));

		$app->response()->body(
		  '<div>highest: ' . $new_highest . '</div>' .
  		'<pre>'.print_r($aStatus,TRUE).'</pre>'
    );
	}
);

$app->run();

// assembled URLs:
// tweet: https://twitter.com/PaulMitchum/status/306642224291131393
// user: https://twitter.com/paulmitchum

