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

  protected function spouses($args){
    if ($this->method === 'GET') {
      if ($this->verb == "") {
        $spouseId = intval(array_shift($args));
        $individualId = intval(array_shift($args));
        if (($spouseId && is_numeric($spouseId)) && ($individualId && is_numeric($individualId))) {
          $spouses = Spouse::getByPair($spouseId, $individualId);
          return $spouses;
        }
      } 
    }
    return false;
  }

  protected function place($args){
    if ($this->method === 'GET') {
      if ($this->verb == "") {
        $placeId = intval(array_shift($args));
        if ($placeId && is_numeric($placeId)) {
          $place = Place::getById($placeId);
          return $place;
        }
      } 
    }
    return false;
  }

  protected function file($args){
    if ($this->method === 'POST') {
      return json_decode($_POST['info']);
      if (!empty($_POST)) {
        $info = $_POST;
      } else {
        $info = null;
      }
      if ($info) {
        $ds          = DIRECTORY_SEPARATOR;
        $storeFolder = 'uploads';
        if (!empty($_FILES)) {
          $tempFile = $_FILES['file']['tmp_name'];
          $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
          $targetFile =  $targetPath. $_FILES['file']['name'];
       // move_uploaded_file($tempFile,$targetFile);
          return $info;
        } else {
          return false;
        }
      }
      return false;
    }
    return false;
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
      // return $result;
      $person = recast('Person', $result->person);
      if (!empty($person)) {
        $personId = $person->save();
      } else {
        return false;
      } 
      if ($personId) {
        $person->id = $personId;
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
          $burial = false;
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
            $birthPlace = Place::getById($birth->birthPlace->id);
            if ($birthPlace){
              $birthPlace = recast('Place', $birthPlace);
              if ($birthPlace) {
                $birthPlace->delete();
              }
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
          $deathPlace = Place::getById($death->deathPlace->id);
          if ($death && $death->deathPlace) {
            $deathPlace = recast('Place', Place::getById($death->deathPlace->id));
            if ($deathPlace) {
              $deathPlace->delete();
            }
          }
          $deathPlace = null;
        }
        if ($burial) {
          if ($result->burialPlace) {
            $burialPlace = recast('Place', $result->burialPlace);
            $burialPlace->ft_name = "burial";
            $burialPlace->fkey = $burial->id;
            $burial->place = $burialPlace->save();
            $burial->save();
          } else {
            $burialPlace = Place::getById($burial->place);
            if ($burial && $burialPlace) {
              $burialPlace = recast('Place', Place::getById($burial->place));
              if ($burialPlace) {
                $burialPlace->delete();
              }
            } 
          }
        } else {
          $burial = Burial::getById($person->id);
          if ($burial && $burial->id) {
            $burial = recast('Burial', $burial);
            $burialPlace = Place::getById($burial->place);
            if ($burialPlace) {
              $burialPlace = recast('Place', Place::getById($burial->place));
              if ($burialPlace) {
                $burialPlace->delete();
              }
            } 
            $burial->delete();            
          } 
        }
        if ($result->parents) {
          if ($person->id) {
            $parents = Parents::getParentsOf($person->id);
            if ($parents) {
              $missing = array();
              foreach ($parents as $parent) {
                if (!objectListContains($result->parents, 'id', $parent->parentId)) {
                  $missing[] = $parent;
                }
              }
              foreach ($missing as $parent) {
                $parent = recast('Parents', $parent);
                $parent->delete();
              }
              foreach ($result->parents as $key) {
                if (!objectListContains($parents, 'parentId', $key->id)) {
                  $newPadre = new Parents();
                  $newPadre->child = $person->id;
                  $newPadre->gender = ($key->sex === 'male')? 'father': 'mother';
                  $newPadre->parentId = $key->id;
                  $newPadre->save();
                }
              }
            } else {
              foreach ($result->parents as $key) {
                $newPadre = new Parents();
                $newPadre->child = $person->id;
                $newPadre->gender = ($key->sex === 'male')? 'father': 'mother';
                $newPadre->parentId = $key->id;
                $newPadre->save();
              }
            } 
          } else {
            return 'We have an error';
          }
        } else {
          $parents = Parents::getParentsOf($person->id);
          if ($parents) {
            foreach ($parents as $parent) {
              $parent = recast('Parents', $parent);
              $parent->delete();
            }
          }
        }
        if ($result->spouse) {
          $spouses = Spouse::getAllSpousesById($person->id);
          if ($spouses) {
            $missing = array();
            foreach ($spouses as $spouse) {
              if (!objectListContains($result->spouse, 'id', $spouse->spouse)) {
                $missing[] = $spouse;
              }
            }
            foreach ($missing as $spouse) {
              $spouse = recast('Spouse', $spouse);
              $place = Place::getById($spouse->place);
              if ($place) {
                $place = recast('Place', $place);
                $place->delete();
              }
              $otherSpouse = Spouse::getByPair($spouse->personId, $spouse->spouse);
              if ($otherSpouse) {
                $place = Place::getById($otherSpouse->place);
                if ($place) {
                  $place = recast('Place', $place);
                  $place->delete();
                }
                $otherSpouse = recast('Spouse', $otherSpouse);
                $otherSpouse->delete();
              }
              $spouse->delete();
            }
            foreach ($result->spouse as $spouse) {
              if (!objectListContains($spouses, 'spouse', $spouse->id)) {
                Spouse::addSpouse($spouse, $person->id, $spouse->id);
                Spouse::addSpouse($spouse, $spouse->id, $person->id);
              } else {
                Spouse::updateSpouse($spouse, $spouse->id, $person->id);
                Spouse::updateSpouse($spouse, $person->id, $spouse->id);
              }
            }
          } else {
            foreach ($result->spouse as $spouse) {
              Spouse::addSpouse($spouse, $person->id, $spouse->id);
              Spouse::addSpouse($spouse, $spouse->id, $person->id);
            }
          }
        } else {
          $spouses = Spouse::getAllSpousesById($person->id);
          if ($spouses){
            foreach ($spouses as $spouse) {
              $spouse = recast('Spouse', $spouse);
              $place = Place::getById($spouse->place);
              if ($place) {
                $place = recast('Place', $place);
                $place->delete();
              }
              $otherSpouse = Spouse::getByPair($spouse->personId, $spouse->spouse);
              if ($otherSpouse) {
                $place = Place::getById($otherSpouse->place);
                if ($place) {
                  $place = recast('Place', $place);
                  $place->delete();
                }
                $otherSpouse = recast('Spouse', $otherSpouse);
                $otherSpouse->delete();
              }
              $spouse->delete();
            }
          }
        }
        return true;
      }
      return false;
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
