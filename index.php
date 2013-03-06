<?php
namespace Redacted;

require_once 'bootstrap.php';

use Guzzle\Http\Client;

\Slim\Slim::registerAutoloader();

// This should really be in the doctrine entity repostory
function ourMostRecentStatus() {
  global $entityManager;
	// Find the most recent status we have using DQL.
	$query = $entityManager->createQuery('SELECT max(s.id_str) FROM Redacted\StatusEntity s');
  $highest_id_str = $query->getSingleScalarResult();
  return $highest_id_str;
}

// Glean latest tweets via Twitter API
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
  // store the entities
	$entityManager->flush();
}

$app = new \Slim\Slim();
$view = $app->view();
$view->setTemplatesDirectory('./templates');

/**
 * Main page front controller.
 */
$app->get('/',
  'Redacted\gleanNewestStatus',
	function () use ($app, $entityManager) {
  	$app->contentType('text/html; charset=utf-8');

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

		$app->render('index.tpl.php', array('redactedStatuses' => $statusHTML));
	}
);

/**
 * 'API' to return newest since given id_str.
 */
$app->get('/since/:idstr',
  'Redacted\gleanNewestStatus',
  function ($idstr) use ($app, $entityManager) {
    //$app->contentType('javascript....');
    
  	// Get the latest since.
    $queryBuilder = $entityManager->createQueryBuilder();
    $queryBuilder->add('select', 's')
       ->add('from', 'Redacted\StatusEntity s')
       ->add('where', 's.id_str > :idstr')
       ->add('orderBy', 's.id_str DESC')
       ->setParameter('idstr', $idstr);

    $query = $queryBuilder->getQuery();
    $statuses = $query->getResult();
    $json = array();
    foreach($statuses as $statusEntity) {
      $json[] = $statusEntity->redactedObject();
    }
    $res = $app->response();
    $res['Content-Type'] = 'application/json';
    $res->body(json_encode($json));
  }
);

$app->run();

