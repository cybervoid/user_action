{{ $mime_boundary }}
Content-Type: text/html; charset=UTF-8 Content-Transfer-Encoding: 8bit\r\n

Dear IT,

The user Rafael Gil Rafael Gil requested a roaming service, this is the information:
Travel Dates: from July 13, 2015 to July 14, 2015.

If you need to contact Rafael Gil you can use the information below:
Phone: 9144203700


Please go to AT&T web site: https://www.wireless.att.com/business/index.jsp


This is an automated system, no reply is required.

IT Department
illy caffè North America, Inc.
{{ $mime_boundary }}
Content-Type: text/calendar;name="meeting.ics";method=REQUEST
Content-Transfer-Encoding: 8bit
BEGIN:VCALENDAR
PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN
VERSION:2.0
METHOD:REQUEST
BEGIN:VTIMEZONE
TZID:Eastern Time
BEGIN:STANDARD
DTSTART:20091101T020000
RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11
TZOFFSETFROM:-0400
TZOFFSETTO:-0500
TZNAME:EST
END:STANDARD
BEGIN:DAYLIGHT
DTSTART:20090301T020000
RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3
TZOFFSETFROM:-0500
TZOFFSETTO:-0400
TZNAME:EDST
END:DAYLIGHT
END:VTIMEZONE
BEGIN:VEVENT
ORGANIZER;CN="Illy Roaming Service Desk ":MAILTO:Illy Roaming Service Desk
ATTENDEE;CN="Rafael Gil ";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:rafael.gil@illy.com
LAST-MODIFIED:20150705T150207
UID:20150713T10300016550@illy-domain.com
DTSTAMP:20150705T150207
DTSTART;TZID="Eastern Time":20150713T103000
DTEND;TZID="Eastern Time":20150713T104500
TRANSP:OPAQUE
SEQUENCE:1
SUMMARY:Roaming request from Rafael Gil Rafael Gil
LOCATION:Rye Brook Office
CLASS:PUBLIC
PRIORITY:5
BEGIN:VALARM
TRIGGER:-PT15M
ACTION:DISPLAY
DESCRIPTION:Reminder
END:VALARM
END:VEVENT
END:VCALENDAR