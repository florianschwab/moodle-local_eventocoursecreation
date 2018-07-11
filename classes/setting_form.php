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
 * Custom settings interface for evento course creation
 *
 * @package   local_eventocoursecreation
 * @copyright 2018 HTW Chur Roger Barras
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined( 'MOODLE_INTERNAL' ) || die();

require_once($CFG->libdir . '/formslib.php');

/**
 * Evento course Creation setting form
 *
 * @copyright  2018 HTW Chur Roger Barras
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_eventocoursecreation_setting_form extends moodleform {

    // Define the form.
    public function definition() {
        global $OUTPUT, $DB;
        $mform = $this->_form;

        list($data) = $this->_customdata;
        $categoryid = $data['categoryid'];
        $contextid = $data['contextid'];
        $idnumber = $data['idnumber'];

        // Default values.
        $config = get_config('local_eventocoursecreation');

        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->setExpanded('general');

        // Coursofstudies = category idnumber.
        $mform->addElement('text', 'idnumber', get_string('idnumber', 'local_eventocoursecreation'), array('size' => '15'));
        $mform->setType('idnumber', PARAM_TEXT);
        $mform->setDefault('idnumber', $idnumber);
        $mform->addHelpButton('idnumber', 'idnumber', 'local_eventocoursecreation');

        // Spring Term.
        $mform->addElement('header', 'startspringterm', get_string('startspringterm', 'local_eventocoursecreation'));
        $mform->setExpanded('startspringterm');
        $mform->addElement('text', 'starttimespringtermday', get_string('springstartday', 'local_eventocoursecreation'), array('size' => '2'));
        $mform->setType('starttimespringtermday', PARAM_INT);
        $mform->addHelpButton('starttimespringtermday', 'springstartday', 'local_eventocoursecreation');
        $mform->addElement('text', 'starttimespringtermmonth', get_string('springstartmonth', 'local_eventocoursecreation'), array('size' => '2'));
        $mform->setType('starttimespringtermmonth', PARAM_INT);
        $mform->addHelpButton('starttimespringtermmonth', 'springstartmonth', 'local_eventocoursecreation');
        $mform->addElement('advcheckbox', 'execonlyonstarttimespringterm', get_string('execonlyonstarttimespringterm', 'local_eventocoursecreation'),
                            '', null, array(0, 1));
        $mform->addHelpButton('execonlyonstarttimespringterm', 'execonlyonstarttimespringterm', 'local_eventocoursecreation');

        // Autumn Term.
        $mform->addElement('header', 'startautumnterm', get_string('startautumnterm', 'local_eventocoursecreation'));
        $mform->setExpanded('startautumnterm');
        $mform->addElement('text', 'starttimeautumntermday', get_string('autumnstartday', 'local_eventocoursecreation'), array('size' => '2'));
        $mform->setType('starttimeautumntermday', PARAM_INT);
        $mform->addHelpButton('starttimeautumntermday', 'autumnstartday', 'local_eventocoursecreation');
        $mform->addElement('text', 'starttimeautumntermmonth', get_string('autumnstartmonth', 'local_eventocoursecreation'), array('size' => '2'));
        $mform->setType('starttimeautumntermmonth', PARAM_INT);
        $mform->addHelpButton('starttimeautumntermmonth', 'autumnstartmonth', 'local_eventocoursecreation');
        $mform->addElement('advcheckbox', 'execonlyonstarttimeautumnterm', get_string('execonlyonstarttimeautumnterm', 'local_eventocoursecreation'),
                            '', null, array(0, 1));
        $mform->addHelpButton('execonlyonstarttimeautumnterm', 'execonlyonstarttimeautumnterm', 'local_eventocoursecreation');

        // Hidden Params.
        $mform->addElement('hidden', 'category', 0);
        $mform->setType('category', PARAM_INT);
        $mform->setDefault('category', $categoryid);

        $mform->addElement('hidden', 'contextid', 0);
        $mform->setType('contextid', PARAM_INT);
        $mform->setDefault('contextid', $contextid);

        $this->add_action_buttons( true, get_string('savechanges'));

    }

    // Validate the form.
    public function validation($data, $files) {
        global $DB;
        $errors = parent::validation($data, $files);
        if (!empty($data['idnumber'])) {
            if ($existing = $DB->get_record('course_categories', array('idnumber' => $data['idnumber']))) {
                if (!$data['category'] || $existing->id != $data['category']) {
                    $errors['idnumber'] = get_string('categoryidnumbertaken', 'error');
                }
            }
        }

        // Day.
        if ((int)($data['starttimespringtermday'] < 1) || (int)($data['starttimespringtermday'] > 31)) {
            $errors['starttimespringtermday'] = get_string('dayinvalid', 'local_eventocoursecreation');
        }

        if ((int)($data['starttimeautumntermday'] < 1) || (int)($data['starttimeautumntermday'] > 31)) {
            $errors['starttimeautumntermday'] = get_string('dayinvalid', 'local_eventocoursecreation');
        }

        // Month.
        if (((int)$data['starttimespringtermmonth'] < 1) || (int)($data['starttimespringtermmonth'] > 12)) {
            $errors['starttimespringtermmonth'] = get_string('monthinvalid', 'local_eventocoursecreation');
        }

        if ((int)($data['starttimeautumntermmonth'] < 1) || (int)($data['starttimeautumntermmonth'] > 12)) {
            $errors['starttimeautumntermmonth'] = get_string('monthinvalid', 'local_eventocoursecreation');
        }

        return $errors;
    }
}