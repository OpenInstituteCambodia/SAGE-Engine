<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

use Comodojo\Zip\Zip;
/**
 *
 */
class SageController extends Controller
{
  private $templateVersion;

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

    $this->templateVersion = $CONFIG['template'];
    return $CONFIG;
  }

  public function setTemplate($value)
  {
    self::releaseDownload($value);
    $SAGE = new \DOMDocument('1.0', 'utf-8');
    $SAGE_CONFIG_XML = Storage::get('/sage.xml');
    $SAGE->loadXML($SAGE_CONFIG_XML);

    $SAGE->getElementsByTagName("preference")->item(0)->nodeValue = $value;
    Storage::put('/sage.xml', $SAGE->saveXML());
    return redirect()->route('developer');
  }

  public function templateReleases()
  {
    $template = array(
      'active' => $this->templateVersion,
      'GITHUB_APP_ID' => env('GITHUB_APP_ID'),
      'GITHUB_APP_SECRET' => env('GITHUB_APP_SECRET'),
      'GITHUB_APP_OWNER' => env('GITHUB_APP_OWNER'),
      'GITHUB_APP_REPO' => env('GITHUB_APP_REPO'),
      'GITHUB_APP_ARCHIVE_FORMAT' => env('GITHUB_APP_ARCHIVE_FORMAT'),
      'GITHUB_APP_TAG' => 'releases',
      // 'GITHUB_APP_TAG' => env('GITHUB_APP_TAG'),
    );

    $client = new \GuzzleHttp\Client();
    $res = $client->request(
      'GET',
      'https://api.github.com/repos/'.$template['GITHUB_APP_OWNER'].'/'.$template['GITHUB_APP_REPO'].'/'.$template['GITHUB_APP_TAG'].'?client_id='.$template['GITHUB_APP_ID'].'&client_secret='.$template['GITHUB_APP_SECRET']
    );
    $headerType = $res->getHeaderLine('content-type');
    $content = $res->getBody();
    return $content;
  }

  public function releaseDownload($value)
  {

    $ionicPath =  storage_path('app/ionic/');
    $githubPath =  storage_path('app/github/');

    if (!is_file(storage_path('app/github/'.$value.'.zip'))) {
      $template = array(
        'active' => $this->templateVersion,
        'GITHUB_APP_ID' => env('GITHUB_APP_ID'),
        'GITHUB_APP_SECRET' => env('GITHUB_APP_SECRET'),
        'GITHUB_APP_OWNER' => env('GITHUB_APP_OWNER'),
        'GITHUB_APP_REPO' => env('GITHUB_APP_REPO'),
        'GITHUB_APP_ARCHIVE_FORMAT' => env('GITHUB_APP_ARCHIVE_FORMAT'),
        'GITHUB_APP_TAG' => 'releases',
        // 'GITHUB_APP_TAG' => env('GITHUB_APP_TAG'),
      );
      $client = new \GuzzleHttp\Client();
      $zipball = $client->request(
        'GET',
        'https://api.github.com/repos/'.$template['GITHUB_APP_OWNER'].'/'.$template['GITHUB_APP_REPO'].'/zipball/'.$value
      );
      $zipContent = $zipball->getBody();
      Storage::put('github/'.$value.'.zip', $zipContent);

    }

    if (!is_file($ionicPath.$value.'/config.xml.example')) {
      $zip = Zip::open($githubPath.$value.'.zip');
      $zip->extract($ionicPath);
      $fileContents = $zip->listFiles(); //Get list of file in the zip contents.

      if (File::exists($ionicPath.$fileContents[0])){
        File::moveDirectory($ionicPath.$fileContents[0], $ionicPath.$value);
      }
      $zip->close();
    }
  }
}
