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

  /**
  * Example of an Endpoint
  */
  protected function user($args) {
    require_once(APIROOT.'controller/user.php');
    if ($this->method === 'POST') {
      if ($this->verb === 'login') {
        $result = getStream();
        $result = login(isset($result->username)? $result->username: null,
                        isset($result->password)? $result->password: null);
        return $result;
      } else if ($this->verb === 'logout') {
        return $session->logout();
      } else if ($this->verb === 'register') {
        $result = getStream();
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
      return "Only accepts GET requests";
    }
  }
}


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
