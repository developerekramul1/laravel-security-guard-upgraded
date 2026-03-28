# ??? Laravel Security Guard

> A production-ready security scanner for Laravel projects with automated malware detection, quarantine system, and admin dashboard.

[![Laravel](https://img.shields.io/badge/Laravel-9.0+-red?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.0+-blue?style=for-the-badge&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)](LICENSE)

---

## ?? Table of Contents

- [Features](#features)
- [Quick Start](#quick-start)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Dashboard](#dashboard)
- [Advanced Customization](#advanced-customization)
- [Security Tips](#security-tips)

---

## ? Features

? **Automated Malware Scanning** - Detects malicious code patterns (eval(), base64_decode(), shell_exec(), etc.)  
? **Auto Quarantine System** - Automatically isolates suspicious files  
? **Email Alerts** - Real-time notifications to admin when threats are detected  
? **Admin Dashboard** - Monitor all detections and quarantined files  
? **Scheduled Scans** - Configure via Laravel scheduler for automatic checks  
? **Database Logging** - Complete audit trail of all detections  
? **Easy Restoration** - Recover files from quarantine if needed  

---

## ?? Quick Start

\\\ash
# 1. Install the package
composer require ekramul/laravel-security-guard

# 2. Run installation command
php artisan security:install

# 3. Run migrations
php artisan migrate

# 4. Scan your project
php artisan security:scan

# 5. View dashboard
# Open: http://yourapp.local/security/dashboard
\\\

---

## ?? Installation

### Step 1: Composer Installation

\\\ash
composer require ekramul/laravel-security-guard
\\\

The Service Provider will be automatically registered.

### Step 2: Publish Configuration & Assets

\\\ash
php artisan security:install
\\\

**What this does:**
- ?? Publishes \config/security.php\
- ?? Creates \storage/quarantine/\ folder
- ?? Sets up default scanners and email configurations

### Step 3: Run Database Migration

\\\ash
php artisan migrate
\\\

Creates the \security_logs\ table:

| Column | Type | Description |
|--------|------|-------------|
| \id\ | int | Auto-increment primary key |
| \ile_path\ | string | Original file path that was flagged |
| \quarantined_path\ | string | Path in quarantine folder |
| \detected_at\ | timestamp | When malware was detected |

---

## ?? Configuration

Edit \config/security.php\:

\\\php
return [
    'email' => env('SECURITY_EMAIL', env('MAIL_FROM_ADDRESS')),
    'auto_quarantine' => true,
    'scan_path' => base_path(),
];
\\\

### Configuration Options

| Option | Type | Description |
|--------|------|-------------|
| \email\ | string | Admin email for security alerts |
| \uto_quarantine\ | boolean | Auto-move suspicious files (true/false) |
| \scan_path\ | string | Directory to scan (default: entire project) |

### Examples

\\\php
// Scan only the 'app' directory
'scan_path' => base_path('app'),

// Manual review mode (don't auto-quarantine)
'auto_quarantine' => false,

// Custom admin email
'email' => 'security@yourdomain.com',
\\\

---

## ?? Usage

### 1?? Manual Scan

\\\ash
php artisan security:scan
\\\

**Output:**
- ? If clean  No malware detected
- ?? If threats found  Files are quarantined + email alert sent

### 2?? Automated Scheduled Scans

Edit \pp/Console/Kernel.php\:

\\\php
\->command('security:scan')->daily();
\\\

**Frequency Options:**
- \->hourly()\ - Every hour
- \->daily()\ - Every 24 hours (default)
- \->weekly()\ - Every week
- \->twiceDaily()\ - Twice per day

### 3?? Dashboard (Admin Panel)

**Access:** \http://yourapp.local/security/dashboard\

**Requirements:**
- Must be authenticated (Laravel auth middleware)
- Optional: Add role-check for admin-only access

**Dashboard Features:**
- ?? View all security logs
- ?? File path and detection date
- ?? Quarantined file locations
- ?? Paginate and filter results

### 4?? Email Alerts

Every detection triggers an email alert to your configured admin email.

**Customize Alert Template:**

\\\php
// In your mail class or notification
Mail::send('emails.malware_alert', ['file' => \], function(\) {
    \->to('security@yourdomain.com')
        ->subject('?? Malware Detected on ' . config('app.name'));
});
\\\

### 5?? Quarantine & Restoration

**Restore a Quarantined File:**

\\\php
use Ekramul\SecurityGuard\Scanner\Cleaner;

\ = new Cleaner();
\->restore(
    storage_path('quarantine/suspicious-file.php'),
    base_path('app/suspicious-file.php')
);
\\\

---

## ?? Dashboard

The dashboard provides a centralized view of all security events:

\\\
Security Dashboard
├── ?? Statistics (Total Threats, Status)
├── ?? Search & Filter
├── ?? Quarantine Logs
└── ? Quick Actions (Restore, Delete)
\\\

**Extend Dashboard Functionality:**

\\\php
// In DashboardController.php
// Add filters by date, file type, status
// Implement restore buttons
// Export logs to CSV/PDF
\\\

---

## ?? Advanced Customization

### Add Custom Malware Patterns

Edit \src/Scanner/MalwareScanner.php\:

\\\php
protected \ = [
    'eval(',
    'base64_decode(',
    'shell_exec(',
    'exec(',
    'gzinflate(',
    'system(',
    'passthru(',          // Add custom patterns
    'proc_open(',
];
\\\

### Limit Scan to Specific Folders

\\\php
\->scan(base_path('app'));        // Scan only app folder
\->scan(base_path('app/Http'));   // Even more specific
\\\

### Add Slack Notifications

Extend \ScanCommand.php\:

\\\php
use Illuminate\Notifications\Notification;

Notification::route('slack', env('SLACK_WEBHOOK_URL'))
    ->notify(new MalwareDetected(\));
\\\

### Dashboard Enhancements

- ?? Add date range filters
- ??? Filter by file type (.php, .js, etc.)
- ?? Add statistics/charts
- ?? Export to CSV/PDF
- ?? Restore button for each file

---

## ??? Security Tips

? **Quarantine Folder Protection**
\\\ash
# Make sure storage/quarantine is NOT publicly accessible
# Configure your web server accordingly
\\\

? **Dashboard Access Control**
\\\php
// Add role-based access in DashboardController
if (!auth()->user()->isAdmin()) {
    abort(403);
}
\\\

? **Best Practices**
- ?? Regularly monitor email alerts
- ?? Review dashboard logs weekly
- ?? Backup database regularly
- ?? Keep Laravel core updated
- ?? Use alongside Laravel backup package

---

## ?? Complete Workflow

1. Install package via Composer
2. Run \php artisan security:install\
3. Run migrations: \php artisan migrate\
4. Check dashboard at \/security/dashboard\
5. Manually scan: \php artisan security:scan\
6. Monitor logs and email alerts
7. Restore files if needed from quarantine
8. Schedule automatic scans via cron

---

## ?? License

MIT License - Feel free to use in your projects!

---

**Made with ?? for Laravel developers**
