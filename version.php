<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * @package    mod_forumqta
 * @copyright  2016 Cyberlearn HES-SO, Leyun Xia<leyun.xia@hevs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
//must define this parameter in order to use Q2A libraries
//define('QA_VERSION', '1.6.3');

$plugin->version   = 2018091402;       // The current module version (Date: YYYYMMDDXX)
$plugin->requires  = 2010031900;       // Requires this Moodle version
$plugin->cron      = 0;
$plugin->component = 'mod_forumqta';
$plugin->maturity  = MATURITY_STABLE;
$plugin->release   = "Stable";
