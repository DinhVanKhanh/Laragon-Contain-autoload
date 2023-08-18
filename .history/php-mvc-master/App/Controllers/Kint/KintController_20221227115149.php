<?php

namespace App\Controllers\Shokokai;

use \Core\View;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\LocalFileDetector;
use Facebook\WebDriver\Remote\RemoteWebElement;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\WebDriverException;
use App\Common;

use App\Controllers\PartnerController;

/**
 * Home controller
 *
 * PHP version 7.0
 */
require_once(__DIR__ . '/../../../../vendor/autoload.php');
// require_once(__DIR__ . '/../../../../../common_files/smtp_mail.php');
class KintController extends \Core\Controller
{

	/**
	 * Show the index page
	 *
	 * @return void
	 */
	public function indexAction()
	{
		// $driver = new PartnerController("");
		// $driver = $driver->connectDriver();
		// This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/

		$driver = KintController::connectDriver();
		$driver->get('http://192.168.90.7:8065/ClockCardInput/Default.asp');
		sleep(2);
		echo  $driver->getCurrentURL() . '<br/>';
		KintController::login($driver);
		sleep(2);

		$driver->close();
	}

	public static function connectDriver()
	{
		// This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/
		$host = 'http://localhost:4444/wd/hub';

		$capabilities = DesiredCapabilities::chrome();

		$driver = RemoteWebDriver::create($host, $capabilities);

		return $driver;
	}

	public static function login($driver)
	{
		$idInput = $driver->findElement(WebDriverBy::id('employeeID'))->sendKeys('0112');
		$passInput = $driver->findElement(WebDriverBy::id('password'))->sendKeys('vankhanh');
		$submitButton = $driver->findElement(WebDriverBy::cssSelector(".clsFunctionButton"))->click();
		echo  $driver->getCurrentURL() . '<br/>';
	}
	public static function insert($driver)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.nav:nth-child(1)'))->click();
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector('#memberId'))->sendKeys('test');
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector('#memberPw'))->sendKeys('test');
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector("#rememberPw"))->sendKeys('test');
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector("#showhide"))->click();
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector('select[id="memberStatus"] option[value="3"]'))->click();
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector("#memberComment"))->sendKeys('test');
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector("#submit_ud"))->click();
		sleep(1);
		//search
		KintController::search($driver);
	}

	public static function edit($driver)
	{
		$idElement = $driver->findElement(WebDriverBy::cssSelector(".odd:nth-child(1) > .sorting_1"))->getText();
		sleep(1);
		// $el = $driver->findElement(WebDriverBy::cssSelector("#\265"))->click();
		$el = $driver->findElement(WebDriverBy::xpath("//button[@id='{$idElement}']"))->click();

		sleep(1);

		$el = $driver->findElement(WebDriverBy::cssSelector('select[id="memberStatus"] option[value="0"]'))->click();
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector("#memberComment"))->sendKeys('test');
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector("#submit_ud"))->click();
		sleep(1);
	}

	public static function search($driver)
	{
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector("#searchtest"))->sendKeys('test');
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector("#searchbtn"))->click();
		sleep(1);
		// $idSearch = $driver->findElement(WebDriverBy::cssSelector(".dataTables_empty"))->getText();
		$idSearch = $driver->findElement(WebDriverBy::cssSelector("#table_idTest_info"))->getText();

		if (empty($idSearch))
			return false;
		return true;
	}
}
