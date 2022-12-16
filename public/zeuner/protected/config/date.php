<?php

$now = time(
);

$tz = new DateTimeZone(
	'Europe/Berlin'
);

$transitions = $tz->getTransitions(
	$now,
	$now
);

$offset = $transitions[
	0
][
	'offset'
];

return array(
	'class' => 'application.components.Date',
	'offset' => $offset,
);
