<?php

/*!
 * Twig Namespace Listener Class
 *
 * Copyright (c) 2016 Evan Lovely, http://evanlovely.com
 * Licensed under the MIT license
 *
 * Allows Twig Namespaces to be added to Pattern Lab
 *
 */

namespace PatternLab\ExportComponent;

use \PatternLab\Config;
use \PatternLab\PatternEngine\Twig\TwigUtil;
use \Twig_Loader_Filesystem;

class PatternLabListener extends \PatternLab\Listener {

  /**
  * Add the listeners for this plug-in
  */
  public function __construct() {

    // add listener
    $this->addListener("patternData.dataLoaded","prepareDownload");

  }

  /**
   * Fake some content. Replace the entire store.
   */
  public function prepareDownload() {

      $content = $this->recursiveWalk(Data::get());
      Data::replaceStore($content);

  }

  /**
   * Go through data and replace any values that match items from the link.array
   * @param  {String}       a string entry from the data to check for link.pattern
   *
   * @return {String}       replaced version of link.pattern
   */
  private function replaceDownloadLink($value) {
    if (is_string($value) && (strpos($value,"DownloadComponent") === 0)) {

    }
    return $value;
  }

  /**
   * Work through a given array and decide if the walk should continue or if we should replace the var
   * @param  {Array}       the array to be checked
   *
   * @return {Array}       the "fixed" array
   */
  private function recursiveWalk($array) {
    foreach ($array as $k => $v) {
      if (is_array($v)) {
        $array[$k] = self::recursiveWalk($v);
      } else {
        $array[$k] = self::replaceDownloadLink($v);
      }
    }
    return $array;
  }
}
