<?php

require_once(TOOLS."cbSQLRetrieveData.php");
require_once(TOOLS."cbSQLConnectVar.php");
require_once(TOOLS."cbSQLConnectConfig.php");


class Parents
{

  protected static $table_name = "parents";
  protected static $db_fields = array('id', 'parent_id', 'gender', 'child');
  public static function get_db_fields()
  {
    $fields = array('id', 'parent_id', 'gender', 'child');
    return $fields;
  }
  public static function nameMe()
  {
    return "Parents";
  }

  // Attributes in parents table
  public $id;
  public $parent_id;
  public $gender;
  public $child;

  public static function dropByPerson($temp_id = NULL)
  {
    $database = cbSQLConnect::adminConnect('both');
    if (isset($database))
    {
      return $database->SQLDelete('parents', 'child', $temp_id);
    }
  }


  public static function dropById($temp_id = NULL)
  {
    $database = cbSQLConnect::adminConnect('both');
    if (isset($database))
    {
      return $database->SQLDelete('parents', 'id', $temp_id);
    }
  }

  public static function getByField($parent_id = NULL, $temp_id = NULL)
  {
    if ($temp_id && $parent_id)
    {
      $database = cbSQLConnect::connect('object');
      if (isset($database))
      {
        $name = self::$table_name;
        $sql = "SELECT * FROM $name WHERE `parent_id`=:parent_id AND `child`= :id";
        $params = array( ':parent_id' => $parent_id, ':id' => $temp_id);
        array_unshift($params, '');
        unset($params[0]);
        $results_array = $database->QueryForObject($sql, $params);
        return !empty($results_array) ? array_shift($results_array) : false;
      }
    }
  }

  public static function getAllParentsById($temp_id = NULL)
  {
    if ($temp_id)
    {
      $database = cbSQLConnect::connect('object');
      if (isset($database))
      {
        $name = self::$table_name;
        $sql = "SELECT * FROM $name WHERE `child`= :id";
        $params = array(':id' => $temp_id);
        array_unshift($params, '');
        unset($params[0]);
        $results_array = $database->QueryForObject($sql, $params);
        return !empty($results_array) ? $results_array : false;
      }
    }
  }

  public function save()
  {
    // return $this->id;
    return isset($this->id) ? $this->update() : $this->create();
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
      $insert = $database->SQLInsert($data, "parents");
      if ($insert)
      {
        return $insert;
      }
      else
      {
        return "Insert didn't compute";
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
        $flag = $database->SQLUpdate("parents", $key, $this->{$key}, "id", $this->id);
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
    $database = cbSQLConnect::connect('object');
    if (isset($database))
    {
      return ($database->SQLDelete(self::$table_name, 'id', $this->id));
    }
  }

  public static function createInstance($parent_id = NULL, $gender = NULL, $child = NULL)
  {
    $temp = Parents::getByField($parent_id, $child);
    // return $temp;
    if (!$temp)
    {
      $init = new Parents();
      $init->id = null;
      $init->parent_id = $parent_id;
      if ($gender == 'male')
      {
        $init->gender = 'father';
      }
      else
      {
        $init->gender = 'mother';
      }
      $init->child = $child;
      return $init;
    }
    else
    {
      $temp->parent_id = $parent_id;
      if ($gender == 'male')
      {
        $temp->gender = 'father';
      }
      else
      {
        $temp->gender = 'mother';
      }
      $temp->child = $child;
    }
    $init = recast('Parents', $temp);
    return $init;
  }

}


?>
