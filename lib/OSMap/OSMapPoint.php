<?php
namespace lib\OSMap;

/**
 * class representing a geolocation  (WGS 1984)
 *
 * @package lib\OSMap
 * @author Stefanius <s.kien@online.de>
 */
class OSMapPoint
{
	/** @var float	 */
	public $lat = null;
	/** @var float	 */
	public $lon = null;
	
	/**
	 * @param float $lat
	 * @param float $lon
	 */
	public function __construct($lat = null, $lon = null) {
		$this->lat = $lat;
		$this->lon = $lon;
	}
	
	/**
	 * check, if object is set 
	 * @return boolean
	 */
	public function is_set() {
		return $this->lat != null && $this->lon != null;
	}

	/** 
	 * calculates distance of point from given point in km
	 * @param OSMapPoint $ptFrom
	 * @return float
	 */
	public function distanceFrom(OSMapPoint $ptFrom) {
		$fltDist = null;
		if ($this->is_set()) {
			$fltDist = OSMapEmbedded::getDistance($this->lat, $this->lon, $ptFrom->lat, $ptFrom->lon);
		}
		return $fltDist;
	}
}