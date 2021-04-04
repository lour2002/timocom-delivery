<?php
namespace lib\OSMap;

/**
 * class to determine route for given start/end geolocations
 * using openroute service REST API
 * 
 * @link https://openrouteservice.org
 *
 * @package lib\OSMap
 * @author Stefanius <s.kien@online.de>
 */
class OSMapOpenRoute
{
	/** base url for all REST services of OpenRoute API		*/
	const	REST_API_URL = 'https://api.openrouteservice.org/v2/';
	
	/** vehicle type: car	 */
	const 	VT_CAR			= 'driving-car';
	/** vehicle type: hgv (heavy goods vehicle ... > 3.5t)	 */
	const 	VT_HGV			= 'driving-hgv';
	/** vehicle type: 	'normal' bicycle		*/
	const 	VT_BICYCLE		=	'cycling-regular';
	/** vehicle type: 	roadbike				*/
	const 	VT_ROAD_BIKE	=	'cycling-road';
	/** vehicle type: 	mountainbike			*/
	const 	VT_MTB			=	'cycling-mountain';
	/** vehicle type: 	electric bike			*/
	const 	VT_E_BIKE		=	'cycling-electric';
	/** vehicle type: 	'normal' walking		*/
	const	VT_WALKING		= 'foot-walking';
	/** vehicle type: 	hiking					*/
	const	VT_HIKING		= 'foot-walking';
	/** vehicle type: 	wheelchair				*/
	const	VT_WHEELCHAIR 	= 'wheelchair';
	
	/** find shortest route	 */
	const	FASTEST			= 'shortest';
	/** find fastest route	 */
	const	SHORTEST		= 'fastest';

	/** instructions as plain text	 */
	const	IF_TEXT			= 'text';
	/** instructions as html	 */
	const	IF_HTML			= 'html';
	
	/** distances in m (meter)	 */
	const 	UNITS_M			= 'm';
	/** distances in km (kilometer)	 */
	const 	UNITS_KM		= 'km';
	/** distances in miles	 */
	const 	UNITS_MILES		= 'mi';
	
	/** format response as json	 */
	const	FMT_JSON		= 'json';
	/** format response as geojson	 */
	const	FMT_GEOJSON		= 'geojson';
	/** format response as gpx	 */
	const	FMT_GPX			= 'gpx';
	
	/** @var string		API Key from https://openrouteservice.org/dev	*/
	protected 	$strKey	 = '';
	/** @var string		language (short ISO 3166-3; NOT all languages are supported!)		*/
	protected	$strLanguage = '';
	/** @var string		format of the response		*/
	protected	$strFormat		= self::FMT_JSON;
	/** @var string		vehicle type		*/
	protected	$strVehicleType	= self::VT_CAR;
	/** @var string		preference		*/
	protected 	$strPreference	= self::FASTEST;
	/** @var bool		generate instructions		*/
	protected 	$bInstructions	= false;
	/** @var string		format for instruction		*/
	protected 	$strInstructionFormat	= self::IF_TEXT;
	/** @var string		units for distances (m, km, mi)		*/
	protected 	$strUnits		= self::UNITS_M;
	/** @var bool		include elevation informations (ascent/descent)		*/
	protected	$bElevation		= false;
	
	/** @var string		last error		*/
	protected	$strError;
	/** @var string		raw response		*/
	protected	$response;
	/** @var array		JSON response as associative array		*/
	protected	$aJson;
	
	/**
	 * crate object and set API key
	 * 
	 * to get a API key, you must register at (registration is free!)
	 * 	https://openrouteservice.org/dev/#/home
	 * and request new token. All further description ist found at the
	 * openrouteservice.org - page. 
	 * 
	 * @param string $strKey
	 */
	public function __construct($strKey) {
		$this->strKey = $strKey;
	}
	
	/**
	 * calculate Route for requested points.
	 * parameters can be either objects of class OSMapPoint or comma 
	 * separated geolocation string 'latitude, longitude
	 * 
	 * if the coordinates are passed as an array with more than 2 points, 
	 * the response will result in several segments with the respective sections.
	 * (number of segments = number of points less than one) 
	 *  
	 * @param OSMapPoint/string $pt1
	 * @param OSMapPoint/string $pt2
	 */
	public function calcRoute($pt1, $pt2=null) {
		$bOK = false;
		$aCoordinates = array();
		if (is_array($pt1) && count($pt1) > 1 && !$pt2) {
			// multiple coordinates ...
			for ($i = 0; $i < count($pt1); $i++) {
				$aCoordinates[] = $this->coordinate($pt1[$i]);
			}
		} elseif ($pt2) {
			// ... start-end coordinates
			$aCoordinates[] = $this->coordinate($pt1);
			$aCoordinates[] = $this->coordinate($pt2);
		}

		// at least two points are necessary...
		if (count($aCoordinates) > 1) {
			$aData = array();
			$aData['coordinates']	= $aCoordinates;
			$aData['instructions']	= $this->bInstructions;
			
			if (strlen($this->strLanguage) > 0 && strtolower($this->strLanguage != 'en')) {
				$aData['language'] = $this->strLanguage; 
			}
			if ($this->bElevation) {
				$aData['elevation'] = true;
			}
			if (strlen($this->strInstructionFormat) > 0 && strtolower($this->strInstructionFormat != self::IF_TEXT)) {
				$aData['instructions_format'] = 'html';
			}
			if (strlen($this->strPreference) > 0 && strtolower($this->strPreference != self::FASTEST)) {
				$aData['preference'] = $this->strPreference;
			}
			if (strlen($this->strUnits) > 0 && strtolower($this->strUnits != self::UNITS_M)) {
				$aData['units'] = $this->strUnits;
			}
			$jsonData = json_encode($aData);
			
			$strURL = self::REST_API_URL . 'directions/' . $this->strVehicleType . '/' . $this->strFormat;
			$bOK = $this->postHttpRequest($strURL, $jsonData);
		} else {
			$this->strError = 'invalid coordinates.';
		}
		return $bOK;
	}
	
	/**
	 * build coordinate array .
	 * API wants to have coordinates in lon, lat!
	 * 
	 * @param unknown $pt
	 * @return array or null, if no valid argument
	 */
	protected function coordinate($pt) {
		$aCoordinate = null;
		if (is_object($pt)) {
			// OSMapPoint
			$aCoordinate = array($pt->lon,$pt->lat);
		} elseif (strpos($pt, ',') !== false) {
			// have to be string containing lat, lon separated by comma
			$aPt = explode(',', $pt);
			if (count($aPt) == 2) {
				$aCoordinate = array(trim($aPt[1]), trim($aPt[0]));
			}
		}
		return $aCoordinate;
	}
	
	/**
	 * post HttpRequest with given data.
	 * in case of error more information can be obtained with getError ()
	 *  
	 * @param string $strURL
	 * @param string $jsonData
	 * @return boolean true if succeeded, false in case of error
	 */
	protected function postHttpRequest($strURL, $jsonData) {
		$bOK = true;
		$curl = curl_init($strURL);
	
		$aHeader = array(
			'Content-Type: application/json; charset=utf-8',
			'Accept: application/json, application/geo+json, application/gpx+xml; charset=utf-8',
			'Content-Length: ' . strlen($jsonData),
			'Authorization: ' . $this->strKey
		);
	
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $aHeader);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	
		$this->response = curl_exec($curl);
		$this->aJson = null;
		if (curl_errno($curl)) {
			$this->strError = curl_error($curl);
			$bOK = false;
		} else {
			$iReturnCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
			if ($iReturnCode != 200) {
				$bOK = false;
				$aJson = json_decode($this->response, true);
				if (is_array($aJson) && isset($aJson['error']))	{
					$this->strError = (is_array($aJson['error']) ? $aJson['error']['message'] : $aJson['error']);
				}
			}
		}
		curl_close($curl);
		
		return $bOK;
	}
	
	/**
	 * get distance in defined units (m, km, mi).
	 * returns only valid value, if format is self::FMT_JSON
	 * 
	 * segment value only available, if OSMapOpenRoute::enableInstructions(true) is set.
	 * 
	 * @param int $iSeg	index of requested segment; distance over all if null (default)
	 * @return float
	 */
	public function getDistance($iSeg=null) {
		return $this->getValue('distance', $iSeg);
	}

	/**
	 * get duration in seconds.
	 * returns only valid value, if format is self::FMT_JSON
	 * 
	 * segment value only available, if OSMapOpenRoute::enableInstructions(true) is set.
	 * 
	 * @param int $iSeg	index of requested segment; duration over all if null (default)
	 * @return float
	 */
	public function getDuration($iSeg=null) {
		return $this->getValue('duration', $iSeg);
	}

	/**
	 * get ascent in defined units (m, km, mi).
	 * returns only valid value, if format is self::FMT_JSON 
	 * and OSMapOpenRoute::enableElevation(true) is set.
	 * 
	 * segment value only available, if OSMapOpenRoute::enableInstructions(true) is set.
	 * 
	 * @param int $iSeg	index of requested segment; duration over all if null (default)
	 * @return float
	 */
	public function getAscent($iSeg=null) {
		return $this->getValue('ascent', $iSeg);
	}

	/**
	 * get descent in defined units (m, km, mi).
	 * returns only valid value, if format is self::FMT_JSON 
	 * and OSMapOpenRoute::enableElevation(true) is set.
	 * 
	 * segment value only available, if OSMapOpenRoute::enableInstructions(true) is set.
	 * 
	 * @param int $iSeg	index of requested segment; duration over all if null (default)
	 * @return float
	 */
	public function getDescent($iSeg=null) {
		return $this->getValue('descent', $iSeg);
	}
	
	/**
	 * get requested value.
	 * if iSeg specified, values are read from the instruction list, 
	 * otherwise over all values from the summary.
	 * 
	 * segment value only available, if OSMapOpenRoute::enableInstructions(true) is set.
	 *  
	 * @param unknown $strName
	 * @param string $iSeg
	 * @return NULL
	 */
	protected function getValue($strName, $iSeg=null) {
		$fltValue = null;
		if ($iSeg === null) {
			$fltValue = $this->getSummaryValue($strName);
		} else {
			$fltValue = $this->getSegmentValue($iSeg, $strName);
		}
		return $fltValue;
	}

	/**
	 * get count of segments.
	 * dependent of the number of point specified to calc the route, the response
	 * contains one (for two points from-to) or more segments.
	 * value only available, if OSMapOpenRoute::enableInstructions(true) is set.
	 * @return number
	 */
	public function getSegmentCount() {
		$iCount = 0;
		if (($aSegments = $this->getSegments()) !== null) {
			$iCount = count($aSegments);
		}
		return $iCount;
	}
	
	/**
	 * get count of instruction steps inside given segment.
	 * value only available, if OSMapOpenRoute::enableInstructions(true) is set.
	 * @return number
	 */
	public function getStepCount($iSeg) {
		$iCount = 0;
		if (($aSegments = $this->getSegments()) !== null) {
			$aSteps = $this->getSegmentValue($iSeg, 'steps');
			$iCount = count($aSteps);
		}
		return $iCount;
	}

	/**
	 * get requested step from segment.
	 * if $bArray set to true, result will be associative array, otherwise object from 
	 * class OSMapOpenRouteStep
	 * 
	 * @param int $iSeg
	 * @param int $iStep
	 * @param bool $bArray	
	 * @return \OSMapOpenRouteStep or array, dependent of param $bArray or null, if step not available
	 */
	public function getStep($iSeg, $iStep, $bArray=false) {
		$step = null;
		if (($aSegments = $this->getSegments()) !== null) {
			$aSteps = $this->getSegmentValue($iSeg, 'steps');
			if ($aSteps && $iStep < count($aSteps)) {
				$aStep = $aSteps[$iStep];
				$aStep['instruction'] = utf8_decode($aStep['instruction']);
				$aStep['name'] = utf8_decode($aStep['name']);
				$step = ($bArray ? $aStep : new OSMapOpenRouteStep($aStep));
			}
		}
		return $step;
	}
	
	/**
	 * get the requisted segment
	 * @return array or null, if no segments available
	 */
	protected function getSegments() {
		$aSegments = null;
		if ($this->strFormat == self::FMT_JSON && $this->response) {
			if (!$this->aJson) {
				$this->aJson = json_decode($this->response, true);
			}
			if (is_array($this->aJson) && isset($this->aJson['routes']) && is_array($this->aJson['routes'])) {
				$aRoute = $this->aJson['routes'][0];
				$aSegments = (isset($aRoute['segments']) && is_array($aRoute['segments'])) ? $aRoute['segments'] : null;
			}
		}
		return $aSegments;
	}

	/**
	 * read value from given segment of the JSON response
	 *
	 * @param int $iSeg	number of the segment
	 * @param string $strName
	 * @return value or null if ot exist
	 */
	protected function getSegmentValue($iSeg, $strName) {
		$value = null;
		$aSegments = $this->getSegments();
		if ($aSegments && $iSeg < count($aSegments)) {
			$value = isset($aSegments[$iSeg][$strName]) ? $aSegments[$iSeg][$strName] : null;
		}
		return $value;
	}
	
	/**
	 * read value from the sumary of the JSON response
	 * 
	 * @param string $strName
	 * @return value or null if ot exist
	 */
	protected function getSummaryValue($strName) {
		$fltValue = null;
		if ($this->strFormat == self::FMT_JSON && $this->response) {
			if (!$this->aJson) {
				$this->aJson = json_decode($this->response, true);
			}
			if (is_array($this->aJson) && isset($this->aJson['routes']) && is_array($this->aJson['routes'])) {
				$aRoute = $this->aJson['routes'][0];
				$fltValue = isset($aRoute['summary'][$strName]) ? $aRoute['summary'][$strName] : null;
			}
		}
		return $fltValue;
	}

	/**
	 * get units for all distances (m, km, mi)
	 * @return string
	 */
	public function getUnits() {
		return $this->strUnits;
	}
	
	/**
	 * save response as json/gpx file dependent on format to file on server
	 * @param string $strFilename
	 */
	public function saveRoute($strFilename='') {
		$this->saveOrDownload(true, $strFilename);
	}

	/**
	 * download response as json/gpx file dependent on format
	 * @param unknown $strFilename
	 */
	public function downloadRoute($strFilename='') {
		$this->saveOrDownload(false, $strFilename);
	}
	
	/**
	 * save or download response as json/gpx file dependent on format
	 * @param bool $bSave	true to save file on server, false to force download
	 * @param string $strFilename
	 */
	protected function saveOrDownload($bSave, $strFilename) {
		if ($this->response) {
			$strData = '';
			$strType = '';
			// ... make it readable before saving/downloading
			if ($this->strFormat == self::FMT_JSON || $this->strFormat == self::FMT_GEOJSON) {
				$strData = json_encode(json_decode($this->response), JSON_PRETTY_PRINT);
				if (strlen($strFilename) == 0) {
					$strFilename = 'route.json';
				} elseif (strpos($strFilename, '.') === false) {
					$strFilename .= '.json';
				}
				if ($bSave) {
					file_put_contents($strFilename, $strData);
				} else {
					$strType = ($this->strFormat == self::FMT_JSON ? 'json' : 'geo+json');
				}
			} elseif ($this->strFormat == self::FMT_GPX) {
				$oDoc = new \DOMDocument();
				$oDoc->preserveWhiteSpace = false;
				$oDoc->formatOutput = true;
				$oDoc->loadXML($this->response);
				if (strlen($strFilename) == 0) {
					$strFilename = 'route.gpx';
				} elseif (strpos($strFilename, '.') === false) {
					$strFilename .= '.gpx';
				}
				if ($bSave) {
					$oDoc->save($strFilename);
				} else {
					$strData = $oDoc->saveXML();
					$strType = 'gpx+xml';
				}
			}
			if (!$bSave) {
				header('Content-Type: application/' . $strType . '; charset=utf-8');
				header('Content-Length: ' . strlen($strData));
				header('Connection: close' );
				header('Content-Disposition: attachment; filename=' . $strFilename);
				echo $strData;
			}
		}
	}
	
	/**
	 * raw response data for further processing
	 * @return string (JSON, GeoJSO, or GPX-XML Data)
	 */
	public function getResponse() {
		return $this->response;
	}

	/**
	 * last error 
	 * @return string
	 */
	public function getError() {
		return $this->strError;
	}
	
	/**
	 * set language.
	 * ISO 3166-3  -  NOT all languages are supported!
	 * 
	 * supported languages:
	 * 'en', 'de', 'cn', 'es', 'ru', 'dk', 'fr', 'it', 'nl', 'br', 'se', 'tr', 'gr'
	 * 
	 * @param string $strLanguage
	 */
	public function setLanguage($strLanguage) {
		$this->strLanguage = strtolower($strLanguage);
	}

	/**
	 * set vehicle type.
	 * valid types:
	 * - self::VT_CAR			car
	 * - self::VT_HGV			hgv (heavy goods vehicle ... > 3.5t)
	 * - self::VT_BICYCLE		'normal' bicycle
	 * - self::VT_ROAD_BIKE		roadbike
	 * - self::VT_MTB			mountainbike
	 * - self::VT_E_BIKE		electric bike
	 * - self::VT_WALKING		'normal' walking
	 * - self::VT_HIKING		hiking
	 * - self::VT_WHEELCHAIR	wheelchair
	 * 
	 * if no type selected self::VT_CAR is assumed
	 * 
	 * @param string $strVehicleType
	 */
	public function setVehicleType($strVehicleType) {
		$this->strVehicleType = $strVehicleType;
	}

	/**
	 * self::FMT_JSON, self::FMT_GEOJSON or self::FMT_GPX
	 * 
	 * access to details via properties/methods only available for format self::FMT_JSON
	 * 
	 *   other formats usefull for display
	 *   
	 * @param string $strFormat
	 */
	public function setFormat($strFormat) {
		$this->strFormat = $strFormat;
	}

	/**
	 * preference for calculation.
	 * whether self::FASTEST (default) or self::SHORTEST
	 * @param string $strPreference
	 */
	public function setPreference($strPreference) {
		$this->strPreference = $strPreference;
	}

	/**
	 * enable generating instructions
	 * @param boolean $bInstructions
	 */
	public function enableInstructions($bInstructions=true) {
		$this->bInstructions = $bInstructions;
	}

	/**
	 * format for the instructions
	 * whether	self::IF_TEXT (default) or self::IF_HTML
	 * @param string $strInstructionFormat
	 */
	public function setInstructionFormat($strInstructionFormat) {
		$this->strInstructionFormat = $strInstructionFormat;
	}

	/**
	 * set units for distance values
	 * one of self::UNITS_M (default),self::UNITS_KM or self::UNITS_MILES
	 * @param string $strUnits
	 */
	public function setUnits($strUnits) {
		$this->strUnits = $strUnits;
	}

	/**
	 * enable generation of elevation information (for over all route and segments)
	 * @param boolean $bElevation
	 */
	public function enableElevation($bElevation=true) {
		$this->bElevation = $bElevation;
	}
}
