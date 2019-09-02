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
 * Evento enrolment plugin main library file.
 *
 * @package   enrol_evento
 * @copyright 2019 HTW Chur Thomas Wieling
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


class evento_anlass_status{

    public $aenderung;
    public $aenderungvon;
    public $erfassungvon;
    public $idstatus;
    public $statusname;

    public function __construct( string $aenderung, string $aenderungvon, string $erfassungvon, int $idstatus, string $statusname) {
        $this->aenderung = $aenderung;
        $this->aenderungvon = $aenderungvon;
        $this->erfassungvon = $erfassungvon;
        $this->idstatus = $idstatus;
        $this->statusname = $statusname;
    }
}

class evento_anlass_typ{

    public $aenderung;
    public $aenderungvon;
    public $anlasstypaktiv;
    public $anlasstypbez;
    public $erfassung;
    public $erfassungvon;
    public $idanlasstyp;

    public function __construct(string $aenderung, string $aenderungvon, boolean $anlasstypaktiv, string $anlasstypbez, string $erfassung, string $erfassungvon, int $idanlasstyp) {

        $this->aenderung = $aenderung;
        $this->aenderungVon = $aenderungvon;
        $this->anlasstypaktiv = $anlasstypaktiv;
        $this->anlasstypbez = $anlasstypbez;
        $this->erfassung = $erfassung;
        $this->erfassungvon = $erfassungvon;
        $this->idanlasstyp = $idanlasstyp;
    }
}

class evento_anlass_ltg_person{

    public $personNachname;
    public $personVorname;

    public function __construct(string $personNachname, string $personVorname){

        $this->personNachname = $personNachname;
        $this->personVorname = $personVorname;
    }
}

//Kontrollieren
class evento_personen_anmeldung{

    public $idanmeldung;
    public $iDPAStatus;
    public $idanlass;
    public $idperson;
    public $personenanmeldungstatus;
    public $aenderung;
    public $aenderungvon;
    public $erfassung;
    public $erfassungvon;

    public function __construct(string $aenderung, string $aenderungvon, string $erfassung, string $erfassungvon, int $idanmeldung, int $iDPAStatus, int $idanlass, int $idperson, object $personenanmeldungstatus) {

        $this->aenderung = $aenderung;
        $this->aenderungvon = $aenderungvon;
        $this->erfassung = $erfassung;
        $this->erfassungvon = $erfassungvon;
        $this->idanmeldung = $idanmeldung;
        $this->iDPAStatus = $iDPAStatus;
        $this->idanlass = $idanlass;
        $this->idperson = $idperson;
        $this->personenanmeldungstatus = $personenanmeldungstatus;
    }
}

class evento_person{

    public $personnachname;
    public $personvorname;
    public $personemail;
    public $idperson;
    public $idpersonstatus;
    public $personaktiv;
    public $personkorridperson;
    public $personenanmeldung;

    public function __construct(string $personnachname, string $personvorname, string $personemail, int $idperson, int $idpersonstatus,  $personaktiv, int $personkorridperson, object $personenanmeldung)
    {
        $this->personnachname = $personnachname;
        $this->personvorname = $personvorname;
        $this->personemail = $personemail;
        $this->idperson = $idperson;
        $this->idpersonstatus = $idpersonstatus;
        $this->personaktiv = $personaktiv;
        $this->personkorridperson = $personkorridperson;
        $this->personenanmeldung = $personenanmeldung;
    }
}

class anlass_leitung_rolle{

    public $anlassltgrolleaktiv;
    public $anlassltgrollebezeichnung;
    public $anlassltgrollebezeichnungkrz;
    public $anlassltgrollebezeichnungsort;
    public $idanlassltgrolle;
    public $aenderung;
    public $aenderungvon;
    public $erfassung;
    public $erfassungvon;

    public function __construct( boolean $anlassltgrolleaktiv, string $anlassltgrollebezeichnung,  string $anlassltgrollebezeichnungkrz, string $anlassltgrollebezeichnungsort, int $idanlassltgrolle, string $aenderung, string $aenderungvon, string $erfassung, string $erfassungvon) {

        $this->anlassLtgrolleaktiv = $anlassltgrolleaktiv;
        $this->anlassltgrollebezeichnung = $anlassltgrollebezeichnung;
        $this->anlassltgrollebezeichnungkrz = $anlassltgrollebezeichnungkrz;
        $this->anlassltgrollebezeichnungsort = $anlassltgrollebezeichnungsort;
        $this->idanlassltgrolle = $idanlassltgrolle;
        $this->aenderung = $aenderung;
        $this->aenderungvon = $aenderungvon;
        $this->erfassung = $erfassung;
        $this->erfassungvon = $erfassungvon;
    }
}

class evento_anlass_leitung{

    public $anlassleitungrolle;
    public $anlassltgidanlass;
    public $anlassltgidanlassltgrolle;
    public $anlassltgidperson;
    public $anlassltgperson;
    public $aenderung;
    public $aenderungvon;
    public $erfassung;
    public $erfassungvon;
    public $idanlassltg;

    public function __construct(anlass_ltg_person $anlassleitungrolle, int $anlassltgidanlass, int $anlassltgidanlassltgrolle, int $anlassltgidperson, anlass_ltg_person $anlassltgperson, string $aenderung, string $aenderungvon, string $erfassung, string $erfassungvon, int $idanlassltg) {

        $this->anlassleitungrolle = $anlassleitungrolle;
        $this->anlassltgidanlass = $anlassltgidanlass;
        $this->anlassltgidanlassltgrolle = $anlassltgidanlassltgrolle;
        $this->anlassltgidperson = $anlassltgidperson;
        $this->anlassltgperson = $anlassltgperson;
        $this->aenderung = $aenderung;
        $this->aenderungvon = $aenderungvon;
        $this->erfassung = $erfassung;
        $this->erfassungvon = $erfassungvon;
        $this->idanlassltg = $idanlassltg;
    }
}

class evento_anlass_kategorie{


    public $anlasskategorie;
    public $aenderung;
    public $aenderungvon;
    public $anlasskategorieaktiv;
    public $anlasskategoriebez;
    public $erfassung;
    public $erfassungvon;
    public $idanlasskategorie;

    public function __construct(string $aenderung, string $aenderungvon, boolean $anlasskategorieaktiv, string $anlasskategorieBez, string $erfassung, string $erfassungvon, int $idanlasskategorie){

        $this->anlasskategorie;
        $this->$aenderung;
        $this->$aenderungvon;
        $this->$anlasskategorieaktiv;
        $this->$anlasskategoriebez;
        $this->$erfassung;
        $this->erfassungvon;
        $this->$idanlasskategorie;
    }
}

class evento_anlass_veranstalter{

    public $aenderung;
    public $aenderungvon;
    public $benutzeraktiv;
    public $benutzerart;
    public $benutzeristveranstalter;
    public $benutzername;
    public $erfassung;
    public $erfassungvon;
    public $idbenutzer;

    public function __construct(string $aenderung, string $aenderungvon, boolean $benutzeraktiv, string $benutzerart, boolean $benutzeristveranstalter, string $benutzername, string $erfassung, string $erfassungvon, string $idbenutzer){

        $this->$aenderung = $aenderung;
        $this->$aenderungvon = $aenderungvon;
        $this->$benutzeraktiv = $benutzeraktiv;
        $this->$benutzerart = $benutzerart;
        $this->$benutzeristveranstalter = $benutzeristveranstalter;
        $this->$benutzername = $benutzername;
        $this->$erfassung = $erfassung;
        $this->$erfassungvon = $erfassungvon;
        $this->$idbenutzer = $idbenutzer;
    }
}

//class evento_anlass_ltg_person{}

class evento_anlass{

    ["aenderung"]=>
    string(29) "2019-04-08T13:32:48.000+02:00"

    ["anlassBezeichnung"]=>
    string(38) "Wahlpflichtmodul 6: Experience Reality"
    ["anlassDatumBis"]=>
    string(29) "2020-02-16T00:00:00.000+01:00"
    ["anlassDatumVon"]=>
    string(29) "2019-09-16T00:00:00.000+02:00"
    ["anlassKategorie"]=> object(stdClass)#11669 (7) {}
    ["anlassLeitungIdPerson"]=>
    int(144896)
    ["anlassNummer"]=>
    string(24) "mod.dbmWPFL6.HS19_BS.001"
    ["anlassStatus"]=>object(stdClass)#11670 (5) {}
    ["anlassTyp"]=>object(stdClass)#11671 (7) {}
    ["anlass_Veranstalter"]=> object(stdClass)#11672 (9) {}
    ["array_EventoAnlassLeitung"]=>object(stdClass)#11673 (10) {}
      ["anlassLtgIdAnlass"]=>
      int(28119)
      ["anlassLtgIdAnlassLtgRolle"]=>
      int(2)
      ["anlassLtgIdPerson"]=>
      int(144896)
      ["anlassLtgPerson"]=>
      object(stdClass)#11675 (57) {
        ["LFSKanton"]=>
        string(2) "SG"
        ["PGChefIDPerson"]=>
        NULL
        ["aenderung"]=>
        string(29) "2018-08-06T10:11:21.243+02:00"
        ["aenderungVon"]=>
        string(2) "AX"
        ["array_adressen"]=> array(2) {}
        ["erfassung"]=>
        string(29) "2018-04-18T09:06:42.700+02:00"
        ["erfassungVon"]=>
        string(2) "AX"
        ["idPerson"]=>
        int(144896)
        ["idPersonStatus"]=>
        int(30040)
        ["personAdresse1"]=>
        string(14) "Loftstrasse 26"
        ["personAdresse2"]=>
        NULL
        ["personAktiv"]=>
        bool(true)
        ["personAnrede"]=>
        string(4) "Frau"
        ["personBriefanrede"]=>
        string(25) "Sehr geehrte Frau Tschanz"
        ["personFirma1"]=>
        NULL
        ["personFirma2"]=>
        NULL
        ["personFirmaIdPerson"]=>
        NULL
        ["personGebDatum"]=>
        NULL
        ["personKorrIdPerson"]=>
        int(144896)
        ["personLand"]=>
        string(2) "CH"
        ["personNachname"]=>
        string(7) "Tschanz"
        ["personOrt"]=>
        string(10) "Walenstadt"
        ["personPlz"]=>
        string(4) "8880"
        ["personRechIdPerson"]=>
        int(144896)
        ["personSex"]=>
        string(1) "F"
        ["personSource"]=>
        string(6) "Axapta"
        ["personSourceKey"]=>
        int(2000451)
        ["personTelefax"]=>
        NULL
        ["personTelefon1"]=>
        string(16) "+41 79 577 35 50"
        ["personTelefon2"]=>
        string(16) "+41 81 286 38 04"
        ["personTitel"]=>
        NULL
        ["personUnikat"]=>
        bool(false)
        ["personVorname"]=>
        string(7) "Nathaly"
        ["person_AHVNr"]=>
        NULL
        ["person_AkadTitel"]=>
        NULL
        ["person_Beruf"]=>
        NULL
        ["person_Buergerort"]=>
        NULL
        ["person_Buergerorte"]=>
        NULL
        ["person_DebitorenNr"]=>
        int(0)
        ["person_Funktion"]=>
        NULL
        ["person_HatFoto"]=>
        bool(false)
        ["person_IDLFS_Gemeinde_vStdBeg"]=>
        NULL
        ["person_IDLFS_Land"]=>
        NULL
        ["person_IDLFS_Muttersprache"]=>
        NULL
        ["person_IDLFS_Schule"]=>
        NULL
        ["person_IDLFS_Zulassungsausweis"]=>
        NULL
        ["person_Korrespondenzsprache"]=>
        int(1)
        ["person_MWSTNr"]=>
        int(0)
        ["person_Matrikelnummer"]=>
        NULL
        ["person_Mobile"]=>
        NULL
        ["person_NurFuerGruppenbildung"]=>
        bool(false)
        ["person_URL"]=>
        NULL
        ["person_Vorname2"]=>
        string(4) "Sara"
        ["person_Zusatz1"]=>
        string(6) "144896"
        ["person_eMail2"]=>
        string(23) "mail@nathaly-tschanz.ch"
        ["personeMail"]=>
        string(26) "nathaly.tschanz@htwchur.ch"
        ["personenStatus"]=>
        object(stdClass)#11680 (5) {
          ["aenderung"]=>
          string(29) "2004-06-22T09:39:11.000+02:00"
          ["aenderungVon"]=>
          string(7) "balzano"
          ["erfassungVon"]=>
          string(4) "auto"
          ["idStatus"]=>
          int(30040)
          ["statusName"]=>
          string(8) "ps.Aktiv"
        }
      }

    }

    public $anlassbezeichnung;
    public $anlassdatumbis;
    public $anlassdatumvon;
    public $anlasskategorie;
    public $anlassleitungidperson;
    public $anlassnummer;
    public $arrayeventoanlassleitung;
    public $idanlass;
    public $idanlasskategorie;
    public $idanlassniveau;
    public $idanlassstatus;
    public $idanlasstyp;

    public function __construct($anlassbezeichnung, $anlassdatumbis, $anlassdatumvon, $anlasskategorie, $anlassleitungidperson, $anlassnummer, $arrayeventoanlassleitung, $idanlass, $idanlasskategorie, $idanlassniveau, $idanlassstatus, $idanlasstyp) {

        $this->anlassbezeichnung = $anlassbezeichnung;
        $this->anlassdatumbis = $anlassdatumbis;
        $this->anlassdatumvon = $anlassdatumvon;
        $this->anlasskategorie = $anlasskategorie;
        $this->anlassleitungidperson = $anlassleitungidperson;
        $this->anlassnummer = $anlassnummer;
        $this->arrayeventoanlassleitung = $arrayeventoanlassleitung;
        $this->idanlass = $idanlass;
        $this->idanlasskategorie = $idanlasskategorie;
        $this->idanlassniveau = $idanlassniveau;
        $this->idanlassstatus = $idanlassstatus;
        $this->idanlasstyp = $idanlasstyp;
    }
}
