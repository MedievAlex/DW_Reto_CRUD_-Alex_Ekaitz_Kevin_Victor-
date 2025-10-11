<?php
abstract class Profile
{
  protected $email;
  protected $username;
  protected $password;
  protected $name;
  protected $lastname;
  protected $telephone;

  public function __construct($email, $username, $name, $password, $lastname, $telephone)
  {
    $this->email = $email;
    $this->username = $username;
    $this->password = $password;
    $this->name = $name;
    $this->lastname = $lastname;
    $this->telephone = $telephone;
  }

  public function getEmail()
  {
    return $this->email;
  }
  public function getUsername()
  {
    return $this->username;
  }
  public function getPassword()
  {
    return $this->password;
  }
  public function setPassword($password)
  {
    $this->password = $password;
  }
  public function getName()
  {
    return $this->name;
  }
  public function getLastname()
  {
    return $this->lastname;
  }
  public function getTelephone()
  {
    return $this->telephone;
  }

  abstract public function show();
}
