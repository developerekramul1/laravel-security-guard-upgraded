<?php
namespace Ekramul\SecurityGuard\Http\Controllers;

use App\Http\Controllers\Controller;
use Ekramul\SecurityGuard\Models\SecurityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $logs = SecurityLog::latest()->paginate(20);
        return view('security::dashboard', compact('logs'));
    }
}
