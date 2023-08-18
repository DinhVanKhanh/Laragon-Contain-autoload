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
class ShokokaiController extends \Core\Controller
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

		$driver = ShokokaiController::connectDriver();
		$driver->get('http://shokokai:8383/admin/login.php');
		sleep(2);
		echo  $driver->getCurrentURL() . '<br/>';
		ShokokaiController::login($driver);
		sleep(2);
		// ShokokaiController::importFileCSV($driver);
		// sleep(2);
		$checkSearch = ShokokaiController::search($driver);
		if (!$checkSearch) {
			sleep(2);
			//reset search
			$el = $driver->findElement(WebDriverBy::cssSelector("#resetbtn"))->click();
			ShokokaiController::insert($driver);
		}
		sleep(2);
		ShokokaiController::edit($driver);
		sleep(2);
		ShokokaiController::delete($driver);

		die();

		// if ($err == "該当データがありません")
		// 	continue;

		die();
		$driver->close();
	}

	public static function importFileCSV($driver)
	{
		$fileElement = $driver->findElement(WebDriverBy::cssSelector("#ipExcel"));
		$file_path = __DIR__ . "/../../../public/import_file/shokokai/test1.csv";
		$fileElement->setFileDetector(new LocalFileDetector())
			->sendKeys($file_path);
		// $fileElement->submit();
		sleep(1);
		$fileElement = $driver->findElement(WebDriverBy::xpath('//button[contains(.,"取り込み開始")]'));
		$fileElement->click();
		sleep(4);
		// $fileElement->submit();
		// $a = $driver->findElement(WebDriverBy::cssSelector('p.message'))->getAttribute('value');
		// $b = $driver->findElement(WebDriverBy::cssSelector('p.message'))->getText();
		// $HandleCount = $driver->getWindowHandles();

		$fileElement = $driver->findElement(WebDriverBy::cssSelector("#submit_del_ok"));
		$fileElement->getLocationOnScreenOnceScrolledIntoView();
		sleep(5);
		$fileElement->click();
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
		$arrUserCheck = ["LoginID01"];
		$arrPassCheck = ["LoginPW01"];
		// $idButton = $driver->findElement(WebDriverBy::id('id_email'))->sendKeys($arrUserCheck[0]);
		// $passButton = $driver->findElement(WebDriverBy::id('id_password'))->sendKeys($arrPassCheck[0]);
		$submitButton = $driver->findElement(WebDriverBy::cssSelector(".login_button"))->click();
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
		ShokokaiController::search($driver);
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

	public static function delete($driver)
	{
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector(".btnConfirmDel"))->click();
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector("#submit_del"))->click();
		sleep(1);
		$el = $driver->findElement(WebDriverBy::cssSelector("#submit_del_ok"))->click();
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
