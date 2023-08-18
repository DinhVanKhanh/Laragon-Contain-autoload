<?php

namespace App\Controllers;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\LocalFileDetector;
use Facebook\WebDriver\Remote\RemoteWebElement;

use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\WebDriverException;

use \Core\View;
use App\Common;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class SaagController extends \Core\Controller
{

	/**
	 * Show the index page
	 *
	 * @return void
	 */

	public static function autoClickContacting($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="/partner/saag/member/contact.php"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);
	}

	public static function autoClickForming($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="javascript:OpenWinForm(\'/partner/saag/member/form\')"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);

		// wait until 'PHP' is shown in the page heading element
		// $driver->wait()->until(
		// 	WebDriverExpectedCondition::elementTextContains(WebDriverBy::cssSelector('.bg_text'), '下記項目をご記入いただき、「入力内容を確認する」ボタンを押してください。')
		// );
		$HandleCount = $driver->getWindowHandles();
		if (count($HandleCount) > 1) {
			// $URL0 = $driver->switchTo()->window($HandleCount[0])->getCurrentURL();
			// $URL1 = $driver->switchTo()->window($HandleCount[1])->getCurrentURL();
			$driver->switchTo()->window($HandleCount[1]);
			// $driver->close();
			$el = $driver->findElement(WebDriverBy::cssSelector('#area1'));
			$el->getLocationOnScreenOnceScrolledIntoView();
			Common::sleeping();
			$el->click();
			Common::sleeping();

			$el = $driver->findElement(WebDriverBy::cssSelector('#submit_client'));
			$el->getLocationOnScreenOnceScrolledIntoView();
			Common::sleeping();
			$el->click();
			// $el->click();
			Common::sleeping();
			$el = $driver->findElement(WebDriverBy::cssSelector('#ok'));
			Common::sleeping();
			$el->getLocationOnScreenOnceScrolledIntoView();
			Common::sleeping();
			$el->click();
			Common::sleeping();

			$driver->close();
		}
		Common::sleeping();

		// switch window main
		$driver->switchTo()->window($HandleCount[0]);
	}

	public static function autoClickNewsing($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="/partner/saag/member/news.php"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);

		/* begin scroll */
		Common::windowScroll($driver);
	}

	public static function autoClickMaging($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="/partner/saag/member/mag.php"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);
		/* click mag-partner */
		$el = $driver->findElement(WebDriverBy::cssSelector('tr:nth-child(2) img'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);

		$HandleCount = $driver->getWindowHandles();
		if (count($HandleCount) > 1) {
			// $URL0 = $driver->switchTo()->window($HandleCount[0])->getCurrentURL();
			// $URL1 = $driver->switchTo()->window($HandleCount[1])->getCurrentURL();
			$driver->switchTo()->window($HandleCount[1]);
			sleep(3);
			$driver->close();
			$driver->switchTo()->window($HandleCount[0]);
		}

		/* click mag-user */
		$el = $driver->findElement(WebDriverBy::cssSelector('tr:nth-child(4) img'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);

		$HandleCount = $driver->getWindowHandles();
		if (count($HandleCount) > 1) {
			// $URL0 = $driver->switchTo()->window($HandleCount[0])->getCurrentURL();
			// $URL1 = $driver->switchTo()->window($HandleCount[1])->getCurrentURL();
			$driver->switchTo()->window($HandleCount[1]);
			sleep(3);
			$driver->close();
			$driver->switchTo()->window($HandleCount[0]);
		}
	}

	public static function autoClickSeminaring($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="/partner/saag/member/seminar.php"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);
		/* begin scroll */
		Common::windowScroll($driver);
	}

	public static function autoClickDownloading($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="/partner/saag/member/download.php"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);
		/* begin scroll */
		Common::windowScroll($driver);
	}

	public static function autoClickFaqing($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="/partner/saag/member/faq.php"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);
		/* begin scroll */
		Common::windowScroll($driver);
	}

	public static function autoClickSoluting($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="/partner/saag/member/solution.php"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);
		/* begin scroll */
		Common::windowScroll($driver);
	}

	public static function autoClickKeihiBanking($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="/partner/saag/member/keihi-bank.php"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);
		/* begin scroll */
		Common::windowScroll($driver);
	}

	public static function autoClickSospSearching($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="/partner/sosp/search/"]'));
		// $el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);

		$HandleCount = $driver->getWindowHandles();
		if (count($HandleCount) > 1) {
			$URL0 = $driver->switchTo()->window($HandleCount[0])->getCurrentURL();
			$URL1 = $driver->switchTo()->window($HandleCount[1])->getCurrentURL();
			$driver->switchTo()->window($HandleCount[1]);

			$el = $driver->findElement(WebDriverBy::cssSelector('#area1 option[value=\'1:北海道\']'));
			// $el->findElement(WebDriverBy::cssSelector("option[value='1:北海道']"));
			sleep(3);
			$el->click();
			sleep(3);

			/* begin scroll */
			Common::windowScroll($driver);

			sleep(8);
			$driver->close();
			// switch window main
			$driver->switchTo()->window($HandleCount[0]);
		}
	}

	public static function autoClickSoupSearching($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.sidebar-top a[href="/partner/soup/search/"]'));
		// $el->getLocationOnScreenOnceScrolledIntoView();
		$el->click();

		$HandleCount = $driver->getWindowHandles();
		if (count($HandleCount) > 1) {
			$URL0 = $driver->switchTo()->window($HandleCount[0])->getCurrentURL();
			$URL1 = $driver->switchTo()->window($HandleCount[1])->getCurrentURL();
			$driver->switchTo()->window($HandleCount[1]);

			$el = $driver->findElement(WebDriverBy::cssSelector('#area1 option[value=\'1:北海道\']'));
			sleep(3);
			$el->click();
			sleep(3);

			/* begin scroll */
			Common::windowScroll($driver);

			sleep(8);
			$driver->close();

			/* switch window main */
			$driver->switchTo()->window($HandleCount[0]);
		}
	}
}
