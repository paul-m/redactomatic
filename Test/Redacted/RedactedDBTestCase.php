<?php
namespace Redacted;

/**
* @file
* Some useful stuff to have in the namespace.
*/

abstract class RedactedDBTestCase extends \PHPUnit_Extensions_Database_TestCase
{
  // only instantiate pdo once for test clean-up/fixture load
  static private $pdo = null;
  
  // only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
  private $conn = null;
  
  final public function getConnection() {
    if ($this->conn === null) {
      // Generate a PDO object if we need it.
      if (self::$pdo == null) {
        self::$pdo = new \PDO('sqlite::memory:');
      }
      // Add the User table.
      // ./vendor/bin/doctrine orm:schema-tool:create --dump-sql
      self::$pdo->query('CREATE TABLE Statuses (id INT AUTO_INCREMENT NOT NULL, created_at VARCHAR(255) NOT NULL, from_user VARCHAR(255) NOT NULL, from_user_id_str VARCHAR(255) NOT NULL, id_str VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, entities LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;');
      // Generate the fixture.
      $this->conn = $this->createDefaultDBConnection(self::$pdo, 'User');
    }
    return $this->conn;
  }
  
  final public function getPDO() {
    // load up the singletons....
    $conn = $this->getConnection();
    // ..and hand one back.
    // Yes, the PHPUnit_Extensions_Database_DB_IDatabaseConnection
    // has the same method name.
    return $conn->getConnection();
  }

  public function __destruct() {
    $this->conn = NULL;
    self::$pdo = NULL;
  }

}

