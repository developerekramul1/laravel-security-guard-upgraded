<?php
return [
    'email' => env('SECURITY_EMAIL', env('MAIL_FROM_ADDRESS')),
    'auto_quarantine' => true,
    'scan_path' => base_path(),
];
