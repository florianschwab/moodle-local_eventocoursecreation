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
 * Evento course creation plugin
 *
 * @package    local_eventocoursecreation
 * @copyright  2018 HTW Chur Roger Barras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

// Default start date for the spring term.
define('EVENTOCOURSECREATION_DEFAULT_SPRINGTERM_STARTDAY', 15);
define('EVENTOCOURSECREATION_DEFAULT_SPRINGTERM_STARTMONTH', 12);
// Default start date for the autumn term.
define('EVENTOCOURSECREATION_DEFAULT_AUTUMNTERM_STARTDAY', 2);
define('EVENTOCOURSECREATION_DEFAULT_AUTUMNTERM_STARTMONTH', 8);
// Default start date for the spring term.
define('EVENTOCOURSECREATION_DEFAULT_SPRINGTERM_ENDDAY', 1);
define('EVENTOCOURSECREATION_DEFAULT_SPRINGTERM_ENDMONTH', 3);
// Default start date for the autumn term.
define('EVENTOCOURSECREATION_DEFAULT_AUTUMNTERM_ENDDAY', 1);
define('EVENTOCOURSECREATION_DEFAULT_AUTUMNTERM_ENDMONTH', 10);


/**
 * Delimiter for different module numbers in the category idnumber
 */
define('EVENTOCOURSECREATION_IDNUMBER_DELIMITER', '|');

/**
 * Delimiter to separate different in the category idnumber
 */
define('EVENTOCOURSECREATION_IDNUMBER_OPTIONS_DELIMITER', '§');

/**
 * Prefix for category idnumbers which contains module numbers
 */
define('EVENTOCOURSECREATION_IDNUMBER_PREFIX', 'mod.');

/**
 * Prefix for spring term inside evento eventnumbers
 */
define('EVENTOCOURSECREATION_SPRINGTERM_PREFIX', 'FS');

/**
 * Prefix for autumn term inside evento eventnumbers
 */
define('EVENTOCOURSECREATION_AUTUMNTERM_PREFIX', 'HS');
