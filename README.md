Laravel Security Guard – Full User & Developer Guide
1. What it is

Laravel Security Guard is a production-ready security scanner for Laravel projects.

It automatically:

Scans your Laravel project for malware (eval(), base64_decode(), shell_exec(), etc.)
Quarantines suspicious files automatically
Sends email alerts to the admin
Maintains a dashboard with logs and history
Can be scheduled to scan automatically via cron
Logs all quarantined files in the database

Think of it as a Laravel antivirus and security monitor built directly into your project.

2. Installation
Step 1: Require the package via Composer

Run in your Laravel project root:

composer require ekramul/laravel-security-guard

This will download the package and register the Service Provider automatically.

Step 2: Publish config and assets

Run the install command:

php artisan security:install

What this does:

Publishes the config file to config/security.php
Creates a storage/quarantine folder for quarantined files
Sets up default paths and email alert configurations
Step 3: Run the database migration
php artisan migrate

This will create a table security_logs which logs all quarantined files:

Column	Description
id	Auto-increment primary key
file_path	Original file path that was flagged
quarantined_path	Path in quarantine folder
detected_at	Timestamp when malware was detected
3. Configuration (Customize)

Config file: config/security.php

return [
    'email' => env('SECURITY_EMAIL', env('MAIL_FROM_ADDRESS')), // Admin email for alerts
    'auto_quarantine' => true,  // If false, just logs without moving files
    'scan_path' => base_path(), // Path to scan
];

Customizations you can do:

Change email to any admin or security team email
Turn off auto quarantine (auto_quarantine = false) if you want manual review
Limit scan to specific directories (scan_path => base_path('app'))
4. Using the Security Guard
4.1 Manual Scan

Run manually anytime:

php artisan security:scan

Output:

If malware detected → moves file to quarantine + sends email alert
If clean → shows “No malware detected”
4.2 Dashboard (Admin Panel)

Accessible in browser at:

/security/dashboard

Requirements:

Must be logged in (auth middleware)
Can add role-check in DashboardController for admin-only access

Dashboard shows:

ID
Original File Path
Quarantined Path
Date/Time of detection

You can paginate, filter, or search logs by extending DashboardController.

4.3 Scheduler (Cron Job / Auto Scan)

By default, the package schedules a daily scan:

// app/Console/Kernel.php
$schedule->command('security:scan')->daily();

You can change the frequency:

->hourly() → scans every hour
->weekly() → scans weekly
You can also run multiple scans per day
4.4 Email Alerts
Every detection triggers an email to config('security.email')
Default uses Laravel Mail system, so you can use SMTP, Gmail, SendGrid, etc.
Email format is simple text: file path + quarantine info

Example customization:

Mail::send('emails.malware_alert', ['file'=>$file], function($msg){
    $msg->to('security@yourdomain.com')->subject('Malware Detected');
});
You can create a custom Blade email template for nicer formatting
4.5 Quarantine System
All suspicious files moved to storage/quarantine/
Original file path logged in DB
If you need to restore a file:
$cleaner = new Ekramul\SecurityGuard\Scanner\Cleaner();
$cleaner->restore(storage_path('quarantine/filename.php'), base_path('app/filename.php'));
Can implement a restore button in dashboard
5. Advanced Customization
5.1 Add new malware patterns

Edit src/Scanner/MalwareScanner.php:

protected $patterns = [
    'eval(',
    'base64_decode(',
    'shell_exec(',
    'exec(',
    'gzinflate(',
    'system(' // Add new suspicious functions
];
5.2 Limit scanning to certain folders
$scanner->scan(base_path('app')); // Only scan app folder
5.3 Logging and Notifications
You can store logs in external DB or send Slack notifications
Just extend ScanCommand.php and add Notification::send()
5.4 Dashboard Enhancements
Add filters: by date, by file type, by status
Add restore button for each quarantined file
Add export logs to CSV / PDF
6. Full Workflow Example (A-Z)
Install package via Composer
Run php artisan security:install → publishes config, creates quarantine folder
Run migrations → security_logs table
Check /security/dashboard → empty at first
Run php artisan security:scan manually or wait for daily cron
Dashboard updates with quarantined files
Email alert sent to admin
If needed, restore file from quarantine using Cleaner class
Customize patterns or scan paths as needed
7. Security Tips
Set storage/quarantine folder not publicly accessible via web
Make /security/dashboard admin-only using roles
Regularly check logs and email alerts
Backup your database regularly
Combine with Laravel backup package for full site backup
✅ Summary

This package turns any Laravel project into a self-scanning, auto-quarantine security system with full dashboard, email alerts, and scheduled scans.

You can customize patterns, scan paths, email templates, and dashboard UI according to your requirements.
