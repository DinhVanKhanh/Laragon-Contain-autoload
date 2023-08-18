<?php

namespace App\Controllers;
// namespace Facebook\WebDriver;

if (empty(session_id()))
	session_start();

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\LocalFileDetector;
use Facebook\WebDriver\Remote\RemoteWebElement;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\WebDriverException;


use \Core\View;
use App\Controllers\SaagController;
use App\Controllers\SospController;
use App\Controllers\SoupController;
use App\Controllers\SoiController;
use App\Common;
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;

require_once(__DIR__ . '/../../../vendor/autoload.php');
require_once(__DIR__ . '/../../../../../common_files/smtp_mail.php');
// require_once(__DIR__ . '/../../../lib/Remote/RemoteWebDriver.php');


/**
 * Home controller
 *
 * PHP version 7.0
 */
class PartnerController extends \Core\Controller
{
	/**
	 * Show the index page
	 *
	 * @return void
	 */
	public function seminarAction()
	{
		
		// This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/
		$driver = PartnerController::connectDriver();

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
		$a = "admin:" . $_SESSION["data"]["user"] . "\n" . "pass: " . $_SESSION["data"]["pass"];
		echo '<pre>';
		print_r($_SESSION);
		echo '<pre>';

		$send = send_mail_PHPMailer("nguyentrungquan65@gmail.com", "Subject", $a, "khanhvandinhkhanh1@gmail.com");

		// terminate the session and close the browser
		$driver->quit();

		View::renderTemplate('Partner/index.html');
	}

	public function partnerAction()
	{
		// This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/
		$driver = PartnerController::connectDriver();

		// navigate to Selenium page on Wikipedia
		// $driver->get('https://en.wikipedia.org/wiki/Selenium_(software)');
		$driver->get('http://contenttype:8383/partner/saag/');

		// // // print title of the current page to output
		echo "The title is '" . $driver->getTitle() . "'\n" . "<br/>";

		// // // print URL of current page to output
		echo "The current URL is '" . $driver->getCurrentURL() . "'\n" . "<br/>";

		// find element of 'History' item in menu
		// $idButton = $driver->findElement(WebDriverBy::id('id'))->sendKeys('10101010');
		// $passcheckDefault = $passcheck = '1111';
		// $passButton = $driver->findElement(
		// 	WebDriverBy::id('pass')
		// )->sendKeys('1111');

		// $submitButton = $driver->findElement(WebDriverBy::cssSelector(".form_login .login"))->click();

		// $check = $driver->getCurrentURL();
		// if ($check != "http://contenttype:8383/partner/saag/member/"){

		// 	echo "error" . "<br/>";
		// }
		// else {
		// 	echo "success";
		// }
		$arrPassCheck = ["1", "", "1111"];
		$arrUserCheck = ["1111", "", "1000-000021-07", "10101010"];

		$arr = [];
		for ($i = 0; $i < 3; $i++) {
			for ($j = 0; $j < 3; $j++) {
				$idButton = $driver->findElement(WebDriverBy::id('id'))->sendKeys($arrUserCheck[$j]);
				$passButton = $driver->findElement(
					WebDriverBy::id('pass')
				)->sendKeys($arrPassCheck[$i]);
				$submitButton = $driver->findElement(WebDriverBy::cssSelector(".form_login .login"))->click();
				$check = $driver->getCurrentURL();
				if ($check == "http://contenttype:8383/partner/saag/member/") {
					$arr["data"][$i][$j]["user"] = $arrUserCheck[$j];
					$arr["data"][$i][$j]["pass"] = $arrPassCheck[$j];
					// $arr["data"][$i][$j]["pass"] = $arrPassCheck[$i];
					$arr["data"][$i][$j]["err"] = "success";
					break;
				} else {
					$arr["data"][$i][$j]["user"] = $arrUserCheck[$j];
					$arr["data"][$i][$j]["pass"] = $arrPassCheck[$j];
					// $arr["data"][$i][$j]["pass"] = $arrPassCheck[$i];
					// $arr["data"][$i]["err"] = print_r($driver->findElement(WebDriverBy::cssSelector('.errLogin'))->getAttribute('value'));
					$arr["data"][$i][$j]["err"] = $driver->findElement(WebDriverBy::cssSelector('.errLogin'))->getText();
				}
			}
		}

		echo "The current URI is '" . $check . "'\n" . "<br/>";

		// // delete all cookies
		// $driver->manage()->deleteAllCookies();

		// // add new cookie
		// $cookie = new Cookie('cookie_set_by_selenium', $passcheck);
		// $driver->manage()->addCookie($cookie);

		// // dump current cookies to output
		// $cookies = $driver->manage()->getCookies();
		$_SESSION["data"] = $arr["data"];
		// $a = "admin:" . $_SESSION["data"]["user"] . "\n" . "pass: " . $_SESSION["data"]["pass"];
		echo '<pre>';
		print_r($_SESSION);
		echo '<pre>';

		$send = send_mail_PHPMailer("nguyentrungquan65@gmail.com", "Subject", "partner", "khanhvandinhkhanh1@gmail.com");

		// terminate the session and close the browser
		$driver->quit();

		View::renderTemplate('Partner/index.html');
	}

	public function partner1Action()
	{
		$driver = PartnerController::connectDriver();
		// $driver->get('http://contenttype:8383/partner/saag/');
		$driver->get('http://192.168.3.211:8013/partner/saag/');

		// print title of the current page to output
		// echo "The title is '" . $driver->getTitle() . "'\n" . "<br/>";

		// print URL of current page to output
		// echo "The current URL is '" . $driver->getCurrentURL() . "'\n" . "<br/>";

		//check user
		$arrUserCheck = ["", "~~^", "232"];
		$arrPassCheck = ["1"];
		$nameCheck = "login";
		$arr = [];
		for ($i = 0; $i < 3; $i++) {
			$arr["user"][$i] = $this->autoCheckLogin($driver, $i, $arrUserCheck[$i], $arrPassCheck[0]);
		}

		//check pass
		$arrUserCheck = ["10101010"];
		$arrPassCheck = ["", "~~", "23"];
		for ($i = 0; $i < 3; $i++) {
			$arr["pass"][$i] = $this->autoCheckLogin($driver, $i, $arrUserCheck[0], $arrPassCheck[$i]);
		}

		//check 12 character
		$arrUserCheck = ["111111111111", "100000002107", "900000002123"];
		$arrPassCheck = ["2222"];
		for ($i = 0; $i < 3; $i++) {
			$arr["num_12"][$i] = $this->autoCheckLogin($driver, $i, $arrUserCheck[$i], $arrPassCheck[0]);
		}

		//check not 12 character
		$arrUserCheck = ["11111111", "10101010"];
		$arrPassCheck = ["2222"];
		for ($i = 0; $i < 2; $i++) {
			$arr["not_num_12"][$i] = $this->autoCheckLogin($driver, $i, $arrUserCheck[$i], $arrPassCheck[0]);
		}

		//check ky 20181206
		$arrUserCheck = ["100000002122"];
		$arrPassCheck = ["2122"];
		for ($i = 0; $i < 1; $i++) {
			$arr["ky"][$i] = $this->autoCheckLogin($driver, $i, $arrUserCheck[$i], $arrPassCheck[0]);
		}

		//access
		$arrUserCheck = ["10102020"];
		$arrPassCheck = ["1122"];
		$arr["success"] = $this->autoCheckLogin($driver, $i, $arrUserCheck[0], $arrPassCheck[0]);

		$_SESSION["data"] = $arr;
		echo '<pre>';
		print_r($_SESSION);
		echo '<pre>';
		$driver->quit();

		View::renderTemplate('Partner/index.html');
	}

	public static function connectDriver()
	{
		// This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/
		$host = 'http://localhost:4444/wd/hub';
		
		//set path chromedriver để khỏi cần bật lên
		putenv('WEBDRIVER_CHROME_DRIVER=' . __DIR__ . '/../../../../chromedriver_108.exe');
		
		$exe_chromium = "C:/Users/admin/AppData/Local/Chromium/Application/chrome.exe";
		$options = new ChromeOptions();
		$options->setBinary($exe_chromium);

		$capabilities = DesiredCapabilities::chrome(); // htmlUnitJS()
		$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
		// $driver = RemoteWebDriver::create($host, $capabilities);

		$driver = ChromeDriver::start($capabilities); // có thể sử dụng $driver = RemoteWebDriver::create($host, $capabilities);
		return $driver;
	}

	public function autoCheckLogin($driver, $i, $userCheck = "", $passCheck = "")
	{
		$arr = [];
		$idButton = $driver->findElement(WebDriverBy::id('id'))->sendKeys($userCheck);
		$passButton = $driver->findElement(WebDriverBy::id('pass'))->sendKeys($passCheck);
		$submitButton = $driver->findElement(WebDriverBy::cssSelector(".form_login .login"))->click();

		$check = $driver->getCurrentURL();
		// if ($check == "http://contenttype:8383/partner/saag/member/") {
		if ($check == "http://192.168.3.211:8013/partner/saag/member/") {
			$arr["user"] = $userCheck;
			$arr["pass"] = $passCheck;
			$arr["err"] = "success";
		} else {
			$arr["user"] = $userCheck;
			$arr["pass"] = $passCheck;
			$arr["err"] = $driver->findElement(WebDriverBy::cssSelector('.errLogin'))->getText();
		}
		return $arr;
	}

	public function importFileAction()
	{
		$driver = PartnerController::connectDriver();
		$driver->get("http://tool:8383/member/kakutei_log2database/");

		// echo '<pre>';
		// print_r($driver->findElement(WebDriverBy::cssSelector('.heading'))->getText());
		// echo '<pre>';
		// die();
		$fileElement = $driver->findElement(WebDriverBy::name('fileTxtUpload'));
		$nameFile = ["download_log_31-eTaxOp_AGRI_2007.txt", "download_log_11-WinKakutei_AGRI_2007.txt", "download_log_11-WinKakutei_AGRI_2008.txt", "download_log_11-WinKakutei_AGRI_2009.txt"];
		for ($i = 0; $i < 4; $i++) {
			$file_path = __DIR__ . "/../../public/import_file/" . $nameFile[$i];
			$fileElement->setFileDetector(new LocalFileDetector())
				->sendKeys($file_path);
			$fileElement->submit();
			// $err = $driver->findElement(WebDriverBy::cssSelector('#errorLog'))->getText();
			// $err = $driver->findElement(WebDriverBy::cssSelector('#errorLog'))->getAttribute('value');
			$driver->wait()->until(
				WebDriverExpectedCondition::elementTextContains(WebDriverBy::cssSelector('.heading'), 'データベースへログを保存するツール')
			);
			continue;
			// if ($err == "該当データがありません")
			// 	continue;
		}
	}

	public function importFolderAction()
	{
		$driver = PartnerController::connectDriver();
		$driver->get("http://tool:8383/member/kakutei_log2database/");
		$chooseFolder = $driver->findElement(WebDriverBy::cssSelector('select[id="typeOfUpload"] option[value="folder"]'))->click();

		$file_path = __DIR__ . "/../../public/import_file";

		$fileElement = $driver->findElement(WebDriverBy::name('fileTxtUpload'));
		$fileElement->setFileDetector(new LocalFileDetector())
			->sendKeys($file_path);
		$fileElement->submit();
		// sleep(5); // wait 5s

		// $err = $driver->findElement(WebDriverBy::cssSelector('#errorLog'))->getText();
		// $err = $driver->findElement(WebDriverBy::cssSelector('#errorLog'))->getAttribute('value');
		$driver->wait()->until(
			WebDriverExpectedCondition::elementTextContains(WebDriverBy::cssSelector('.heading'), 'データベースへログを保存するツール')
		);
	}

	public function witchWindowAction()
	{
		$driver = PartnerController::connectDriver();
		$driver->get("http://contenttype:8383/partner/saag/member/");
		// $fileElement = $driver->findElement(WebDriverBy::cssSelector('.menu.pc'))->click();
		echo "The current URL is '" . $driver->getCurrentURL() . "'\n" . "<br/>";
		$fileElement = $driver->findElement(WebDriverBy::xpath('//a[contains(text(),"SOSP検索")]'))->click();
		// sleep(2);
		$HandleCount = $driver->getWindowHandles();
		$driver->switchTo()->window($HandleCount[1]);
		echo "The current URL is '" . $driver->getCurrentURL() . "'\n" . "<br/>";
		echo '<pre>';
		print_r($HandleCount);
		echo '<pre>';
		die();
	}

	public function checkTwoside()
	{
		$driver = PartnerController::connectDriver();
		$driver->get("http://contenttype:8383/partner/saag/");
		$currentURL = $driver->getCurrentURL();
		$this->sleeping();
		$currentURL = $driver->getCurrentURL();
		// $this->autoTestLogin();
		$arrHref = $driver->findElements(WebDriverBy::xpath('//a[@href]'));
		$arr = [];
		// foreach ($arrHref as $key => $value) {
		// 	echo $value . "-" . $key;
		// }
		foreach ($arrHref as $option) {
			echo "Value is:" . $option->getAttribute('href') . '<br/>';
			if (strpos($option->getAttribute('href'), "/")) {
				$arr[] = $option->getAttribute('href');
				$arr = array_unique($arr);
			}
			// if (strpos($option->getAttribute('href'), "/")) {
			// 	$option->getLocationOnScreenOnceScrolledIntoView();
			// 	$option->click();
			// 	$this->sleeping();
			// 	if ($driver->getCurrentURL() != $currentURL) {
			// 		// $driver->switchTo()->defaultContent();
			// 		$this->sleeping();
			// 		$driver->navigate()->back();
			// 	}
			// 	$this->sleeping();
			// }
		}
		foreach ($arr as $el) {
			$el = $driver->findElement(WebDriverBy::xpath('//a[@href="' . $el . '"]'));
			$el->getLocationOnScreenOnceScrolledIntoView();
			$el->click();

			// $driver->switchTo()->window($currentURL);
			$this->sleeping();
			if ($driver->getCurrentURL() != $currentURL) {
				// $driver->switchTo()->defaultContent();
				// $this->sleeping();
				$driver->navigate()->back();
				echo $driver->getCurrentURL();
			}
			// $HandleCount = $driver->getWindowHandles();
			// foreach ($HandleCount as $key => $value) {
			// 	echo $HandleCount[$key]->getCurrentURL();
			// }

			// foreach ($HandleCount as $key => $value) {
			// 	$URL1 = $driver->switchTo()->window($HandleCount[$key])->getCurrentURL();


			// 	echo '<pre>';
			// 	print_r($URL1);
			// 	echo '<pre>';
			// }

			// $this->sleeping();
		}
		$HandleCount1 = $driver->getWindowHandles();
		// $driver->switchTo()->window($driver->getWindowHandles()[1]);
		// $URL2 = $driver->getCurrentURL();
		$a = [];
		foreach ($HandleCount1 as $key => $value) {
			$a[] = $driver->switchTo()->window($HandleCount1[$key])->getCurrentURL();
		}
		echo '<pre>';
		print_r($a);
		echo '<pre>';
		die();
		echo '<pre>';
		print_r($a);
		echo '<pre>';
		echo '<pre>';
		// print_r($arrHref);
		// print_r($HandleCount);
		echo '<pre>';
		die();
		for ($i = 0; $i < 200; $i++) {
			// $driver->executeScript('window.scrollTo(' . 0 . ',document.body.scrollHeight)');
			$driver->executeScript('window.scrollTo(0,' . $i . ')');
			sleep(0.2);
		}
		sleep(5);
		// die();

		$chooseFolder = $driver->findElement(WebDriverBy::cssSelector('a[href="https://www.sorimachi.co.jp/j/kdk/"]'))->click();
		$HandleCount = $driver->getWindowHandles();
		if (count($HandleCount) > 1) {
			$URL1 = $driver->switchTo()->window($HandleCount[0])->getCurrentURL();
			$driver->switchTo()->window($HandleCount[0]);
			// $driver->close();

			$driver->findElement(WebDriverBy::cssSelector('a[href="/partner/saag/search/"]'))->click();

			$HandleCount1 = $driver->getWindowHandles();
			// $driver->switchTo()->window($driver->getWindowHandles()[1]);
			// $URL2 = $driver->getCurrentURL();
			$a = [];
			foreach ($HandleCount1 as $key => $value) {
				$a[] = $driver->switchTo()->window($HandleCount1[$key])->getCurrentURL();
			}
			echo '<pre>';
			print_r($a);
			echo '<pre>';
			die();
		}


		echo '<pre>';
		print_r($HandleCount);
		echo '<pre>';
		die();

		sleep(2);
		$driver->get("http://contenttype:8383/partner/sosp/");
	}

	public function autoTestLogin($driver = '')
	{
		// $driver = PartnerController::connectDriver();
		// // $driver->get('http://contenttype:8383/partner/saag/');
		// $driver->get('http://192.168.3.211:8013/partner/saag/');

		// print title of the current page to output
		// echo "The title is '" . $driver->getTitle() . "'\n" . "<br/>";

		// print URL of current page to output
		// echo "The current URL is '" . $driver->getCurrentURL() . "'\n" . "<br/>";

		//check user
		$arrUserCheck = ["", "~~^", "232"];
		$arrPassCheck = ["1"];
		$nameCheck = "login";
		$arr = [];
		for ($i = 0; $i < 3; $i++) {
			$arr["user"][$i] = $this->autoCheckLogin($driver, $i, $arrUserCheck[$i], $arrPassCheck[0]);
		}

		//check pass
		$arrUserCheck = ["10101010"];
		$arrPassCheck = ["", "~~", "23"];
		for ($i = 0; $i < 3; $i++) {
			$arr["pass"][$i] = $this->autoCheckLogin($driver, $i, $arrUserCheck[0], $arrPassCheck[$i]);
		}

		//check 12 character
		$arrUserCheck = ["111111111111", "100000002107", "900000002123"];
		$arrPassCheck = ["2222"];
		for ($i = 0; $i < 3; $i++) {
			$arr["num_12"][$i] = $this->autoCheckLogin($driver, $i, $arrUserCheck[$i], $arrPassCheck[0]);
		}

		//check not 12 character
		$arrUserCheck = ["11111111", "10101010"];
		$arrPassCheck = ["2222"];
		for ($i = 0; $i < 2; $i++) {
			$arr["not_num_12"][$i] = $this->autoCheckLogin($driver, $i, $arrUserCheck[$i], $arrPassCheck[0]);
		}

		//check ky 20181206
		$arrUserCheck = ["100000002122"];
		$arrPassCheck = ["2122"];
		for ($i = 0; $i < 1; $i++) {
			$arr["ky"][$i] = $this->autoCheckLogin($driver, $i, $arrUserCheck[$i], $arrPassCheck[0]);
		}

		//access
		$arrUserCheck = ["10101010"];
		$arrPassCheck = ["1101"];
		$arr["success"] = $this->autoCheckLogin($driver, $i, $arrUserCheck[0], $arrPassCheck[0]);

		$_SESSION["data"] = $arr;
		echo '<pre>';
		print_r($_SESSION);
		echo '<pre>';
	}

	public function testClickPDF()
	{
		$driver = PartnerController::connectDriver();

		$driver->get('http://contenttype:8383/partner/saag/');
		$driver->findElement(WebDriverBy::cssSelector('a[href="https://www.sorimachi.co.jp/files_pdf/apply/saag_appl.pdf"]'))->click();
		$this->sleeping();
		$driver->navigate()->back();
	}

	public function checkSaagLogin()
	{
		$driver = PartnerController::connectDriver();
		$driver->get('http://contenttype:8383/partner/saag/');
		// $driver->get('http://192.168.3.211:8013/partner/saag/');

		// $this->autoTestLogin($driver);
		//login 10101010
		$arrUserCheck = ["10102020"];
		$arrPassCheck = ["1122"];
		$idButton = $driver->findElement(WebDriverBy::id('id'))->sendKeys($arrUserCheck[0]);
		$passButton = $driver->findElement(WebDriverBy::id('pass'))->sendKeys($arrPassCheck[0]);
		$submitButton = $driver->findElement(WebDriverBy::cssSelector(".form_login .login"))->click();

		echo  $driver->getCurrentURL();

		// $saag = new SaagController();

		SaagController::autoClickNewsing($driver);
		sleep(2);
		SaagController::autoClickDownloading($driver);
		sleep(2);
		SaagController::autoClickFaqing($driver);
		sleep(2);
		SaagController::autoClickSoluting($driver);
		sleep(2);
		SaagController::autoClickKeihiBanking($driver);
		sleep(2);
		SaagController::autoClickSeminaring($driver);
		sleep(2);
		SaagController::autoClickForming($driver);
		sleep(2);
		SaagController::autoClickMaging($driver);
		sleep(2);
		SaagController::autoClickContacting($driver);
		sleep(2);
		SaagController::autoClickSospSearching($driver);
		sleep(2);
		SaagController::autoClickSoupSearching($driver);
		sleep(2);

		$driver->close();
	}

	public function checkSospLogin()
	{
		$driver = PartnerController::connectDriver();
		$driver->get('http://contenttype:8383/partner/sosp/');
		// $driver->get('http://192.168.3.211:8013/partner/saag/');

		// $this->autoTestLogin($driver);
		//login 10101010
		$arrUserCheck = ["20202020"];
		$arrPassCheck = ["sp2222"];
		$idButton = $driver->findElement(WebDriverBy::id('id'))->sendKeys($arrUserCheck[0]);
		$passButton = $driver->findElement(WebDriverBy::id('pass'))->sendKeys($arrPassCheck[0]);
		$submitButton = $driver->findElement(WebDriverBy::cssSelector(".form_login .login"))->click();
		echo  $driver->getCurrentURL();

		SospController::autoClickNewsing($driver);
		sleep(2);
		SospController::autoClickDownloading($driver);
		sleep(2);
		SospController::autoClickFaqing($driver);
		sleep(2);
		SospController::autoClickForming($driver);
		sleep(2);
		SospController::autoClickContacting($driver);
		sleep(2);
		SospController::autoClickSoluting($driver);
		sleep(2);
		SospController::autoClickMaging($driver);
		sleep(2);

		$driver->close();
	}

	public function checkSoupLogin()
	{
		$driver = PartnerController::connectDriver();
		$driver->get('http://contenttype:8383/partner/soup/');
		// $driver->get('http://192.168.3.211:8013/partner/saag/');

		// $this->autoTestLogin($driver);
		//login 10101010
		$arrUserCheck = ["30303030"];
		$arrPassCheck = ["up3333"];
		$idButton = $driver->findElement(WebDriverBy::id('id'))->sendKeys($arrUserCheck[0]);
		$passButton = $driver->findElement(WebDriverBy::id('pass'))->sendKeys($arrPassCheck[0]);
		$submitButton = $driver->findElement(WebDriverBy::cssSelector(".form_login .login"))->click();
		echo  $driver->getCurrentURL();

		SoupController::autoClickNewsing($driver);
		sleep(2);
		SoupController::autoClickDownloading($driver);
		sleep(2);
		SoupController::autoClickFaqing($driver);
		sleep(2);
		SoupController::autoClickForming($driver);
		sleep(2);
		SoupController::autoClickContacting($driver);
		sleep(2);
		SoupController::autoClickMaging($driver);
		sleep(2);

		$driver->close();
	}

	public function checkSoiLogin()
	{
		$driver = PartnerController::connectDriver();
		$driver->get('http://contenttype:8383/partner/soi/');
		sleep(2);
		echo  $driver->getCurrentURL();

		SoiController::autoClickSteping($driver);
		sleep(2);
		SoiController::autoClickScheduling($driver);
		sleep(2);

		$driver->close();
	}

	public function checkAdminLogin()
	{
		$driver = PartnerController::connectDriver();
		$driver->get('http://contenttype:8383/partner/maintenance/login-master.php');

		// $this->autoTestLogin($driver);
		//login 10101010
		$arrUserCheck = ["admin"];
		$arrPassCheck = ["123"];
		$idButton = $driver->findElement(WebDriverBy::id('txtUid'))->sendKeys($arrUserCheck[0]);
		$passButton = $driver->findElement(WebDriverBy::id('txtUpass'))->sendKeys($arrPassCheck[0]);
		$submitButton = $driver->findElement(WebDriverBy::cssSelector("#wp-submit"))->click();
		sleep(2);
		// Common::windowScroll($driver);

		/* admin saag */
		$driver->findElement(WebDriverBy::xpath('(//button[@id=\'20181214\'])[2]'))->click();
		sleep(2);

		$el = $driver->findElement(WebDriverBy::cssSelector("#area2"));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(1);
		$el->click();
		sleep(1);

		$el = $driver->findElement(WebDriverBy::cssSelector("#area3"));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(2);
		$el->click();
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector('input[name="submit_a"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(2);
		$el->click();
		sleep(2);

		/* admin sosp */
		$el = $driver->findElement(WebDriverBy::cssSelector("#tabs #tabSosp"));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(1);
		$el->click();
		sleep(2);
		$driver->findElement(WebDriverBy::xpath('(//button[@id=\'200000181232\'])[2]'))->click();
		sleep(2);
		$el = $driver->findElement(WebDriverBy::cssSelector('textarea[id="Address"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		$el->sendKeys("test");
		sleep(2);
		// Common::windowScroll($driver);
		// sleep(2);
		$el = $driver->findElement(WebDriverBy::cssSelector('input[name="submit_a"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(2);;
		$el->click();
		sleep(1);
		/* admin soup */
		$el = $driver->findElement(WebDriverBy::cssSelector("#tabs #tabSoup"));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(1);
		$el->click();
		sleep(2);
		$driver->findElement(WebDriverBy::xpath('(//button[@id=\'10101010\'])[2]'))->click();
		sleep(2);

		$el = $driver->findElement(WebDriverBy::cssSelector('textarea[id="Address"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(2);
		$el->sendKeys("test");
		sleep(2);
		$el = $driver->findElement(WebDriverBy::cssSelector('input[name="submit_a"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(1);
		$el->click();
		die();
	}

	public function sleeping($sleep = 1)
	{
		sleep($sleep);
	}

	public function checkTotal()
	{
		$this->checkSaagLogin();
		$this->checkSospLogin();
		$this->checkSoupLogin();
		$this->checkSoiLogin();
		$this->checkAdminLogin();
	}
}
