<?php

$cfg = require_once('./config.php');


  $dirArray = (isset($_GET['dir'])?$_GET['dir']:[]);

  $data['dirs'] = [];
  $data['images'] = [];

  $currentDirectory = $cfg['base_dir'].implode('/',$dirArray);

  foreach (scandir($currentDirectory) as $file) {
    $fullPath = $currentDirectory.'/'.$file;

    if (in_array($file, $cfg['excluded_files']) )
      continue;

      if (is_dir($fullPath)) {
          $data['dirs'][] = $file;
      } else if (exif_imagetype($fullPath)!==false) {
          $data['images'][] = $file;
      }
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gallery</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/thumbnail-gallery.css" rel="stylesheet">
    <link href="css/fontawesome-all.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link type="text/css" rel="stylesheet" href="css/lightgallery.min.css" />
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Gallery</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="?">Home
              </a>
            </li>
            <?php

            foreach ($dirArray as $key => $dir) {
              $tempArray = $dirArray;

              $tempArray = array_slice($dirArray,0,$key+1);

                $dirQueryString = http_build_query(['dir'=>$tempArray]);
            echo '  <li class="nav-item">
                <a class="nav-link" href="?'.$dirQueryString.'">'.$dir.'</a>
              </li>';
            }


            ?>



            <!-- <li class="nav-item active">
              <a class="nav-link" href="#">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">BASE_DIR
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li> -->
          </ul>
        </div>
      </div>
    </nav>



    <!-- Page Content -->
    <div class="container">

      <h3 class="my-4 text-center text-lg-left">Directory of <?php echo  $cfg['base_dir'].implode('/',$dirArray); ?>
        <a href="?rand=" class="btn btn-dark float-right btn-sm"><i class="fas fa-random"></i> Random</a>
      </h3>


      <?php if (count($data['dirs'])>0) { ?>
      <table class="table">
          <tr>
              <?php
              foreach ($data['dirs'] as $dir) {
                  $tempArray = $dirArray;
                  if ($dir == '..') {
                  //  $dir = CURRENT_DIR.$dir;
                    //  $dir = dirname(implode('/',$dirArray));
                      array_pop($tempArray);
                      $name = '<i class="fas fa-level-up-alt"></i>';
                  } else {
                      array_push($tempArray, $dir);
                      $name = $dir;
                  }


                    $dirQueryString = http_build_query(['dir'=>$tempArray]);
                    echo '  <tr><td style="width: 10%"><i class="fas fa-folder"></i></td><td class=""><a href="?'.$dirQueryString.'">'.$name.'</a></td></tr>';
              } ?>

          </tr>
      </table>
    <?php } ?>


      <div class="row text-center text-lg-left" id="lightgallery">

        <?php

        if (count($data['images']) > 0) {
          foreach ($data['images'] as $img) {
              $img = $currentDirectory.'/'.$img;
              echo '
                  <div class="col-lg-3 col-md-4 col-xs-6">
                    <a href="'.$img.'"  class="d-block mb-4 h-100" data-src="'.$img.'" >
                      <img class="img-fluid img-thumbnail" src="'.$img.'"  alt="">
                    </a>
                  </div>
                ';

          }
        }

         ?>

      </div>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5">
      <div class="container">
        <p class="m-0 text-center text-black">Copyright &copy; Your Website 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/lightgallery-all.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#lightgallery").lightGallery({
              selector: 'a'
            });
        });
    </script>
  </body>

</html>
