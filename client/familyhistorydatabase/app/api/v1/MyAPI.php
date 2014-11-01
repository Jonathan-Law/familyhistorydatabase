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
require_once(OBJECTS."tag.php");
require_once(OBJECTS."dropzone.php");
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
    $session = mySession::getInstance();
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
    $session = mySession::getInstance();
    echo $this->verb;
    echo "\n";
    if ($this->method == 'GET') {
      return "Things have changed " . $this->User->name . " and " . serialize($args);
    } else {
      return "Only accepts GET requests";
    }
  }


  protected function user($args) {
    $session = mySession::getInstance();
    require_once(APIROOT.'controller/user.php');
    if ($this->method === 'POST') {
      if ($this->verb === 'login') {
        $result = $this->file;
        $result = login(isset($result->username)? $result->username: null,
          isset($result->password)? $result->password: null);
        return User::current_user();
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
        return User::current_user();
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
      if ($this->verb === 'isLoggedInStill') {
        return $session->isLoggedIn();
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
    $session = mySession::getInstance();
    if ($this->method === 'GET') {
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

  protected function tags($args) {
    $session = mySession::getInstance();
    if ($this->method === 'GET') {
      if ($this->verb === 'other') {
        $value = getRequest('typeahead');
        if (!empty($value)) {
          return Tag::getTags('other', $value);
        } else {
          return Tag::getTags('other');
        }
      } else if ($this->verb === 'person') {
        return Tag::getTags('person');
      } else if ($this->verb === 'place') {
        return Tag::getTags('place');
      } else {
        return Tag::getTags();
      }
    } else if ($this->method === 'POST' && $session->isLoggedIn()&& $session->isAdmin()) {
      $tag = recast('Tag', $this->file);
      if ($tag) {
        return $tag->save();
      }
    }else {
      return "Only accepts GET requests";
    }
  }

  protected function profilePic($args){
    $session = mySession::getInstance();
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
    $session = mySession::getInstance();
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
    $session = mySession::getInstance();
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
    $session = mySession::getInstance();
    // if ($this->method === 'POST') {
    if ($this->method === 'POST' && $session->isLoggedIn()&& $session->isAdmin()) {
      if ($this->verb === 'update') {
        $file = $this->file;
        return Dropzone::updateFile($file);
      } else {
        if (!empty($_POST)) {
          $info = json_decode($_POST['info']);
        } else {
          $info = null;
        }
        if ($info) {
          $ds          = DIRECTORY_SEPARATOR;
          $storeFolder = 'uploads';
          if (!empty($_FILES)) {
            $file = recast('Dropzone', $info);
            $file->file = new stdClass();
            $file->file->error = $_FILES['file']['error'][0];
            $file->file->name = $_FILES['file']['name'][0];
            $file->file->size = $_FILES['file']['size'][0];
            $file->file->tmp_name = $_FILES['file']['tmp_name'][0];
            $file->file->type = $_FILES['file']['type'][0];
          // $file->thumbnail = $_FILES['thumbnail'];
            return $file->save();
          } else {
            return false;
          }
        }
      }
      return false;
    }
    if ($this->method === 'GET') {
      if ($this->verb === 'getTypeahead'){
        $type = isset($args[1])? $args[1]: NULL;
        $val = $args[0]; 
        if ($val === 'object' && $type === 'place'){
          $val = json_decode($_GET['place']);
          if (isset($val) && !empty($val)) {
            $val = $val[0];
          }
        }
        return File::getByTagType($val, $type);
        return $type;
      } else if ($this->verb === "") {
        // Get all edit information required for file edits.
        $id = intval($args[0]);
        if (isset($id) && is_numeric($id)){
          $file = File::getById($id);
          return $file;
        }
        return false;
      }
    }
    return false;
  }

  protected function individual($args) {
    $session = mySession::getInstance();
    if ($this->method === 'GET') {
      if ($this->verb === ''){
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
      } else if ($this->verb === 'families') {
        if (!empty($args)) {
          $letter = array_shift($args);
        } else {
          $letter = 'a';
        }
        $names = array();
        $families = Person::getLastNames($letter);
        if ($families) {
          foreach ($families as $key) {
            $names[] = $key['lastName'];
          }
        }
        return $names;
      } else if ($this->verb === 'familyNames') {
        if (!empty($args)) {
          $lastName = array_shift($args);
        } else {
          $lastName = 'Law';
        }
        $names = array();
        $familyNames = Person::getFirstNames($lastName);
        if ($familyNames) {
          foreach ($familyNames as $key) {
            $key = recast('Person', arrayToObject($key));
            $key->appendNames();
            $names[] = $key;
          }
        }
        return $names;
      } else if ($this->verb === 'pictures') {
        $id = intval(array_shift($args));
        if ($id && is_numeric($id)) {
          $session = mySession::getInstance();
          if ($id > -1) {
            $person = Person::getById($id);
            if ($person) {
              return File::getByInd($person->id);
            }
          }
        } else {
          return false;
        }
      }
      // } else {
      // return false;
      // }
    } else if (($this->method === 'DELETE') && $session->isLoggedIn()&& $session->isAdmin()){
    // } else if ($this->method === 'DELETE'){
      $id = intval($args[0]);
      if (is_numeric($id)){
        $person = Person::getById($id);
        if ($person) {
          $birth = Birth::getById($id);
          if ($birth) {
            $birth = recast('Birth', $birth);
            $birth->delete();//delete
          }
          $death = Death::getById($id);
          if ($death) {
            $death = recast('Death', $death);
            $death->delete();//delete
          }
          $burial = Burial::getById($id);
          if ($burial) {
            $burial = recast('Burial', $burial);
            $burial->delete();//delete
          }
          $parents = Parents::getParentsOf($id);
          if ($parents) {
            foreach ($parents as $parent) {
              $parent = recast('Parents', $parent);
              $parent->delete();//delete $parent
            }
          }
          $children = Parents::getChildrenOf($id);
          if ($children) {
            foreach ($children as $child) {
              $child = recast('Parents', $child);
              $child->delete();//delete $child
            }
          }
          $mySpouse = Spouse::getById($id);
          if ($mySpouse) {
            foreach ($mySpouse as $spouse) {
              $spouse = recast('Spouse', $spouse);
              $theirSpouse = Spouse::getById($spouse->personId);
              if ($theirSpouse) {
                foreach ($theirSpouse as $otherSpouse) {
                  $otherSpouse = recast('Spouse', $otherSpouse);
                  $otherSpouse->delete();//delete $otherSpouse
                }
              }
              $spouse->delete();//delete $spouse
            }
          }
          $tags = Tag::getByIndId($id);
          if ($tags) {
            foreach ($tags as $tag) {
              $tag = recast('Tag', $tag);
              $tag->delete();
            }
          }
          $person->delete();
          return true;
        } else {
          return true;
        }
      }
      return false;
    } else if (($this->method === 'POST' || $this->method === 'PUT') && $session->isLoggedIn()&& $session->isAdmin()){
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
