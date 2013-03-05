<?php
namespace Redacted;

class StatusEntityTest extends \PHPUnit_Framework_TestCase {

  public function statusArrayDataProvider() {
    $items = array(
      'id' => 'id',
      'created_at' => 'created_at',
      'from_user' => 'from_user',
      'from_user_id_str' => 'from_user_id_str',
      'id_str' => 'id_str',
      'text' => 'text',
      'entities' => array('entities'),
    );
    return array(array($items));
  }

  public function statusArrayDataProviderEntities() {
    $items = array(
      'id' => 'id',
      'created_at' => 'created_at',
      'from_user' => 'from_user',
      'from_user_id_str' => 'from_user_id_str',
      'id_str' => 'id_str',
      'text' => 'text',
      'entities' => array(
        'entitytype' => array(
          'entity' => array(
            'indices' => array(23,77),
          ),
        ),
      ),
    );
    return array(array($items));
  }


  public function badStatusArrayDataProvider() {
    return array(array(array()));
  }

  /**
   * @dataProvider statusArrayDataProvider
   */
  public function testSettingProperties($items) {
    $entity = new MockStatusEntity();
    $entity->initFromArray($items);
    $properties = $entity->getProperties();
    $this->assertEquals($properties, ':id=id:created_at=created_at:from_user=from_user:from_user_id_str=from_user_id_str:id_str=id_str:text=text:entities=a:1:{i:0;s:8:"entities";}');
  }

  /**
   * @dataProvider statusArrayDataProvider
   */
  public function testUrlToOriginal($items) {
    $entity = new MockStatusEntity();
    $entity->initFromArray($items);
    $properties = $entity->urlToOriginal();
    $this->assertEquals($properties, 'https://twitter.com/from_user/status/id_str');
  }

  /**
   * @dataProvider badStatusArrayDataProvider
   */
  public function testBadUrlToOriginal($items) {
    $entity = new MockStatusEntity();
    $entity->initFromArray($items);
    $properties = $entity->urlToOriginal();
    $this->assertEquals($properties, '');
  }
  
  /**
   * @dataProvider statusArrayDataProviderEntities
   * Turns out we don't actually need statusJSON().
   */
  public function tes__tJSON($items) {
    $entity = new StatusEntity();
    $entity->initFromArray($items);
    $json = $entity->statusJSON();
    $this->assertEquals($json, '{"redactedStatus":"text","originalURL":"https:\/\/twitter.com\/from_user\/status\/id_str"}');
  }

  /**
   * @dataProvider statusArrayDataProviderEntities
   * Turns out we don't actually need statusJSON().
   */
  public function testRedactedObject($items) {
    $entity = new StatusEntity();
    $entity->initFromArray($items);
    $redacted = $entity->redactedObject();
    $this->assertTrue(isset($redacted->redactedStatus));
    $this->assertTrue(isset($redacted->originalURL));
  }

}

