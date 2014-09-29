<?php
class Dropzone
{

  protected static $table_name = "birth";
  protected static $db_fields = array('author', 'description', 'docType', 'fileInfo', 'newName', 'tags', 'title', 'file', 'new', 'thumbnail');
  public static function get_db_fields()
  {
    $fields = array('author', 'description', 'docType', 'fileInfo', 'newName', 'tags', 'title', 'file', 'new', 'thumbnail');
    return $fields;
  }
  public static function nameMe()
  {
    return "Dropzone";
  }

  public $author;
  public $description;
  public $docType;
  public $fileInfo;
  public $newName;
  public $tags;
  public $title;
  public $file;
  public $new;
  public $thumbnail;

  public function save()
  {
    return isset($this->new) ? $this->create() : $this->update();
  }

  // create the object if it doesn't already exits.
  protected function create()
  {
    if (empty($this->newName) || empty($this->file)) {
      return false;
    }

    // return $this;
    // error_reporting(E_ALL);
    // ini_set('display_errors', '1');
    // echo "<pre>";
    // print_r($files);
    // echo "</pre>";
    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    if (isset($this->tags)) {
      $person = isset($this->tags->person)? $this->tags->person : array();
      $other = isset($this->tags->other)? $this->tags->other : array();
      $place = isset($this->tags->place)? $this->tags->place : array();
    }
    $title = isset($this->title)? $this->title : "No Title";
    $author = isset($this->author)? $this->author : "Unknown";
    $comments = $this->description;
    $newname = $this->newName;
    $split = explode(".", $this->file->name);
    $extension = end($split);
    $savename = $newname.".".$extension;
    $link = UPLOAD."$savename";
    $temp = File::getByLink($link);
    // return $temp;
    if (!$temp)
    {
      // return UPLOAD.$savename;
      $file_path = "upload/".$savename;
      if(file_exists($file_path))
      {
        clearstatcache();
        //the file already exists
        return -1;
      }
      if ($this->file->error > 0)
      {
        //there was an error uploading the file
        return -2;
      }
      else
      {
        $result = array();
        if (move_uploaded_file($this->file->tmp_name, ROOT.$link))
        {
          if (($this->file->type == "image/gif") || ($this->file->type == "image/jpeg") || ($this->file->type == "image/jpg") || ($this->file->type == "image/bmp") || ($this->file->type == "image/png" ))
          {
            $im = File::thumbnail(ROOT.$link, 75);
            $im2 = File::thumbnail(ROOT.$link, 800);
            $view_link = UPLOAD."view/".$newname." view.".$extension;
            $temp_thumblink = UPLOAD."thumbs/".$newname." thumbnail.".$extension;
            if ($im && $im2)
            {
              $imageMade = File::imageToFile($im, ROOT.$temp_thumblink);
              if ($imageMade)
              {
                $viewMade = File::imageToFile($im2, ROOT.$view_link);
                if (!$viewMade)
                {
                  unlink($link);
                  return -6;
                }
              }
              else
              {
                unlink($temp_thumblink);
                unlink($link);
                return -6;
              } 
            }
            else
            {
              unlink($link);
              return -6;
            }
            $type = $this->docType;
          }
          else
          {
            $view_link = null;
            $temp_thumblink = "changeMeToDocThumb";
            $type = "other";
          }
          $result[] = "Stored in: " . "upload/" . $savename;
          $init = new File();
          $init->id = null;
          $init->link = $link;
          $init->thumblink = $temp_thumblink;
          $init->viewlink = $view_link;
          $init->title = $title? $title : "Untitled";
          $init->author = $author;
          $init->comments = $comments;
          $init->date = null;
          $init->type = $this->docType;
          $init_id = $init->save();
          if ($init_id)
          {
            foreach ($this->tags as $key => $value) {
              if ($key === 'person') {
                foreach ($value as $person) {
                  $tag = new Tag();
                  $tag->enum = 'person';
                  $tag->fileid = $init_id;
                  $tag->foreignid = $person->id;
                  $tag->save();
                }
              } else if ($key === 'place') {
                foreach ($value as $place) {
                  $tag = new Tag();
                  $tag->enum = 'place';
                  $tag->foreignid = false;
                  $tempPlace = Place::getByAll($place);
                  if ($tempPlace) {
                    $tag->foreignid = $tempPlace->id;
                  } else {
                    $tempPlace = recast('Place', $place);
                    $tpId = $tempPlace->save();
                    if ($tpId) {
                      $tag->foreignid = $tpId;
                    }
                  }
                  if ($tag->foreignid) {
                    $tag->fileid = $init_id;
                    $tag->save();
                  }
                }
              } else if ($key === 'other') {
                foreach ($value as $tag) {
                  $tag = recast('Tag', $tag);
                  if ($tag) {
                    $tag->fileid = $init_id;
                    $tag->enum = 'other';
                    $tag->id = NULL;
                    $tag->save();
                  }
                }
              }
            }
            return 1;
          }
          else
          {
            unlink($temp_thumblink);
            unlink($link);
            //database connection wasn't saved
            return -4;
          }
        }
        else
        {
          //file wasn't moved
          return -3;
        }
      }
    }
    //the database entry already exists
    return -5;

    // save file
  }

  // update the object if it does already exist.
  protected function update()
  {
    return $this;
    // update the file
  }

  protected function doSave()
  {
    return false;
  }


  // Delete the object from the table.
  public function delete()
  {
    return $this;
    // delete the file
  }
}
?>
