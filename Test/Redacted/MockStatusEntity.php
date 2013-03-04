<?php
namespace Redacted;

class MockStatusEntity extends StatusEntity {
  public function getProperties() {
    $properties = get_object_vars($this);
//    $properties = sort($properties);
    $result = '';
    foreach($properties as $property=>$value) {
      $result .= ':' . $property . '=' . $this->$property;
    }
    return $result;
  }

}

