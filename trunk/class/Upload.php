<?php
/* adapted from http://nickbrowndesign.com/articles/easy-php-upload-class/ */
class fileDir {
  private $fileInfo;
  private $fileLocation;
  private $error;
  private $direct;    
   private $arrExtPermits = array();   
   protected $ext;
   
  function __construct($dir){
	  $this->direct = $_SERVER['DOCUMENT_ROOT'].$dir;
	  if(!is_dir($this->direct)){
		  die('Supplied directory is not valid: '.$this->direct);	
	  }
  }
  function upload($theFile){
	  $this->fileInfo = $theFile;
	   $this->ext = pathinfo($theFile, PATHINFO_EXTENSION);
	  $this->fileLocation = $this->direct . $this->fileInfo['name'];
	  
	   if(!file_exists($this->fileLocation)){
	    if(in_array(strtolower($this->ext),$this->arrExtPermits)){
            if(move_uploaded_file($this->fileInfo['tmp_name'], $this->fileLocation)){
    			return 'File was successfully uploaded';	
    		} 
      }    
    else {
			return 'File could not be uploaded';
			$this->error = "Error: File could not be uploaded.\n";
			$this->error .= "Extension '".$this->ext."' not allowed.";
			$this->error .= 'Here is some more debugging info:';
			$this->error .= print_r($_FILES);	
		}
	  } else {
		  return 'File by this name already exists';	
	  }
  }
  function overwrite($theFile){
	  $this->fileInfo = $theFile;
	  $this->fileLocation = $this->direct . $this->fileInfo['name'];
	  if(file_exists($this->fileLocation)){
		  $this->delete($this->fileInfo['name']);
	  }
	  return $this->upload($this->fileInfo);
  }
  function location(){
	  return $this->fileLocation;	
  }
  function fileName(){
	  return $this->fileInfo['name'];
  }
  function delete($fileName){
	  $this->fileLocation = $this->direct.$fileName;
	  if(is_file($this->fileLocation)){
		unlink($this->fileLocation);
		return 'Your file was successfully deleted';
	  } else {
		return 'No such file exists: '.$this->fileLocation;	
	  }
  }
  function reportError(){
	  return $this->error;	
  }
}
?>
