<?php
class User extends Profile
{
  private $gender;
  private $cardNumber;

  public function __construct($email, $username, $name, $password, $lastname, $telephone, $gender, $cardNumber)
  {
    parent::__construct($email, $username, $name, $password, $lastname, $telephone);
    $this->gender = $gender;
    $this->cardNumber = $cardNumber;
  }

  public function getGender()
  {
    return $this->gender;
  }

  public function getCardNumber()
  {
    return $this->cardNumber;
  }

  public function show()
  {
    return "[USER - " . parent::show() . " - Gender: $this->gender - Card Number: $this->cardNumber]";
  }
}
