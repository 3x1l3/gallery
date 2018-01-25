<?php

/*
 Opting for an array configuration instead of constants. I don't like constants.
*/

return [
  /*
    Define where the base path will be to look for images. Should not be capable of
    going underneath this directory.
  */
    'base_dir' => './pics/',

/*
  Array of files that wont be included outright in the gallery.
*/
    'excluded_files' => ['.']
];
