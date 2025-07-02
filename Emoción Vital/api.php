<?php
require __DIR__ . '/vendor/autoload.php';
require './Services/helper.php';


$action = $_POST['action'];

// SECRET KEY 4/0AVMBsJh6q9aog11cMO8xme6jCLEu1xo-vChxkhwN7eaFkmX6O0RwW7CeNhmbhPreymwLiw

$client = getClient();
$calendarService = new Google_Service_Calendar($client);

$calendarId = 'primary';
$optParams = array(
    'maxResults' => 10,
    'orderBy' => 'startTime',
    'singleEvents' => true,
    'timeMin' => date('c'),
);
$results = $calendarService->events->listEvents($calendarId, $optParams);
$events = $results->getItems();

switch ($action) {
    case 'addEvent':
        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'Prueba de creacion de evento en Google Calendar',
            'location' => 'En la casa de Bart',
            'description' => 'Esta es una reunion para divertirnos',
            'start' => array(
                'dateTime' => '2021-02-08T09:00:00-07:00',
                'timeZone' => 'America/Bogota',
            ),
            'end' => array(
                'dateTime' => '2021-02-08T17:00:00-07:00',
                'timeZone' => 'America/Bogota',
            ),
            "conferenceData" => [
                "createRequest" => [
                    "conferenceId" => [
                        "type" => "eventNamedHangout"
                    ],
                    "requestId" => "123"
                ]
            ],
            'recurrence' => array(
                'RRULE:FREQ=DAILY;COUNT=2'
            ),
            'attendees' => array(
                array('email' => 'lpage@example.com'),
                array('email' => 'sbrin@example.com'),
            ),
            'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 10),
                ),
            ),
        ));

        $calendarId = 'primary';
        $event = $calendarService->events->insert($calendarId, $event, ['conferenceDataVersion' => 1]);
        printf('Event created: %s\n', $event->getHangoutLink());
        break;
    case 'listEvents':
        print "Upcoming events:\n";
        foreach ($events as $event) {
            $start = $event->start->dateTime;
            if (empty($start)) {
                $start = $event->start->date;
            }
            printf("%s (%s)\n", $event->getSummary(), $start);
        }
        break;
    default:
        printf('Its not possible to get the events');
        break;
}

if ($events > 0) {
} else {
}
