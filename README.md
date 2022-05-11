PHP project for getting Xerox printer's data in a network through the SNMP protocol
==============

Project based on petrkohut/SNMP-printer-library, adjusted by JeroenSteen to match XeroxC60 and W7545 printer.

Run Composer dump-autoload to autoload classes Printer and AbstractPrinter

The MIB file 'SNMPv2-SMI.txt' can be found from Net-SNMP project.
The Net-SNMP program itself can be used to find printer specific OID's.

Put in Apache settings: SetEnv MIBDIRS "C:/Program Files/Net-SNMP/share/snmp/mibs/".

Rename in configs specific_printers_example.json to specific_printers.json.
Place printer specific OID's in configs/specific_printers.json.