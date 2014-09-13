<?php

/* /////////////////////////////////////////////////////////////////////////
Essential Files to Include
///////////////////////////////////////////////////////////////////////// */
error_reporting(E_ALL);
ini_set("display_errors", 1);
require_once("../library/paths.php");

// Load the Config File
require_once(LIBRARY."config.php");

// Load the functions so that everything can use them
require_once(LIBRARY."functions.php");

// Load the core objects
// require_once(CLASSES."mysqli_database.php");

require_once(OBJECTS."birth.php");
require_once(OBJECTS."death.php");
require_once(OBJECTS."burial.php");
require_once(OBJECTS."parents.php");
require_once(OBJECTS."person.php");
require_once(OBJECTS."spouse.php");
require_once(OBJECTS."place.php");
require_once(OBJECTS."file.php");
require_once(OBJECTS."connections.php");


require_once(TOOLS."user.php");
require_once(TOOLS."favorites.php");
require_once(TOOLS."pagination.php");
require_once(TOOLS."url.php");
require_once(TOOLS."mySession.conf.php");
require_once(TOOLS."mySession.class.php");
require_once(TOOLS."cbSQLConnect.class.php");

$session = mySession::getInstance();
require_once 'api.php';
class MyAPI extends API
{

  protected $User;

  public function __construct($request, $origin) {
    parent::__construct($request);

    // Abstracted out for example
    // $APIKey = new Models\APIKey();
    // $User = new Models\User();

    // if (!array_key_exists('apiKey', $this->request)) {
    //   throw new Exception('No API Key provided');
    // } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
    //   throw new Exception('Invalid API Key');
    // } else if (array_key_exists('token', $this->request) &&
    //  !$User->get('token', $this->request['token'])) {

    //   throw new Exception('Invalid User Token');
    // }

    $this->User->name = "Jonathan";
  }

  /**
  * Example of an Endpoint (where we grab the verbs and arguments and then do
  * something with them...)
  */
  protected function example($args) {
    echo $this->verb;
    echo "\n";
    if ($this->method == 'GET') {
      return "Your name is " . $this->User->name . " and " . serialize($args);
    } else {
      return "Only accepts GET requests";
    }
  }

  /**
  * Example of an Endpoint
  */
  protected function process($args) {
    echo $this->verb;
    echo "\n";
    if ($this->method == 'GET') {
      return "Things have changed " . $this->User->name . " and " . serialize($args);
    } else {
      return "Only accepts GET requests";
    }
  }


  protected function user($args) {
    require_once(APIROOT.'controller/user.php');
    if ($this->method === 'POST') {
      if ($this->verb === 'login') {
        $result = $this->file;
        $result = login(isset($result->username)? $result->username: null,
          isset($result->password)? $result->password: null);
        return $result;
      } else if ($this->verb === 'logout') {
        return $session->logout();
      } else if ($this->verb === 'register') {
        $result = $this->file;
        $result->username = isset($result->username)? $result->username: null;
        $result->password = isset($result->password)? $result->password: null;
        $result->email = isset($result->email)? $result->email: null;
        $result->first = isset($result->first)? $result->first: null;
        $result->last = isset($result->last)? $result->last: null;
        $result->gender = isset($result->gender)? $result->gender: null;

        $result = register($result);
        return $result;
      }
    }
    if ($this->method === 'GET') {
      if ($this->verb === 'validate') {
        $id = getRequest('id');
        $value = getRequest('validate');
        return validate($id, $value);
      }
      if ($this->verb === 'isLoggedIn') {
        $user = User::current_user();
        unset($user->password);
        return $user;
      }
      $user = User::current_user();
      unset($user->password);
      return $user;
      // return "This is a test";
    } else {
      return "Only accepts GET AND POSTS requests";
    }
  }

  protected function typeahead($args) {
    if ($this->method === 'GET') {
      $session = mySession::getInstance();
      // if ($session->isLoggedIn()) {
      $value = getRequest('typeahead');
      $list = Person::getSearchInd($value);
      return $list;
      // } else {
      // return false;
      // }
    }else {
      return "Only accepts GET requests";
    }
  }

  protected function profilePic($args){
    if ($this->method === 'GET') {
      if ($this->verb == "") {
        $id = intval(array_shift($args));
        if ($id && is_numeric($id)) {
          $pic = File::getById($id);
          return $pic;
        }
      } else if ($this->verb === 'person') {
        $id = intval(array_shift($args));
        if ($id && is_numeric($id)) {
          $person = Person::getById($id);
          if (!empty($person->profile_pic)) {
            $pic = File::getById($person->profile_pic);
            return $pic;
          }
        }
      }
    }
    return $first;
  }

  protected function individual($args) {
    if ($this->method === 'GET') {
      $id = intval(array_shift($args));
      if ($id && is_numeric($id)) {
        $session = mySession::getInstance();
        if ($id > -1) {
          $person = Person::getById($id);
          if ($person) {
            $person->appendNames();
            $person->birth = Birth::getById($id);
            if ($person->birth) {
              $person->birth->birthPlace = Place::getById($person->birth->place);
            }
            $person->death = Death::getById($id);
            if ($person->death) {
              $person->death->deathPlace = Place::getById($person->death->place);
            }
            $person->burial = Burial::getById($id);
            if ($person->burial) {
              $person->burial->burialPlace = Place::getById($person->burial->place);
            }
            $person->parents = Parents::getParentsOf($id);
            $person->children = Parents::getChildrenOf($id);
            $person->spouse = Spouse::getById($id);
            return $person;
          } else {
            return false;
          }
        } else {
          return false;
        }
      }
      // } else {
      // return false;
      // }
    } else if ($this->method === 'POST' || $this->method === 'PUT'){
      $result = $this->file;
      if (empty($result) || empty($result->person) || empty($result->birth) || empty($result->death)) {
        return false;
      }
      $person = recast('Person', $result->person);
      if (!empty($person)) {
        $personId = $person->save();
      } else {
        return false;
      }
      $birth = recast('Birth', $result->birth);
      $birth->personId = $personId;
      $birthId = $birth->save();
      $birth->id = $birthId;
      $death = recast('Death', $result->death);
      $death->personId = $personId;
      $deathId = $death->save();
      $death->id = $deathId;
      if ($result->burial) {
        $burial = recast('Burial', $result->burial);
        $burial->personId = $personId;
        $burialId = $burial->save();
        $burial->id = $burialId;
      } else {
        $burial = Burial::getSomething('id', $person->id);
        if ($burial) {
          $burial = Burial::getById($burial);
          if ($burial) {
            $burial = recast('Burial', $burial);
          }
        }
      }
      if (empty($personId) || empty($birthId) || empty($deathId)) {
        return false;
      }
      if ($result->birthPlace) {
        $birthPlace = recast('Place', $result->birthPlace);
        $birthPlace->ft_name = "birth";
        $birthPlace->fkey = $birthId;
        $birth->place = $birthPlace->save();
        $birth->save();
      } else {
        if ($birth && $birth->birthPlace) {
          $birthPlace = recast('Place', Place::getById($birth->birthPlace->id));
          if ($birthPlace) {
            $birthPlace->delete();
          }
        }
        $birthPlace = null;
      }
      if ($result->deathPlace) {
        $deathPlace = recast('Place', $result->deathPlace);
        $deathPlace->ft_name = "death";
        $deathPlace->fkey = $deathId;
        $death->place = $deathPlace->save();
        $death->save();
      } else {
        if ($death && $death->deathPlace) {
          $deathPlace = recast('Place', Place::getById($death->deathPlace->id));
          if ($deathPlace) {
            $deathPlace->delete();
          }
        }
        $deathPlace = null;
      }
      if ($result->burial && $result->burialPlace) {
        $burialPlace = recast('Place', $result->burialPlace);
        $burialPlace->ft_name = "burial";
        $burialPlace->fkey = $burialId;
        $burial->place = $burialPlace->save();
        $burial->save();
      } else {
        if ($burial && $burial->place) {
          $burialPlace = recast('Place', Place::getById($burial->place));
          if ($burialPlace) {
            if ($burialPlace->delete()) {
              $burial->delete();
            }
          }
        } 
        $burialPlace = null;
      }
      return true;
    } else {
      return "Only accepts POST and GET requests";
    }
  }
}
// End Class

if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
  $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}


try {
  $API = new MyAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
  echo $API->processAPI();
} catch (Exception $e) {
  echo json_encode(Array('error' => $e->getMessage()));
}
?>
