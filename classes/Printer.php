<?php

class Printer extends AbstractPrinter {

	public function getFactoryId() {
		return $this->getSNMPString($this->config["SNMP_PRINTER_FACTORY_ID"]);
	}

	public function getVendorName() {
        return $this->getSNMPString($this->config["SNMP_PRINTER_VENDOR_NAME"]);
    }

	public function getSerialNumber() {
        return $this->getSNMPString($this->config["SNMP_PRINTER_SERIAL_NUMBER"]);
    }

    public function getNumberOfPrintedPapers() {
        return $this->getSNMPInteger($this->config["SNMP_NUMBER_OF_PRINTED_PAPERS"]);
    }

    public function getNumberOfPrintedBlacks() {
        return $this->getSNMPInteger($this->config["SNMP_NUMBER_OF_PRINTED_BLACKS"]);        
    }

    public function getNumberOfPrintedColors() {
        return $this->getSNMPInteger($this->config["SNMP_NUMBER_OF_PRINTED_COLORS"]);        
    }

    public function getBlackTonerLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["BLACK_TONER"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["BLACK_TONER"]
        );
    }

    public function getBlackTonerFirstLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["BLACK_TONER_1"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["BLACK_TONER_1"]
        );
    }

    public function getBlackTonerSecondLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["BLACK_TONER_2"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["BLACK_TONER_2"]
        );
    }

    public function getCyanTonerLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["CYAN_TONER"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["CYAN_TONER"]
        );
    }

    public function getMagentaTonerLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["MAGENTA_TONER"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["MAGENTA_TONER"]
        );
    }

    public function getYellowTonerLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["YELLOW_TONER"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["YELLOW_TONER"]
        );
    }

    public function getWasteContainerLevel() {
        $level = $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["WASTE_CONTAINER"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["WASTE_CONTAINER"]
        );

        if($level == $this->config["MARKER_SUPPLIES_UNAVAILABLE"]) return "Remaining Unavailable";
        if($level == $this->config["MARKER_SUPPLIES_UNKNOWN"]) return "Unknown Remaining";
        if($level == $this->config["MARKER_SUPPLIES_SOME_REMAINING"]) return "Some Remaining";
    }

    public function getFuserAssemblyLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["FUSER_ASSEMBLY"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["FUSER_ASSEMBLY"]
        );
    }

    public function getBlackDrumLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["BLACK_DRUM"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["BLACK_DRUM"]
        );
    }

    public function getCyanDrumLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["CYAN_DRUM"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["CYAN_DRUM"]
        );
    }

    public function getMagentaDrumLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["MAGENTA_DRUM"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["MAGENTA_DRUM"]
        );
    }

    public function getYellowDrumLevel() {
        return $this->getSubUnitPercentageLevel(
            $this->config["SNMP_SUPPLIES_MAX_CAPACITY_SLOTS"]["YELLOW_DRUM"],
            $this->config["SNMP_SUPPLIES_ACTUAL_CAPACITY_SLOTS"]["YELLOW_DRUM"]
        );
    }

    protected function getSubUnitPercentageLevel($maxValueSNMPSlot, $actualValueSNMPSlot) {
        $max = $this->getSNMPInteger($maxValueSNMPSlot);
        $actual = $this->getSNMPInteger($actualValueSNMPSlot);

        if ($max === false || $actual === false) {
            return false;
        }
        if ((int) $actual <= 0) {
            //Actual level is unavailable, unknown or some unknown remaining
            return (int) $actual;
        } else {
            //Counting result in percent format
            return ($actual / ($max / 100));
        }
    }
}