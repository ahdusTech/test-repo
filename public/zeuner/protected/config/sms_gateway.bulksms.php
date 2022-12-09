<?php

return array(
	'class' => 'application.components.BulkSMSGate',
	'message_encoder' => 'BulkSMSGateISO8859Encoder',
	'url' => 'https://bulksms.vsms.net/eapi/submission/send_sms/2/2.0',
	'port' => 443,
	'username' => 'adominonet',
	'password' => 'bulk1harry2',
);
