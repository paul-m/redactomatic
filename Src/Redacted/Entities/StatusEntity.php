<?php
namespace Redacted;

/**
 * @Entity
 * @Table(name="Statuses")
 */
class StatusEntity {

  /** @Id @Column(type="integer") @GeneratedValue **/
  protected $id;
  
  /** @Column(type="string") **/
  protected $created_at;
  
  /** @Column(type="string") **/
  protected $from_user;
  
  /** @Column(type="string") **/
  protected $from_user_id_str;
  
  /** @Column(type="string") **/
  protected $id_str;
  
  /** @Column(type="string") **/
  protected $text;

  /** @Column(type="string") **/
  protected $entities;
  
  public function initFromJSON($json) {
    // Turn JSON into an array.
    $jsonArray = json_decode($json, TRUE);
    return $this->initFromArray($jsonArray);
  }

  public function initFromArray($entityArray) {
    // Gather all our properties.
    $properties = get_object_vars($this);
    // Grab JSON array elements for which we have properties.
    foreach($properties as $key=>$value) {
      // Nullify properties not in the JSON.
      $this->$key = NULL;
      if (isset($entityArray[$key])) {
        $this->$key = $entityArray[$key];
      }
      // Special case for 'entities', so we can serialize it.
      if ($key == 'entities') {
        $this->$key = serialize($entityArray[$key]);
      }
    }
    // Allow chaining.
    return $this;
  }

}

