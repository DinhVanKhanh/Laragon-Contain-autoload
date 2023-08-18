<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Common
{
	public static function windowScroll($driver)
	{
		$actualHeight = 0;
		$nextHeight = 0;
		while (true) {
			try {
				$nextHeight += 10;
				$actualHeight =  $driver->executeScript('return document.body.scrollHeight;');
				if ($nextHeight >= ($actualHeight - 50)) break;
				$driver->executeScript("window.scrollTo(0, $nextHeight);");
				$driver->manage()->timeouts()->implicitlyWait = 5;
			} catch (Exception $e) {
				break;
			}
		}
	}

	public static function sleeping($sleep = 1)
	{
		sleep($sleep);
	}
}
