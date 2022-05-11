<?php

abstract class AbstractPrinter {

	protected $ip;
	protected $maxTimeout = 100000;

    //$ip = null, $timeout = null, $config = null
	public function __construct($config) {
        if(!extension_loaded('snmp')) {
            throw new Exception('SNMP extension is not loaded');
        }
        if (!empty($config["IP"])) {
            $this->setIPAddress($config["IP"]);
        }
        if (!empty($config["PRINTER_MAX_TIMEOUT"])) {
            $this->setMaxTimeout($config["PRINTER_MAX_TIMEOUT"]);
        }
        if (!empty($config)) {
            $this->setConfig($config);
        }
    }

    public function setIPAddress($ip) {
    	if (!is_string($ip)) {
            throw new Exception('Passed IP address is not string');
        }
        $this->ip = $ip;
    }

    public function getIPAddress() {
        return $this->ip;
    }

    public function setMaxTimeout($microseconds) {
        if (!is_int($microseconds)) {
            throw new Exception('Passed timeout is not integer');
        }
        $this->maxTimeout = $microseconds;
    }

    public function getMaxTimeout() {
        return $this->maxTimeout;
    }

    public function setConfig($config) {
        $this->config = $config;
    }

    public function getConfig($config) {
        return $this->config;
    }

    public function get($snmpObjectId) {
        if ($this->ip === null) {
            throw new Exception('IP address was not set');
        }
        if (!is_string($snmpObjectId)) {
            throw new Exception('SNMP Object ID is not string.');
        }

        $result = @snmpget($this->ip, 'public', $snmpObjectId, $this->maxTimeout);

        if($result === false) {
            throw new Exception("Failed to execute the SNMP request to the printer.");
        } else {
            return $result;
        }
    }

    public function walk($snmpObjectId) {
        if ($this->ip === null) {
            throw new Exception('IP address was not set.');
        }
        if (!is_string($snmpObjectId)) {
            throw new Exception('SNMP Object ID is not string.');
        }
        return @snmpwalk($this->ip, 'public', $snmpObjectId, $this->maxTimeout);
    }

    public function getSNMPString($snmpObjectId) {
        snmp_set_quick_print(true);
        $result = $this->get($snmpObjectId);
        snmp_set_quick_print(false);

        $result = str_replace('STRING', '', $result);
        $result = str_replace('"', '', $result);

        return ($result !== false) ? $result : false;
    }

    public function getSNMPInteger($snmpObjectId) {
        snmp_set_quick_print(true);
        $result = $this->get($snmpObjectId);
        snmp_set_quick_print(false);

        $result = str_replace('INTEGER', '', $result);
        $result = str_replace('"', '', $result);

        return ($result !== false) ? (int)$result : false;
    }

}