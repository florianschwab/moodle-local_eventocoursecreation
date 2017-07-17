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
 * @copyright  2017 HTW Chur Roger Barras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

    $settings = new admin_settingpage('local_eventocoursecreation', get_string('pluginname', 'local_eventocoursecreation'));
    $ADMIN->add('localplugins', $settings);
    // General Settings.
    $settings->add(new admin_setting_heading('local_eventocoursecreation_settings', '', get_string('pluginname_desc', 'local_eventocoursecreation')));
    $settings->add(new admin_setting_configcheckbox('local_eventocoursecreation/enableplugin',
        new lang_string('enableplugin', 'local_eventocoursecreation'),
        new lang_string('enableplugin_help', 'local_eventocoursecreation'), 1));
}
