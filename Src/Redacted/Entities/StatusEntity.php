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

  /** @Column(type="text")
   * 'String' not sufficient to hold arbitrary seralized arrays, so 'text'.
   **/
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
      // @TODO: can Doctrine do this for us?
      if ($key == 'entities') {
        $this->$key = serialize($entityArray[$key]);
      }
    }
    // Allow chaining.
    return $this;
  }
  
  public function getEntities() {
    if (!empty($this->entities)) {
      return unserialize($this->entities);
    }
    return array();
  }
  
  public function getText() {
    return $this->text;
  }

  public function redactedText() {
    $textArray = str_split($this->text);
    $entities = $this->getEntities();
    foreach($entities as $entity) {
      foreach($entity as $redactable) {
        foreach($textArray as $index=>$char) {
          if (($index >= $redactable['indices'][0]) &&
            ($index < $redactable['indices'][1])) {
            $textArray[$index] = '*';
          }
        }
      }
    }
    return implode($textArray);
  }
  
  public function urlToOriginal() {
    // tweet: https://twitter.com/PaulMitchum/status/306642224291131393
    $urlItems = array(
      'https:/',
      'twitter.com',
      $this->from_user,
      'status',
      $this->id_str,
    );
    return implode($urlItems, '/');
  }

}

// assembled URLs:
// user: https://twitter.com/paulmitchum