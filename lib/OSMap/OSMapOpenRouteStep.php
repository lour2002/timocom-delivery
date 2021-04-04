<?php
namespace lib\OSMap;

/**
 * class describing single step of calculated route
 *
 * @package lib\OSMap
 * @author Stefanius <s.kien@online.de>
 */
class OSMapOpenRouteStep
{
	protected $aStep = null;
	
	public function __construct($aStep=null) {
		$this->aStep = $aStep;
	}
	
	public function fromArray($aStep) {
		$this->aStep = $aStep;
	}
	
	public function getDistance() {
		$fltValue = null;
		if ($this->aStep && isset($this->aStep['distance'])) {
			$fltValue = $this->aStep['distance'];
		}
		return $fltValue;
	}

	public function getDuration() {
		$fltValue = null;
		if ($this->aStep && isset($this->aStep['duration'])) {
			$fltValue = $this->aStep['duration'];
		}
	}

	public function getInstruction() {
		$strValue = null;
		if ($this->aStep && isset($this->aStep['instruction'])) {
			$strValue = $this->aStep['instruction'];
		}
		return $strValue;
	}
	
	public function getName() {
		$strValue = null;
		if ($this->aStep && isset($this->aStep['name'])) {
			$strValue = $this->aStep['name'];
		}
		return $strValue;
	}
}
