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
  $dbname = "ketten";
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
// $dir_files_cache_pages = '/Users/albertas/kettenhobby/';
// $files_in_directory = scandir($dir_files_cache_pages);
// foreach ($files_in_directory as $key=>$files) {
//   if ($files[0]!=='.' && $files[1]!=='.') {
//     $doc = file_get_contents($dir_files_cache_pages.'/'.$files);
//     $document = \phpQuery::newDocument($doc);
//      foreach($document->find('.page_artlist_name_link') as $key => $value){
//         $pq = pq($value);
//   $product_links = $pq->attr('href');
//   $sql = "INSERT INTO links (id, link)
//   VALUES (NULL, '$product_links')";
//   mysqli_query($conn, $sql);
//      }
//   }
// }

function requests ($url) {
  $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36');
  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
  }


  $sql = "SELECT * FROM links";
$result = mysqli_query($conn, $sql);
  while($row = mysqli_fetch_assoc($result)){
  $links = ($row['link']);
  $html = requests($links);
  $document = phpQuery::newDocument($html);
  foreach($document->find('#main_image') as $key => $value){
    $pq = pq($value);
    $src = $pq->attr('src');
    $src = str_replace('/270x250', '', $src);
    echo $src.'<br>';
  
  }
}