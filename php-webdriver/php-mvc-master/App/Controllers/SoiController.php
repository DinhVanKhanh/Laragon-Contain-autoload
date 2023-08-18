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
class SoiController extends \Core\Controller
{

	/**
	 * Show the index page
	 *
	 * @return void
	 */

	public static function autoClickSteping($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.menu-soi.widget_custom_html a[href="/partner/soi/step.php"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);

		/* begin scroll */
		Common::windowScroll($driver);
	}

	public static function autoClickScheduling($driver = null)
	{
		$el = $driver->findElement(WebDriverBy::cssSelector('.menu-soi.widget_custom_html a[href="/partner/soi/schedule.php"]'));
		$el->getLocationOnScreenOnceScrolledIntoView();
		sleep(3);
		$el->click();
		sleep(3);

		/* begin scroll */
		Common::windowScroll($driver);
	}
}
