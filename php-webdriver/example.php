<?php
// An example of using php-webdriver.
// Do not forget to run composer install before. You must also have Selenium server started and listening on port 4444.
namespace Facebook\WebDriver;

if (empty(session_id()))
	session_start();

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');

// This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/
$host = 'http://localhost:4444/wd/hub';

$capabilities = DesiredCapabilities::chrome();

$driver = RemoteWebDriver::create($host, $capabilities);

// navigate to Selenium page on Wikipedia
// $driver->get('https://en.wikipedia.org/wiki/Selenium_(software)');
$driver->get('http://test.seminar:8383/seminar/');

// write 'PHP' in the search box
$driver->findElement(WebDriverBy::cssSelector("#main_content .section .indexLogin a")) // find search input element
	// ->sendKeys('sun ptb log') // fill the search box
	->click(); // submit the whole form

// wait until 'PHP' is shown in the page heading element
$driver->wait()->until(
	WebDriverExpectedCondition::elementTextContains(WebDriverBy::cssSelector('.h2Title span'), 'セミナー　管理者画面　ログイン')
);

// // // print title of the current page to output
echo "The title is '" . $driver->getTitle() . "'\n";

// // // print URL of current page to output
echo "The current URL is '" . $driver->getCurrentURL() . "'\n";

// find element of 'History' item in menu
$idButton = $driver->findElement(WebDriverBy::id('txtUname'))->sendKeys('admin');
$passcheckDefault = $passcheck = '1410000';
$passButton = $driver->findElement(
	WebDriverBy::id('txtUpass')
)->sendKeys('14100222');

$submitButton = $driver->findElement(WebDriverBy::id('wp-submit'))->click();

$check = $driver->getCurrentURL();
if ($check != "http://test.seminar:8383/seminar/seminara.php")
	echo "error" . "<br/>";
else {
	echo "success";
}
for ($i = 10; $i < 30; $i++) {
	$passcheck += $i;
	$passButton = $driver->findElement(
		WebDriverBy::id('txtUpass')
	)->sendKeys($passcheck);

	$submitButton = $driver->findElement(WebDriverBy::id('wp-submit'))->click();

	$check = $driver->getCurrentURL();
	if ($check == "http://test.seminar:8383/seminar/seminara.php")
		break;
	$passcheck = $passcheckDefault;
}

echo "The current URI is '" . $check . "'\n";

// // delete all cookies
// $driver->manage()->deleteAllCookies();

// // add new cookie
// $cookie = new Cookie('cookie_set_by_selenium', $passcheck);
// $driver->manage()->addCookie($cookie);

// // dump current cookies to output
// $cookies = $driver->manage()->getCookies();
$_SESSION["data"]["user"] = "admin";
$_SESSION["data"]["pass"] = $passcheck;

echo '<pre>';
print_r($_SESSION);
echo '<pre>';

// terminate the session and close the browser
$driver->quit();
