<?php
$map = ['create', 'read', 'update', 'delete'];
$mapInvoices = ['read', 'view', 'update'];
$mapActivate = ['create', 'read', 'update', 'delete', 'activate', 'view'];
$mapConsulting = ['create', 'read', 'update', 'delete', 'view', 'clients statistics'];
$mapSettings = ['read', 'general', 'memberships', 'invoices', 'consulting', 'arbitrationRegulations', 'orders', 'politics', 'sms', 'socialMedia'];
return [
    'models' => ['notifications' => $map, 'alerts' => $map, 'sliders' => $map, 'settings' => $mapSettings, 'supervisors' => $map, 'users' => $mapActivate, 'orders' => $map, 'financial' => $map, 'cities' => $map, 'countries' => $map, 'occupations' => $map, 'specialties' => $map, 'qualifications' => $map, 'questions' => $map, 'pages' => $map, 'tickets' => $map, 'contact' => $map, 'email_templates' => $map, "ips" => $map, 'consulting' => $mapConsulting, 'departments' => $map, 'licenses' => $map, 'SMS' => $map, 'documentation_contracts' => $map, 'invoices' => $mapInvoices, 'specialServices' => $map, 'banks' => $map, 'platforms' => $map],
];
