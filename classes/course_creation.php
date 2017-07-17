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
/**
 * Delimiter for different module numbers in the category idnumber
 */
define('LOCAL_EVENTOCOURSECREATION_IDNUMBER_DELIMITER', '|');

/**
 * Prefix for category idnumbers which contains module numbers
 */
define('LOCAL_EVENTOCOURSECREATION_IDNUMBER_PREFIX', 'mod.');

/**
 * Class definition for the evento course creation
 *
 * @package    local_eventocoursecreation
 * @copyright  2017 HTW Chur Roger Barras
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class local_eventocoursecreation_course_creation {
    // Plugin configuration.
    private $config;
    // trace reference to null_progress_trace
    protected $trace;
    // evento WS reference to local_evento_evento_service
    protected $eventoservice;
    // soapfaultcodes for stop execution
    protected $stopsoapfaultcodes = array('HTTP', 'soapenv:Server', 'Server');
    // Evento enrolplugin
    protected $enrolplugin;

    /**
     * Initialize the service keeping reference to the soap-client
     *
     * @param SoapClient $client
     */
    public function __construct() {
        $this->config = get_config('local_eventocoursecreation');
        $this->eventoservice = new local_evento_evento_service();
        $this->enrolplugin = enrol_get_plugin('evento');
    }

    /**
     * Sync all categories with evento links.
     *
     * @param progress_trace $trace
     * @param int $categoryid one category, empty means all
     * @return int 0 means ok, 1 means error, 2 means plugin disabled
     */
    public function course_sync(progress_trace $trace, $categoryid = null) {
        global $CFG;
        try {
            require_once($CFG->libdir. '/coursecatlib.php');

            // Init.
            $this->trace = $trace;
            // Todo check if enabled

            if ($this->config->enableplugin == 0) {
                $pluginname = new lang_string('pluginname', 'local_eventocoursecreation');
                $this->trace->output($pluginname . " plugin not enabled");
                $this->trace->finished();
                return 2;
            }
            // Unfortunately this may take a long time, execution can be interrupted safely here.
            core_php_time_limit::raise();
            raise_memory_limit(MEMORY_HUGE);

            if (!$this->eventoservice->init_call()) {
                // webservice not available
                $this->trace->output("Evento webservice not available");
                return 2;
            }

            $this->trace->output('Starting evento course synchronisation...');

            if (isset($categoryid)) {
                $categories = self::get_category_records("cc.id = :catid", array('catid' => $categoryid));
            } else {
                $categories = self::get_categories(LOCAL_EVENTOCOURSECREATION_IDNUMBER_PREFIX);
            }
            foreach ($categories as $cat) {
                $modnumbers = self::get_module_ids($cat->idnumber);

                foreach ($modnumbers as $modn) {
                    try {
                        // hole alle Evento module mit gleicher eventonumer bsp: "mod.bsp%" und welche aktiv, oder Startdatum in der Zukunft liegt.
                        $events = $this::get_future_events($modn);
                        $subcat = null;

                        foreach ($events as $event) {
                            try {
                                $starttime = strtotime($event->anlassDatumVon) ? strtotime($event->anlassDatumVon) : null;
                                $period = self::get_module_period($event->anlassNummer, $starttime);

                                // Get or create the period subcategory
                                if (empty($subcat)) {
                                    $subcatidnumber = implode('|', $modnumbers) . '.' . $period;
                                    $subcat = self::get_subcategory_by_idnumber($subcatidnumber);
                                    // create category
                                    if (empty($subcat)) {
                                        $newcat = new stdClass();
                                        $newcat->name = $this->create_period_category_name($period);
                                        $newcat->parent = $cat->id;
                                        $newcat->idnumber = $subcatidnumber;
                                        $subcat = coursecat::create($newcat);
                                    }
                                }
                                // Create an empty course
                                $newcourse = $this->create_new_course($event, $subcat->id);
                                // Add Evento enroment instance
                                if (isset($newcourse) && isset($this->enrolplugin) && enrol_is_enabled('evento')) {
                                    $this->enrolplugin->add_instance($newcourse);
                                }
                            } catch (SoapFault $fault) {
                                debugging("Soapfault : ". $fault->__toString());
                                $this->trace->output("...evento course synchronisation aborted unexpected with a soapfault during "
                                                    . "sync of catid: {$cat->id}; eventnr.:{$modn};");
                                if (in_array($fault->faultcode, $this->stopsoapfaultcodes)) {
                                    // Stop execution.
                                    $this->trace->finished();
                                    return 1;
                                }
                            } catch (Exception $ex) {
                                debugging("Category sync with id {$cat->id}; eventnr.:{$modn} aborted with error: ". $ex->getMessage());
                                $this->trace->output("...evento course synchronisation aborted unexpected during "
                                                    . "sync of catid: {$cat->id}; eventnr.:{$modn};");
                            } catch (Throwable $ex) {
                                debugging("Category sync with id {$cat->id}; eventnr.:{$modn} aborted with error: ". $ex->getMessage());
                                $this->trace->output("...evento course synchronisation aborted unexpected during "
                                                    . "sync of catid: {$cat->id}; eventnr.:{$modn};");
                            }
                        }
                        unset($subcat);

                    } catch (SoapFault $fault) {
                        debugging("Soapfault : ". $fault->__toString());
                        $this->trace->output("...evento course synchronisation aborted unexpected with a soapfault during "
                                            . "sync of catid: {$cat->id}; eventnr.:{$modn};");
                        if (in_array($fault->faultcode, $this->stopsoapfaultcodes)) {
                            // Stop execution.
                            $this->trace->finished();
                            return 1;
                        }
                    } catch (Exception $ex) {
                        debugging("Category sync with id {$cat->id}; eventnr.:{$modn} aborted with error: ". $ex->getMessage());
                        $this->trace->output("...evento course synchronisation aborted unexpected during "
                                            . "sync of catid: {$cat->id}; eventnr.:{$modn};");
                    } catch (Throwable $ex) {
                        debugging("Category sync with id {$cat->id}; eventnr.:{$modn} aborted with error: ". $ex->getMessage());
                        $this->trace->output("...evento course synchronisation aborted unexpected during "
                                            . "sync of catid: {$cat->id}; eventnr.:{$modn};");
                    }
                }

            }
        } catch (SoapFault $fault) {
            debugging("Error Soapfault: ". $fault->__toString());
            $this->trace->output("...evento course synchronisation aborted unexpected with a soapfault");
            $this->trace->finished();
            return 1;
        } catch (Exeption $ex) {
            debugging("Error: ". $ex->getMessage());
            $this->trace->output('... evento course synchronisation aborted unexpected');
            $this->trace->finished();
            return 1;
        } catch (Throwable $ex) {
            debugging("Error: ". $ex->getMessage());
            $this->trace->output('... evento course synchronisation aborted unexpected');
            $this->trace->finished();
            return 1;
        }
        $this->trace->output('Evento course synchronisation finished...');
        $this->trace->finished();
        return 0;
    }

    /**
     * Get categories with a defined idnumber prefix
     *
     * @param string $catidnprefix prefix of the cat idnumber
     * @return array of stdClass objects of categories
     */
    public static function get_categories($catidnprefix) {

        $whereclause = "UPPER(cc.idnumber) like UPPER(:catidnprefix)";
        $params = array('catidnprefix' => $catidnprefix . "%");
        $result = self::get_category_records($whereclause, $params);

        return $result;
    }

    /**
     * Get subcategories with a defined idnumber prefix
     *
     * @param string $subcatname name of the subcategory
     * @param int $parentcatid category id of the parent
     * @return array of stdClass objects of categories
     */
    public static function get_subcategory_by_name($subcatname, $parentcatid) {

        if (!isset($parentcatid) || !isset($subcatname)) {
            return null;
        }
        $whereclause = "(UPPER(cc.name) = UPPER(:subcatname)) AND (cc.parent = :parentcatid)";
        $params = array('subcatname' => $subcatname, 'parentcatid' => $parentcatid );
        $result = self::get_category_records($whereclause, $params);

        return $result;
    }

    /**
     * Get subcategories with a defined idnumber prefix
     *
     * @param string $idnumber idnumber of the categorie
     * @return stdClass object of the category
     */
    public static function get_subcategory_by_idnumber($idnumber) {

        if (empty($idnumber)) {
            return null;
        }
        $whereclause = "(UPPER(cc.idnumber) = UPPER(:idnumber))";
        $params = array('idnumber' => $idnumber);
        $result = self::get_category_records($whereclause, $params);
        $return = reset($result);

        return $return;
    }

    /**
     * Extract the evento module numbers from the idnumber
     * delimited by | ignore numbers without the module prefix
     *
     * @param string $idnumber idnumber of a category
     * @return array array of strings with module numbers
     */
    public static function get_module_ids($idnumber) {
        $result = array();
        $result = explode(LOCAL_EVENTOCOURSECREATION_IDNUMBER_DELIMITER, $idnumber);
        $idnprefix = LOCAL_EVENTOCOURSECREATION_IDNUMBER_PREFIX;
        $result = array_filter($result,
                            function ($var) use ($idnprefix) {
                                return (strncasecmp($var, $idnprefix, 4) == 0);
                            }
        );

        return $result;
    }

    /**
     * Extract the evento period (term) from the idnumber
     * assume it is the third part of the eventumber separated by '.'
     * Sets a default Value the period not matches a valid pattern
     *
     * @param string $eventnumber idnumber of a category
     * @param int $eventstarttime starttimestamp of the event
     * @return string period
     */
    public static function get_module_period($eventnumber, $eventstarttime = null) {
        $modnumbers = array();
        $result = null;

        if (isset($eventnumber)) {
            // Get the third part of the eventnumber
            $modnumbers = explode('.', $eventnumber);
            if (array_key_exists(2, $modnumbers)) {
                $result = $modnumbers[2];
            }
        }

        // Is the term set or valid ?
        if (!isset($result) || (!stristr($result, "HS") && !stristr($result, "FS"))) {
            // Get the default term string
            if (isset($eventstarttime)) {
                $month = date('n', $eventstarttime);
                $year = date('y', $eventstarttime);
                $fsmonths = array('2', '3', '4', '5', '6', '7');
                if (in_array($month, $fsmonths)) {
                    $term = "FS";
                } else {
                    $term = "HS";
                }
                $result = $term . $year;
            }
        }

        return $result;
    }

    /**
     * Gets valid future events to be created
     *
     * @param string $modn evento module prefix
     * @return array filtered array of evento events
     */
    protected function get_future_events($modn) {

        $limitationfilter2 = new local_evento_limitationfilter2();
        $eventoanlassfilter = new local_evento_eventoanlassfilter();

        $limitationfilter2->thefromdate = date(LOCAL_EVENTO_DATETIME_FORMAT, strtotime('-1 year'));
        $limitationfilter2->thetodate = date(LOCAL_EVENTO_DATETIME_FORMAT, time());
        $limitationfilter2->themaxresultvalue = 10000;

        $eventoanlassfilter->anlassnummer = $modn . '%';
        $eventoanlassfilter->idanlasstyp = local_evento_idanlasstyp::MODULANLASS;

        $events = local_evento_evento_service::to_array($this->eventoservice->get_events_by_filter($eventoanlassfilter, $limitationfilter2));
        $result = array_filter($events, array($this, 'filter_valid_create_events'));

        return $result;
    }

    /**
     * Filter methode to filter events, which are in the future with
     * active enrolments
     *
     * @param array $event array of evento
     * @return bool
     */
    protected function filter_valid_create_events($var) {
        $return = false;
        $now = time();
        // Has start date?
        if (empty($var->anlassDatumVon)) {
            return false;
        }
        // Future start date
        $fromdate = strtotime($var->anlassDatumVon);
        if ($fromdate >= $now) {
            $return = true;
        }
        if ($return) {
            // Not "Abgesagt"
            if ($var->idAnlassStatus != '10230') {
                $return = true;
            }
        }
        if ($return) {
            // Has enrolments?
            $eventoenrolments = local_evento_evento_service::to_array($this->eventoservice->get_enrolments_by_eventid($var->idAnlass));
            if (!empty($eventoenrolments)) {
                $return = true;
            }
        }
        return $return;
    }


    /**
     * Create a new empty hidden course in a category
     *
     * @param array $event array of evento
     * @param int $catid category to create
     * @return object new course instance
     */
    protected function create_new_course($event, $categoryid) {
        global $CFG;
        try {
            require_once("$CFG->dirroot/course/lib.php");
            $return = null;
            $newcourse = new stdClass();

            if (!empty($event->anlassNummer)) {
                $newcourse->idnumber = trim($event->anlassNummer);
            } else {
                break;
            }
            $newcourse->shortname = trim(str_replace(LOCAL_EVENTOCOURSECREATION_IDNUMBER_PREFIX, "", $event->anlassNummer));
            $newcourse->fullname = trim($event->anlassBezeichnung);
            $newcourse->category = $categoryid;
            if (!empty($event->anlassDatumVon)) {
                $newcourse->startdate = strtotime($event->anlassDatumVon);
            }
            if (!empty($event->anlassDatumBis)) {
                $newcourse->enddate = strtotime($event->anlassDatumBis);
            }
            $newcourse->visible = 0;
            $return = create_course($newcourse);

        } catch (moodle_exception $ex) {
            if (($ex->errorcode == 'courseidnumbertaken') || ($ex->errorcode == 'shortnametaken')) {
                // course already exists not needed to be created
                return $return;
            } else {
                throw $ex;
            }
        }
        return $return;
    }

    /**
     * Retrieves number of records from course_categories table
     *
     * Records are ready for preloading context
     * Runction similar to  coursecat->get_records() in coursecatlib.php
     *
     * @param string $whereclause
     * @param array $params
     * @return array array of stdClass objects
     */
    protected static function get_category_records($whereclause, $params) {
        global $DB;

        $fields = array('id', 'idnumber', 'parent');
        $ctxselect = context_helper::get_preload_record_columns_sql('ctx');
        $sql = "SELECT cc.". join(',cc.', $fields). ", $ctxselect
                FROM {course_categories} cc
                JOIN {context} ctx ON cc.id = ctx.instanceid AND ctx.contextlevel = :contextcoursecat
                WHERE ". $whereclause." ORDER BY cc.sortorder";
        return $DB->get_records_sql($sql,
                array('contextcoursecat' => CONTEXT_COURSECAT) + $params);
    }


    /**
     * Create the category name of a period
     *
     * @param string $period
     * @param int $starttimestamp
     * @return string array of stdClass objects
     */
    protected function create_period_category_name($period, $starttimestamp = null) {
        global $DB;

        // Todo generate a different categoryname for the period

        return $period;
    }

}
