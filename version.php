<?php
// Software version identification.
// This is used for display purposes, and also the major/minor/patch
// numbers are stored in the database and used to determine which sql
// upgrade file is the starting point for the next upgrade.
$v_major = '4';
$v_minor = '1';
$v_patch = '1';
$v_tag   = '-hlh'; // minor revision number, should be empty for production releases

// A real patch identifier. This is incremented when release a patch for a
// production release. Not the above $v_patch variable is a misnomer and actually
// stores release version information.
$v_realpatch = '0';

// Database version identifier, this is to be incremented whenever there
// is a database change in the course of development.  It is used
// internally to determine when a database upgrade is needed.
//
// THIS VERSION NUMBER IS MEDASKO specific, be careful if we merge with OpenEMR upstream (tm)
$v_database = 79;
?>
