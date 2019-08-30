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
 * @copyright  2019 HTW Chur Thomas Wieling
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot . '/local/eventocoursecreation/tests/evento_service_generator.php');
require_once($CFG->dirroot . '/local/eventocoursecreation/tests/evento_data_generator.php');
class builder
{

    // @var
    public $service;

    public function __construct() {
        $this->service = new service();
    }

    public function add_anlass($anlassbezeichnung, $anlassdatumbis, $anlassdatumvon, $anlasskategorie, $anlassleitungidperson, $anlassnummer, $arrayeventoanlassleitung, $idanlass, $idanlasskategorie, $idanlassniveau, $idanlassstatus, $idanlasstyp) {
        $evento_anlass = new evento_anlass($anlassbezeichnung, $anlassdatumbis, $anlassdatumvon, $anlasskategorie, $anlassleitungidperson, $anlassnummer, $arrayeventoanlassleitung, $idanlass, $idanlasskategorie, $idanlassniveau, $idanlassstatus, $idanlasstyp);
        $this->service->evento_anlass[] = $evento_anlass;
        return $evento_anlass;
    }

    public function add_evento_anlass_status($aenderung, $aenderungvon, $erfassungvon, $idstatus, $statusname) {
        $evento_anlass_status = new evento_anlass_status($aenderung, $aenderungvon, $erfassungvon, $idstatus, $statusname);
        $this->service->evento_anlass_staten[] = $evento_anlass_status;
        return $evento_anlass_status;
    }

    public function add_evento_anlass_typ($aenderung, $aenderungvon, $anlasstypaktiv, $anlasstypbez, $erfassung, $erfassungvon, $idanlasstyp) {
        $evento_anlass_typ = new evento_anlass_typ($aenderung, $aenderungvon, $anlasstypaktiv, $anlasstypbez, $erfassung, $erfassungvon, $idanlasstyp);
        $this->service->evento_anlass_typen[] = $evento_anlass_typ;
        return $evento_anlass_typ;
    }

    public function add_person($personnachname, $personvorname, $personemail, $idperson, $idpersonstatus, $personaktiv, $personkorridperson, $personenanmeldung) {
        $evento_person = new evento_person($personnachname, $personvorname, $personemail, $idperson, $idpersonstatus, $personaktiv, $personkorridperson, $personenanmeldung);
        $this->service->evento_personen[] = $evento_person;
        return $evento_person;
    }

//Kontrollieren
    public function add_evento_personen_anmeldung($aenderung, $aenderungvon, $erfassung, $erfassungvon, $idanmeldung, $iDPAStatus, $idanlass, $idperson, $personenanmeldungstatus) {
        $evento_personen_anmeldung = new evento_personen_anmeldung($aenderung, $aenderungvon, $erfassung, $erfassungvon, $idanmeldung, $iDPAStatus, $idanlass, $idperson, $personenanmeldungstatus);
        $this->service->evento_personen_anmeldungen[] = $evento_personen_anmeldung;
        return $evento_personen_anmeldung;
    }

    public function add_anlass_leitung_rolle($anlassltgrolleaktiv, $anlassltgrollebezeichnung,  $anlassltgrollebezeichnungkrz, $anlassltgrollebezeichnungsort, $idanlassltgrolle, $aenderung, $aenderungvon, $erfassung, $erfassungvon) {
        $anlass_leitung_rolle = new anlass_leitung_rolle($anlassltgrolleaktiv, $anlassltgrollebezeichnung,  $anlassltgrollebezeichnungkrz, $anlassltgrollebezeichnungsort, $idanlassltgrolle, $aenderung, $aenderungvon, $erfassung, $erfassungvon);
        $this->service->anlass_leitung_rollen[] = $anlass_leitung_rolle;
        return $anlass_leitung_rolle;
    }

    public function add_evento_anlass_leitung($anlassleitungrolle, $anlassltgidanlass, $anlassltgidanlassltgrolle, $anlassltgidperson, $anlassltgperson, $aenderung, $aenderungvon, $erfassung, $erfassungvon, $idanlassltg) {
        $aevento_anlass_leitung = new evento_anlass_leitung($anlassleitungrolle, $anlassltgidanlass, $anlassltgidanlassltgrolle, $anlassltgidperson, $anlassltgperson, $aenderung, $aenderungvon, $erfassung, $erfassungvon, $idanlassltg);
        $this->service->evento_anlass_leitungen[] = $evento_anlass_leitung;
        return $evento_anlass_leitung;
    }

    public function add_evento_anlass_kategorie($aenderung, $aenderungvon, $anlasskategorieaktiv, $anlasskategorieBez, $erfassung, $erfassungvon, $idanlasskategoriengvon) {
        $evento_anlass_kategorie = new evento_anlass_kategorie($aenderung, $aenderungvon, $anlasskategorieaktiv, $anlasskategorieBez, $erfassung, $erfassungvon, $idanlasskategoriengvon);
        $this->service->evento_anlass_kategorien[] = $evento_anlass_kategorie;
        return $evento_anlass_kategorie;
    }

    public function add_evento_anlass_veranstalter($aenderung, $aenderungvon, $benutzeraktiv, $benutzerart, $benutzeristveranstalter, $benutzername, $erfassung, $erfassungvon, $idbenutzer) {
        $evento_anlass_veranstalter = new evento_anlass_veranstalter($aenderung, $aenderungvon, $benutzeraktiv, $benutzerart, $benutzeristveranstalter, $benutzername, $erfassung, $erfassungvon, $idbenutzer);
        $this->service->evento_anlass_veranstaltern[] = $evento_anlass_veranstalter;
        return $evento_anlass_veranstalter;
    }




}
