# Evento Course Creation
Plugin for Creation of empty moodle courses in a definied category based on the events in the
Evenot application. 
Creating courses with
    cours name like the Evento Module name
    course shortname like the Evento "Anlassnummer" without "mod."
    course startdate like the begin in Evento
    coure enddate like the end date in Evento
    course idnumber kile the Evento "Anlassnummer"
    Added course Evento enrolment method

Only include Evento module create courses which are editded at least one year ago 
and have at least one active enrolment and which have the start date in the future.

# Config
Requires the local_evento plugin for the webservices access to Evento.

## License
* Copyright (C) HTW Chur

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details:
http://www.gnu.org/copyleft/gpl.html
