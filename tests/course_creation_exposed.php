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
 * Exposed class for PHPUnit tests, protected functions in locallib.php could be called
 *
 * @package   enrol_evento
 * @copyright 2018 HTW Chur Thomas Wieling
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once $CFG->dirroot . '/local/eventocoursecreation/classes/course_creation.php';



/*Just for Testcase*/

class local_eventocoursecreation_course_creation_exposed extends local_eventocoursecreation_course_creation
{
    public function get_future_events_exposed($modn) {
        return parent::get_future_events($modn);
    }
    public function filter_valid_create_events_exposed($var) {
        return parent::filter_valid_create_events_user($var);
    }
    public function create_new_course_exposed($event, $categoryid, local_eventocoursecreation_setting $setting) {
        return parent::create_new_course($event, $categoryid, local_eventocoursecreation_setting $setting);
    }
    public function get_restore_content_dir_exposed($templatecourse) {
        return parent::get_restore_content_dir($templatecourse);
    }
    public function create_restore_content_dir_exposed($templatecourse = null, &$errors = array()) {
        return parent::create_restore_content_dir($templatecourse = null, &$errors = array());
    }
    public function update_student_enrolment_exposed($eventopersonid, $eventoenrolstate, $instance) {

        $now = time();
        $this->timestart = make_timestamp(date('Y', $now), date('m', $now), date('d', $now), 0, 0, 0);
        $this->timeend = 0;
        $this->trace = new null_progress_trace();
        return parent::update_student_enrolment($eventopersonid, $eventoenrolstate, $instance);
    }
    public function enrol_teacher_exposed($eventopersonid, $instance) {
        $now = time();
        $this->timestart = make_timestamp(date('Y', $now), date('m', $now), date('d', $now), 0, 0, 0);
        $this->timeend = 0;
        $this->trace = new null_progress_trace();
        return parent::enrol_teacher($eventopersonid, $instance);
    }
    public function set_user_eventoid_exposed($userid, $eventoid) {
        return parent::set_user_eventoid($userid, $eventoid);
    }
}
