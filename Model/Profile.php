<?php
abstract class Profile
{
  protected $p_id;
  protected $p_email;
  protected $p_username;
  protected $p_password;
  protected $p_name;
  protected $p_lastname;
  protected $p_telephone;

  protected function __construct($p_id, $p_email, $p_username, $p_password, $p_name, $p_lastname, $p_telephone)
  {
    $this->p_id = $p_id;
    $this->p_email = $p_email;
    $this->p_username = $p_username;
    $this->p_password = $p_password;
    $this->p_name = $p_name;
    $this->p_lastname = $p_lastname;
    $this->p_telephone = $p_telephone;
  }

  public function getEmail()
  {
    return $this->p_email;
  }

  public function setEmail($p_email)
  {
    $this->p_email = $p_email;
  }

  public function getUsername()
  {
    return $this->p_username;
  }

  public function setUsername($p_username)
  {
    $this->p_username = $p_username;
  }

  public function getPassword()
  {
    return $this->p_password;
  }

  public function setPassword($p_password)
  {
    $this->p_password = $p_password;
  }

  public function getName()
  {
    return $this->p_name;
  }

  public function setName($p_name)
  {
    $this->p_name = $p_name;
  }

  public function getLastname()
  {
    return $this->p_lastname;
  }

  public function setLastname($p_lastname)
  {
    $this->p_lastname = $p_lastname;
  }

  public function getTelephone()
  {
    return $this->p_telephone;
  }

  public function setTelephone($p_telephone)
  {
    $this->p_telephone = $p_telephone;
  }

  abstract public function show();
}
