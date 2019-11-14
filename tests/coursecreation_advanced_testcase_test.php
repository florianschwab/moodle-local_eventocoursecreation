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
 * Unit-Test for enrolment plugin
 *
 * @package    enrol_evento
 * @copyright  2018 HTW Chur Thomas Wieling
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
global $CFG;
use PHPUnit\Framework\Error\Error;

require_once($CFG->dirroot . '/local/eventocoursecreation/interface.php');
require_once($CFG->dirroot . '/local/eventocoursecreation/tests/builder.php');

class mod_evento_advanced_testcase extends advanced_testcase {
    /** @var stdClass Instance. */
    private $instance;
    /** @var stdClass Student. */
    private $student;
    /** @var stdClass First course. */
    private $course1;
    /** @var stdClass Second course. */
    private $course2;
    /** @var stdClass Second course. */
    private $cat1;
    /** @var stdClass Second course. */
    private $cat2;
    /** @var stdClass Plugin. */
    private $plugin;
    /** @var stdClass Plugin. */
    private $locallib;
    /** @var stdClass Plugin. */
    private $user_enrolment;
    /** @var stdClass Plugin. */
    private $enrolments;
    /** @var stdClass Plugin. */
    private $simulator;

    /*Create courses*/
    protected function create_moodle_course() {
        $plugin = 'evento';
        $evento_plugin = enrol_get_plugin($plugin);
        $course1 = $this->getDataGenerator()->create_course(array('category' => $this->cat1->id, 'idnumber' => 'mod.mmpAUKATE1.HS18_BS.001'));
        $instanceid = $evento_plugin->add_default_instance($course1);
    }

    protected function setUp() {
        global $DB;
        /*Create Moodle categories*/
        $this->cat1 = $this->getDataGenerator()->create_category();
        $this->cat2 = $this->getDataGenerator()->create_category();
        /*Create Object $locallib*/

        $builder = new builder;
        /*Create Evento Course*/
        $evento_anlass = $builder->add_anlass("Audio- & Kameratechnik 1", "2019-02-17T00:00:00.000+01:00", "2018-09-17T00:00:00.000+02:00", null, 117829, "mod.mmpAUKATE1.HS18_BS.001", null, 25490, 1, 60, 10230, 3 );
        $evento_anlass = $builder->add_anlass("Audio- & Kameratechnik 2", "2019-02-17T00:00:00.000+01:00", "2018-09-17T00:00:00.000+02:00", null, 117828, "mod.mmpAUKATE1.HS18_BS.002", null, 25491, 1, 60, 10230, 3 );
        var_dump($evento_anlass);
        /**/
        $evento_status = $builder->add_evento_anlass_status(20215, "aA.Angemeldet", "BI_gzap", 30040, "2008-07-04T10:03:23.000+02:00");
        /*Create evento person Hans Meier*/
/*        $evento_personen_anmeldung = $builder->add_personen_anmeldung("2019-02-17T00:00:00.000+01:00", "hoferlis", "2018-06-05T08:58:20.723+02:00", "auto", 415864, 20215, 25490, 141703, $evento_status);
        $evento_person = $builder->add_person("Meier", "Hans", "hans.meier@stud.htwchur.ch",  141703, 30040, true, 141703, $evento_personen_anmeldung);
        $ad_account = $builder->add_ad_account(0, "2019-02-17T00:00:00.000+01:00", "2019-02-17T00:00:00.000+01:00", 0, 141703, 0, 0, 1, "S-1-5-21-2460181390-1097805571-3701207438-51315", "HanMei");
*/

    }

    /*Enable plugin method*/
    protected function enable_plugin() {
        $enabled = enrol_get_plugins(true);
        $enabled['evento'] = true;
        $enabled = array_keys($enabled);
        set_config('enrol_plugins_enabled', implode(',', $enabled));
    }

    /*Disable plugin method*/
    protected function disable_plugin() {
        $enabled = enrol_get_plugins(true);
        $enabled = array_keys($enabled);
        set_config('enrol_plugins_enabled', implode(',', $enabled));
    }



    /*Simuation test if plugin is enabled*/
    /**
     * @test
     */


    /*Basic test if plugin is enabled*/
    /**
     * @test
     */
     public function basic() {
         $anlass = $this->simulator->get_event_by_number("mod.mmpAUKATE1.HS18_BS.001");
         var_dump($anlass);
         $personenanmeldung = $this->simulator->get_enrolments_by_eventid(25490);
         $personenanmeldung = $this->simulator->get_enrolments_by_eventid(25490);

         $person = $this->simulator->get_person_by_id(141703);
         $person = $this->simulator->get_person_by_id(117828);
         $ad_account = $this->simulator->get_ad_accounts_by_evento_personid(141701, null, null);
         $ad_account_student = $this->simulator->get_all_ad_accounts(null);
     }

}
