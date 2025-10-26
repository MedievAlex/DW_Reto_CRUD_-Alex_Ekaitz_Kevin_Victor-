<?php
include_once 'Gender.php';
include_once 'Profile.php';

class User extends Profile
{
  private $u_gender;
  private $u_card;

  public function __construct($p_email, $p_username, $p_password, $p_name, $p_lastname, $p_telephone, $u_gender, $p_id = null, $u_card = null)
  {
    parent::__construct($p_id, $p_email, $p_username, $p_password, $p_name, $p_lastname, $p_telephone);
    $this->u_gender = $u_gender;
    $this->u_card = $u_card;
  }

  public function getGender()
  {
    return $this->u_gender;
  }

  public function setGender($gender)
  {
    $this->u_gender = $gender;
  }

  public function getCard()
  {
    return $this->u_card;
  }

  public function setCard($card)
  {
    $this->u_card = $card;
  }

  public function show()
  {
    return "[USER - " . parent::toString() . " - Gender: $this->u_gender]";
  }
}
