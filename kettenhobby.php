<?php
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Cookie;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
ini_set('max_execution_time', 0);
require 'phpquery.php';
require_once('vendor/autoload.php');
function format ($expre) {
  echo "<pre>";
  print_r($expre);
  echo "</pre>";
}
$servername = "localhost";
  $username = "user"; 
  $password = "user";
  $dbname = "kramp";
  $conn = new \mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  echo "Connected successfully";

function silenium_request_with_auth($url) {
$host = 'http://localhost:9515';
$options = new ChromeOptions();
$options->addArguments(['--disable-infobars', '--disable-extensions', '--ignore-certificate-errors']);
$capabilities = DesiredCapabilities::chrome();
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
$driver = RemoteWebDriver::create($host, $capabilities);
$driver->get($url);
sleep(50);
$html = $driver->getPageSource();
  
  return $html;
  }

// $html = silenium_request_with_auth('https://kerthobby.hu/sct/271001/Funyirogep-elektromos-akkumulatoros?infinite_page=10');
// file_put_contents('/Users/albertas/kettenhobby/page.html', $html);
$dir_files_cache_pages = '/Users/albertas/kettenhobby/';
$files_in_directory = scandir($dir_files_cache_pages);
foreach ($files_in_directory as $key=>$files) {
  if ($files[0]!=='.' && $files[1]!=='.') {
    $doc = file_get_contents($dir_files_cache_pages.'/'.$files);
    $document = \phpQuery::newDocument($doc);
     foreach($document->find('.page_artlist_name_link') as $key => $value){
        $pq = pq($value);
  $product_links = $pq->attr('href');

  $links[] = $product_links;
  }   
  }
}
format($links);