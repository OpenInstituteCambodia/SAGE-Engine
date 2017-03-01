<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class SageController extends Controller
{

  public function __construct()
  {
    # code...
  }

  public function sageConfig()
  {
    $SAGE = new \DOMDocument('1.0', 'utf-8');
    $SAGE_CONFIG_XML = Storage::get('/sage.xml');
    $SAGE->loadXML($SAGE_CONFIG_XML);
    $xPath = new \DOMXPath($SAGE);

    $CONFIG = array(
      'template' => $xPath->evaluate('string(/sage/preference[@name="templateVersion"])'),
    );
    return $CONFIG;
  }
}
