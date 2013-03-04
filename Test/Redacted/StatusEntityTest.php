<?php
namespace Redacted;

class StatusEntityTest extends \PHPUnit_Framework_TestCase {
  public function testSettingProperties() {
    $items = array(
      'id' => 'id',
      'created_at' => 'created_at',
      'from_user' => 'from_user',
      'from_user_id_str' => 'from_user_id_str',
      'id_str' => 'id_str',
      'text' => 'text',
      'entities' => array('entities'),
    );
    $entity = new MockStatusEntity();
    $entity->initFromArray($items);
    $properties = $entity->getProperties();
    $this->assertEquals($properties, 
      ':id=id:created_at=created_at:from_user=from_user:from_user_id_str=from_user_id_str:id_str=id_str:text=text:entities=a:1:{i:0;s:8:"entities";}');
  }
}

