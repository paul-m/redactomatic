<?php
namespace Redacted;

require_once 'bootstrap.php';

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
	$request = $client->get('/search.json?q=%23redacted&include_entities=true&result_type=recent&since_id=' . ourMostRecentStatus());
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

//$app = new \Slim\Slim();
$app = new \Slim\Slim();

$app->contentType('text/html; charset=utf-8');
$view = $app->view();
$view->setTemplatesDirectory('./templates');

$app->get('/',
  'Redacted\gleanNewestStatus',
	function () use ($app, $entityManager) {
  	// Get the newest 10
    $queryBuilder = $entityManager->createQueryBuilder();
    
    $queryBuilder->add('select', 's')
       ->add('from', 'Redacted\StatusEntity s')
       ->add('orderBy', 's.id_str DESC')
       ->setMaxResults( 10 );
    
    $query = $queryBuilder->getQuery();
    $statuses = $query->getResult();
    
    $statusHTML = '';
    foreach($statuses as $aStatus) {
    		$statusHTML .= $aStatus->statusHTML();
    }

		$app->render('index.tpl.php', array('content' => $statusHTML));
	}
);

$app->run();

