<?php
class Admin extends Profile
{
  private $a_currentAccount;

  public function __construct($p_email, $p_username, $p_password, $p_name, $p_lastname, $p_telephone, $a_currentAccount, $p_id = null)
  {
    parent::__construct($p_id, $p_email, $p_username, $p_password, $p_name, $p_lastname, $p_telephone);
    $this->a_currentAccount = $a_currentAccount;
  }

  public function getCurrentAccount()
  {
    return $this->a_currentAccount;
  }

  public function setCurrentAccount($a_currentAccount)
  {
    $this->a_currentAccount = $a_currentAccount;
  }

  public function show()
  {
    return "[ADMIN - " . parent::show() . " - Current Account: $this->a_currentAccount]";
  }
}
