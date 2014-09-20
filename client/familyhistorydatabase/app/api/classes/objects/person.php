<?php


require_once(TOOLS."cbSQLRetrieveData.php");
require_once(TOOLS."cbSQLConnectVar.php");
require_once(TOOLS."cbSQLConnectConfig.php");


class Person
{

  protected static $table_name = "person";
  protected static $db_fields = array('id', 'firstName', 'middleName', 'lastName', 'yearBorn', 'yearDead', 'yearB', 'yearD', 'relationship','profile_pic', 'sex');
  public static function get_db_fields()
  {
    $fields = array('id', 'firstName', 'middleName', 'lastName', 'yearBorn', 'yearDead', 'yearB', 'yearD', 'relationship','profile_pic', 'sex');
    return $fields;
  }
  public static function nameMe()
  {
    return "Person";
  }

  // Attributes in person table
  public $id;
  public $firstName;
  public $middleName;
  public $lastName;
  public $yearBorn;
  public $yearDead;
  public $yearB;
  public $yearD;
  public $relationship;
  public $profile_pic;
  public $sex;


  public static function dropByPerson($temp_id = NULL)
  {
    $database = cbSQLConnect::adminConnect('both');
    if (isset($database))
    {
      return $database->SQLDelete('person', 'id', $temp_id);
    }
  }




  public static function getIndividuals()
  {
    $database = cbSQLConnect::connect('object');
    $result = array();
    if (isset($database))
    {
      $people = $database->QuerySingle("SELECT * FROM `person` ORDER BY `lastName`");
      if ($people)
      {
        foreach($people as $aperson)
        {
          $temp = array();
          $aperson = recast("Person", $aperson);
          $aperson->displayName = $aperson->displayName();
          $aperson->selectName = $aperson->selectName();
          $temp[] = $aperson->firstName;
          $temp[] = $aperson->lastName;
          $temp[] = $aperson->yearBorn;
          $temp[] = $aperson->yearDead;
          $temp[] = $aperson->id;
          $temp[] = $aperson->middleName;
          $temp['data'] = $aperson;
          $result[] = $temp;
        }
        return $result;
      }
      else
      {
        return "none";
      }
    }
  }

  public static function getSearchInd($search = null)
  {
    $database = cbSQLConnect::connect('object');
    $result = array();
    if (isset($database)) {
      $finalTarget = '';
      $target = explode(' ', $search);
      $target = '+'.implode(' +', $target).'*';

      // Here we have to prepare the statment using PDO 'quote'... Apparently the AGAINST
      // must have a constant string to work with or it breaks... so we can't prepare the statement...
      $target = $database->prepareQuote($target);

      $people = $database->QuerySingle("SELECT *, MATCH(firstName, middleName, lastName) AGAINST(".$target." IN BOOLEAN MODE) AS score FROM `person` WHERE MATCH(firstName, middleName, lastName) AGAINST(".$target." IN BOOLEAN MODE) ORDER BY score DESC LIMIT 0, 10");
      if ($people) {
        foreach($people as $aperson) {
          $aperson = recast("Person", $aperson);
          $aperson->displayableName = $aperson->displayName();
          $aperson->selectableName = $aperson->selectName();
          $aperson->typeahead = $aperson->selectName()." (".$aperson->yearBorn.")";
          $result[] = $aperson;
        }
        return $result;
      } else {
        return false;
      }
    }
  }


  public static function getNumPics()
  {
    $database = cbSQLConnect::connect('object');
    $result = array();
    if (isset($database))
    {
      $num_pics = $database->QuerySingle("SELECT * FROM person WHERE `profile_pic` IS NOT NULL;");
      if ($num_pics)
      {
        $result[0] = "success";
        $result[1] = count($num_pics);
        $result[2] = array();
        $count = 0;
        foreach ($num_pics as $individual)
        {
          $result[2][$count] = File::getById($individual->profile_pic);
          $result[2][$count]->individual_id = $individual->id;
          $count++;
        }
        return $result;
      }
      else
      {
        return null;
      }
    }
  }

  public static function getLastNames($letter)
  {
    $database = cbSQLConnect::connect('array');
    if (isset($database))
    {
      $data = $database->QuerySingle("SELECT DISTINCT * FROM `person` WHERE `lastName` LIKE '".$letter."%' GROUP BY `lastName`");
      if (count($data) == 0)
      {
        return NULL;
      }
      else
      {
        return $data;
      }
    }
  }

  public static function getFirstNames($lastname)
  {
    $database = cbSQLConnect::connect('array');
    if (isset($database))
    {
      $data = $database->QuerySingle("SELECT * FROM `person` WHERE `lastName` LIKE '".$lastname."%' ORDER BY `firstName`");
      if (count($data) == 0)
      {
        return NULL;
      }
      else
      {
        return $data;
      }
    }
  }

  public static function getById($id = NULL)
  {
    if ($id)
    {
      $database = cbSQLConnect::connect('object');
      if (isset($database))
      {
        $name = self::$table_name;
        $person = $database->getObjectById('person', $id);
        if ($person) {
          $person = recast('Person', $person);
        }
        return $person;
      }
    }
    else
      return NULL;
  }

  public function appendNames()
  {
    $this->displayableName = $this->displayName();
    $this->selectableName = $this->selectName();
    $this->typeahead = $this->selectName()." (".$this->yearBorn.")";
  }

  public function displayName()
  {
    $name = $this->firstName." ";
    if ($this->middleName)
    {
      $name .= $this->middleName." ";
    }
    $name .= $this->lastName;
    return $name;
  }

  public function selectName()
  {
    $name = $this->lastName.", ";
    $name .= $this->firstName;
    if ($this->middleName)
    {
      $name .= " ".$this->middleName;
    }
    return $name;
  }


  public function getParents()
  {

    $database = cbSQLConnect::connect('object');
    if (isset($database))
    {
      $data = $database->QuerySingle("SELECT * FROM `parents` WHERE `child`='".$this->id."' ORDER BY `gender`");
      return $data;
    }

  }
  public static function getParentsById($id = NULL)
  {

    $database = cbSQLConnect::connect('object');
    if (isset($database))
    {
      $data = $database->QuerySingle("SELECT * FROM `parents` WHERE `child`='".$id."' ORDER BY `gender`");
      return $data;
    }

  }

  public function getChildren()
  {

    $database = cbSQLConnect::connect('object');
    if (isset($database))
    {
      $data = $database->QuerySingle("SELECT * FROM `parents` WHERE `parentId`='".$this->id."' ORDER BY `gender`");
      return $data;
    }

  }

  public static function getChildrenById($id = NULL)
  {

    $database = cbSQLConnect::connect('object');
    if (isset($database))
    {
      $data = $database->QuerySingle("SELECT * FROM `parents` WHERE `parentId`='".$id."' ORDER BY `gender`");
      return $data;
    }

  }

  public function getSpouse()
  {

    $database = cbSQLConnect::connect('object');
    if (isset($database))
    {
      $data = $database->QuerySingle("SELECT * FROM `spouse` WHERE `personId`='".$this->id."'");
      return $data;
    }

  }

  public static function getSpouseById($id = NULL)
  {

    $database = cbSQLConnect::connect('object');
    if (isset($database))
    {
      $data = $database->QuerySingle("SELECT * FROM `spouse` WHERE `personId`='".$id."'");
      return $data;
    }

  }

  public function save()
  {
    // return $this->id;
    return isset($this->id) ? $this->update() : $this->create();
  }

  public function setProfilePic($pic_id)
  {
    $database = cbSQLConnect::connect('object');
    if (isset($database))
    {
      $this->profile_pic = $pic_id;
      return $this->save();
    }
  }

  // create the object if it doesn't already exits.
  protected function create()
  {
    $database = cbSQLConnect::connect('object');
    if (isset($database))
    {
      $fields = self::$db_fields;
      $data = array();
      foreach($fields as $key)
      {
        if ($this->{$key})
        {
          $data[$key] = $this->{$key};
        }
        else
          $data[$key] = NULL;

      }

      // return $data;
      // return true if sucess or false
      $insert = $database->SQLInsert($data, "person");
      if ($insert)
      {
        return $insert;
      }
      else
      {
        return false;
      }
    }
  }

  // update the object if it does already exist.
  protected function update()
  {
    $database = cbSQLConnect::connect('object');
    if (isset($database))
    {
      $fields = self::$db_fields;
      foreach($fields as $key)
      {
        $flag = $database->SQLUpdate("person", $key, $this->{$key}, "id", $this->id);
        if ($flag == "fail")
        {
          break;
        }
      }
      if ($flag == "fail")
      {
        return false;
      }
      else
        return $this->id;
    }
  }

  // Delete the object from the table.
  public function delete()
  {
    $database = cbSQLConnect::adminConnect('object');
    if (isset($database))
    {
      return ($database->SQLDelete(self::$table_name, 'id', $this->id));
    }
  }



  public static function createInstance($data = NULL)
  {
    $init = new Person();

    $init->id          = NULL;
    $init->firstName   = $data['fninput'];
    $init->middleName  = $data['mninput'];
    $init->lastName    = $data['lninput'];
    if ($data['birth_date'])
    {
      $date = $data['birth_date'];
      $date = explode("/", $date);
      $init->yearBorn = $date[2];
      if (isset($data['birth_date_overide']))
      {
        $init->yearB = false;
      }
      else
      {
        $init->yearB = true;
      }
    }
    if ($data['death_date'] )
    {
      $date = $data['death_date'];
      $date = explode("/", $date);
      $init->yearDead = $date[2];
      if (isset($data['death_date_overide']))
      {
        $init->yearD = true;
      }
      else
      {
        $init->yearD = false;
      }
    }
    $init->sex = $data['sex'];
    $init->relationship = $data['relationship_to_michele'];

    return $init;
  }


}


?>
