<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\Thesis;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use ZipArchive;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userType = Auth::user()->user_type;
        if ($userType == "Admin") {
            $chartData = json_encode([
                ['value' => Student::count(), 'name' => __('lang.students')],
                ['value' => Supervisor::count(), 'name' => __('lang.supervisors')],
                ['value' => School::count(), 'name' => __('lang.schools')],
            ]);
            $feesCounts = $this->getFeesDataForLastSevenDays();

            // Prepare the chart data
            $feeChartData = [
                'xAxis' => ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چارشنبه', 'پنچ شنبه'], // Custom week starting from Saturday
                'yAxis' => $feesCounts
            ];
            return view('home', compact('chartData', 'feeChartData'));
        } else if ($userType == "Supervisor") {
            $chartData = json_encode([
                ['value' => Student::count(), 'name' => __('lang.students')],
                ['value' => Supervisor::count(), 'name' => __('lang.supervisors')],
                ['value' => School::count(), 'name' => __('lang.schools')],
            ]);
            return view('supervisorPages.home', compact('chartData'));
        } else if ($userType == "Student") {
            $topic = Topic::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
            $topics = Topic::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
            $theses = [];
            if ($topic) {
                $theses = Thesis::where('topic_id', $topic->id)->orderBy('id', 'desc')->get();
            }
            return view('studentPages.home', compact('topic', 'topics', 'theses'));
        }
    }

    public function getFeesDataForLastSevenDays()
    {
        // Get the start date (7 days ago excluding Friday) and end date (today)
        $startDate = Carbon::now()->subDays(6)->startOfDay(); // 6 days ago to include today as day 7
        $endDate = Carbon::now()->endOfDay();

        // Fetch counts grouped by day, excluding Friday (day 5 in MySQL's WEEKDAY function)
        $feesData = DB::table('fees')
            ->select(DB::raw('DAYNAME(created_at) as day_of_week'), DB::raw('sum(amount) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereRaw('WEEKDAY(created_at) != 4') // Exclude Friday
            ->groupBy(DB::raw('DAYNAME(created_at)')) // Group by DAYNAME instead of DAYOFWEEK
            ->orderBy(DB::raw('MIN(created_at)')) // Order by MIN(created_at) or a similar aggregate
            ->get();

        // Define the custom week starting from Saturday
        $customWeekDays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
        $feesCounts = array_fill(0, 6, 0); // Initialize counts for each day of the custom week

        foreach ($feesData as $data) {
            $dayIndex = array_search($data->day_of_week, $customWeekDays);
            if ($dayIndex !== false) {
                $feesCounts[$dayIndex] = $data->total;
            }
        }


        return $feesCounts;
    }

    //database backup
    public function takeBackup()
    {
        if (!Auth::user()->can('users.db_backup')) {
            abort(403, 'Unauthorized action.');
        }
        $dbHost = env('DB_HOST');
        $dbPort = env('DB_PORT');
        $dbName = env('DB_DATABASE');
        $dbUser = env('DB_USERNAME');
        $dbPass = env('DB_PASSWORD');

        $backupFileName = 'backup-' . $dbName . '-' . Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
        $backupFilePath = storage_path('app/' . $backupFileName);

        $command = "mysqldump --host={$dbHost} --port={$dbPort} --user={$dbUser} --password='{$dbPass}' {$dbName} > {$backupFilePath}";

        try {
            // Execute the command to backup the database
            exec($command);

            // Provide the backup file for download
            return response()->download($backupFilePath)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create backup: ' . $e->getMessage()], 500);
        }
    }
    //files backup
    public function downloadStorageBackup()
    {
        if (!Auth::user()->can('users.file_backup')) {
            abort(403, 'Unauthorized action.');
        }
        // Define the storage path
        $storagePath = storage_path('app/public');

        // Define the zip file name and path
        $zipFileName = 'storage-backup-' . date('Y-m-d_H-i-s') . '.zip';
        $zipFilePath = storage_path($zipFileName);

        // Initialize ZipArchive
        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            // Add files to the zip
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($storagePath));

            foreach ($files as $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get the relative path of the file
                    $relativePath = substr($file->getRealPath(), strlen($storagePath) + 1);

                    // Add the file to the zip
                    $zip->addFile($file->getRealPath(), $relativePath);
                }
            }

            // Close the zip
            $zip->close();
        } else {
            return response()->json(['error' => 'Could not create a zip file.'], 500);
        }

        // Download the zip file
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
    public function userSetting()
    {
        return view('userSetting');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            "current_password" => "required|string|min:8",
            "password" => "required|string|min:8|confirmed",
        ]);
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        return redirect()->back()->with('msg', 'Password changed successfully.');
    }
}
