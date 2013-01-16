<?php
/*
ob_start();

$offset = 60 * 60 * 24 * 5;
$ExpStr = gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
$last_modified = date("F d Y H:i:s", getlastmod());

header("Last-Modified: $last_modified GMT time");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: $ExpStr");
*/

$year = date("Y");
$self = $_SERVER['PHP_SELF'];
$pageName = basename($_SERVER['PHP_SELF']); //get curr pagename+ext(file)

/* Your default folder is 'default' , you can change it here */
$catg = isset($_GET['catg']) ? $_GET['catg'] : 'default';

require_once('class/Thumbs.php');
include_once('class/Upload.php');

define("WEBSITE", "arakno.net");
define("WWW", "www.arakno.net");

define( 'THUMBNAIL_IMAGE_MAX_WIDTH', 160 );
define( 'THUMBNAIL_IMAGE_MAX_HEIGHT', 104 );

error_reporting(E_ALL^E_NOTICE);

define("DS", DIRECTORY_SEPARATOR);
define("PS",PATH_SEPARATOR);

?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="pt"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="pt"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="pt"> <![endif]-->
<!--[if IE 9]>    <html class="no-js lt-ie10" lang="pt"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="pt"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Portfolio :: Paulo Basto - Frontend Developer</title>
  <meta name="description" content="Portfolio Paulo Basto">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
  <meta name="apple-touch-fullscreen" content="yes" />
  <meta name="generator" content="sublimeText2" />
  <meta name="author" content="pbasto" />
  <meta name="robots" content="index,follow" />
  <meta name='copyright' content='Copyright &#169; <?php echo $year . WWW; ?>' />

  <link rel="shortcut icon" href="favicon.gif" />
<link rel="shorcut icon" href="favicon.ico" type="image/x-icon" />

  <link rel="stylesheet" href="css/827d172.css">

<script src="js/modernizr.custom.js"></script>

  <body>
    <div id="wrap">

      <header>
        <nav>
          <ul>
            <?php

            $cachedir = 'cache';
            $currdir = 'portfolio'.DS.$catg;
            $per_column = 6;
            $files    = glob($currdir .DS. '*.{JPG,jpeg,jpg,gif,png,swf,avi,mpg}', GLOB_BRACE);

            /*ROUND SIZE NUMBERS*/
            function format_size($size) {
              $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
              if ($size == 0) { return('n/a'); } else {
                return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); }
              }
              /* root portfolio folder to generate menu items from dirs */
              $dportfolio = 'portfolio'.DS;

//get directories names to build catgs names
              function dir_list($d) {
                foreach(array_diff(scandir($d),array('.','..')) as $f)
                  if(is_dir($d . DS . $f))
                    $l[] = $f;
                  return $l;
                }

                $d = dir_list($dportfolio);

                if($d){

                  foreach($d as $f){ ?>
                  <li>
                    <a class="<?php echo(($catg == $f) ? 'active': ''); ?>" href="<?php echo $pageName ?>?catg=<?php echo $f; ?>">
                      <?php echo $f; ?></a>
                    </li>

                    <?php }

                  }
                  ?>

                </ul>
              </nav>

            </header>
            <!-- Main Body -->
            <div id="content">

              <section>


                <?php
//SCATTER THUMBS ON CANVAS


                $out = " <h4>" . $catg ."</h4>";


                if ($handle = @opendir($currdir)or die("<h4>No images in this category</h4>$out")) {
                  $count=0;
                  $out .= "<ul class='polaroids'>";

                  while (false !== ($file = readdir($handle))) {
      //clears last results from cache
                    clearstatcache();

                    if(is_file($currdir.DS.$file)){
                      /*Check Cache for img */
                      if(!file_exists($cachedir.DS.'tb-'.$file)){
     //Instantiate Class
                        $thumb = new Thumbs;
                        $thumb->source_image_path =  $currdir.DS.$file;
                        $thumb->thumbnail_image_path =  $cachedir.DS.'tb-'.$file;
                        $thumb->generate_thumbs();
                      }
                      $count++;

                      $trimmed = rtrim($file, "\.jpg\.png\.gif\.jpeg");
                      $ext = ltrim($file, "\.");
                      $fsize = format_size(filesize($currdir.DS.$file));
                      $out .= "<li><a draggable='true' class='photo-link' title='".$trimmed."' href='".$currdir.DS.$file."'>
                      <img src='".$cachedir.'/tb-'.$file."' width='".THUMBNAIL_IMAGE_MAX_WIDTH."' heigth='".THUMBNAIL_IMAGE_MAX_HEIGHT."' title='aumentar' />
                      <span id='caption'><h3>".$ext."</h3><p>".$fsize."</p></span>
                      </a></li>";
                      if($count % $per_column == 0) {
                       $out .= "<div class='clearfix'></div>";
                     }

                   }

                 }
                 closedir($handle);

                 echo $out;
               }

               ?>

             </section>
           </div>
           <footer>
              Rastafari project by Paulo Basto Copyright &#169;<?php echo $year .'&nbsp;'. WWW; ?>
           </footer>


         </div>



         <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
         <script>window.jQuery || document.write('<script src="js/jquery-1.7.1.min.js"><\/script>')</script>
<!-- scripts concatenated and minified via build script -->
         <script src="js/jquery.drags.js" type="text/javascript"></script>
         <script src="js/tinybox.js" type="text/javascript"></script>
         <script src="js/script.js" type="text/javascript"></script>
<!-- end scripts -->


</body>

<

</html>
​