<?php

namespace App\Http\Controllers;

use App\Exports\PasienExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BackupController extends Controller
{
    public function download_backup_file()
    {
        $time = now()->format('Y-m-d');
        return Excel::download(new PasienExport, 'pasien_backup_' . $time . '.xlsx');
    }
}
