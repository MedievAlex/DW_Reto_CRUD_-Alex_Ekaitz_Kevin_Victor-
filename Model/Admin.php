<?php
class Admin extends Profile
{
  private $currentAccount;

  public function __construct($email, $username, $name, $password, $lastname, $telephone, $currentAccount)
  {
    parent::__construct($email, $username, $name, $password, $lastname, $telephone);
    $this->currentAccount = $currentAccount;
  }

  public function getCurrentAccount()
  {
    return $this->currentAccount;
  }

  public function mostrar()
  {
    return "[ADMIN - " . parent::mostrar() . " - Current Account: $this->currentAccount]";
  }
}
