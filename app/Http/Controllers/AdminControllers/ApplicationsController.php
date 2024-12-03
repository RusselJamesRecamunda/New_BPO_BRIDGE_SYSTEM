<?php

namespace App\Http\Controllers\AdminControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Borders;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use App\Models\Applications;
use Carbon\Carbon;


class ApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all applications with related job postings
        $applications = Applications::with(['fullTimeJobPosting', 'freelanceJobPosting', 'user'])->get();

        // Return view with applications data
        return view('admin.applications', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, $id)
    {
        // Validate the incoming request to ensure the status is valid
        $request->validate([
            'status' => 'required|string|in:Scheduled,In Process,Rejected',
        ]);

        // Find the application by ID
        $application = Applications::findOrFail($id);

        // Update the application status
        $application->application_status = $request->status;
        $application->save();

        // Store a success message in the session
        session()->flash('success', 'Application status updated successfully');

        // Return to the index page with updated status
        return redirect()->route('applications.index');
    }

    /**
     * Export applications to Excel
     */
    public function exportApplications(Request $request)
    {
        try {
            // Validate date range input
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');

            if (!$startDate || !$endDate) {
                return response()->json(['error' => 'Invalid date range'], 400);
            }

            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();

            if ($startDate > $endDate) {
                return response()->json(['error' => 'Start date cannot be after end date'], 400);
            }

            // Fetch applications within the date range
            $applications = Applications::with(['fullTimeJobPosting', 'freelanceJobPosting'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->get();

            if ($applications->isEmpty()) {
                return response()->json(['error' => 'No applications found within the selected date range'], 404);
            }

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Applications'); // Set sheet name
            $sheet->getTabColor()->setRGB('0F5078'); // Set tab color
            
            // Title cell (B1)
            $sheet->setCellValue('B1', 'BPO-Bridge Job Applications');
            $sheet->getStyle('B1')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => '0F5078'], // White font color
                    'size' => 20,
                    'name' => 'Arial',
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'FFFFFF'], // Background color
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Column headers (B2:M2)
            $headers = [
                'APPLICANT NAME', 'APPLYING FOR', 'APPLICATION STATUS', 'JOB TYPE',
                'JOB CATEGORY', 'EMAIL ADDRESS', 'APPLICANT ADDRESS', 'PHONE',
                'DATE APPLIED', 'APPLICANT EMPLOYMENT STATUS', 'RESUME/CV', 'COVER LETTER',
            ];

            $columnWidths = [
                'B' => 45, 'C' => 65, 'D' => 30, 'E' => 20, 'F' => 30,
                'G' => 50, 'H' => 60, 'I' => 25, 'J' => 30, 'K' => 60, 'L' => 40, 'M' => 40,
            ];

            $columnIndex = 2; // Start at column B
            foreach ($headers as $header) {
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex++);
                $sheet->setCellValue("$columnLetter" . "2", $header);
            }

            $sheet->getStyle('B2:M2')->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'], // White font color
                    'size' => 13,
                    'name' => 'Arial',
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0F5078'], // Background color
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Set column widths
            foreach ($columnWidths as $column => $width) {
                $sheet->getColumnDimension($column)->setWidth($width);
            }

            // Populate data starting from row 3
            $row = 3;
            foreach ($applications as $application) {
                // Alternate row background colors
                $backgroundColor = ($row % 2 == 0) ? '96BAD1' : 'C0DDEF'; // Background color

                $sheet->setCellValue("B$row", $application->applicant_name ?? 'N/A');
                $sheet->setCellValue("C$row", $application->fullTimeJobPosting->job_title ?? $application->freelanceJobPosting->job_title ?? 'N/A');
                $sheet->setCellValue("D$row", $application->application_status ?? 'N/A');
                $sheet->setCellValue("E$row", $application->job_type ?? 'N/A');
                $sheet->setCellValue("F$row", $application->job_category ?? 'N/A');   
                $sheet->setCellValue("G$row", $application->applicant_email ?? 'N/A');
                $sheet->setCellValue("H$row", $application->applicant_location ?? 'N/A');
                $sheet->setCellValue("I$row", $application->applicant_phone ?? 'N/A');
                $sheet->setCellValue("J$row", $application->created_at ? $application->created_at->format('F j, Y') : 'N/A');
                $sheet->setCellValue("K$row", $application->applicant_emp_status ?? 'N/A');
                $sheet->setCellValue("L$row", $application->resume_cv ?? 'N/A');
                $sheet->setCellValue("M$row", $application->cover_letter ?? 'N/A');
                
                // Apply background color and consistent border color
                $sheet->getStyle("B$row:M$row")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => $backgroundColor],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '679FC1'], // Consistent border color
                        ],
                    ],
                ]);

                $row++;
            }

            // Style data rows
            $sheet->getStyle('B3:M' . ($row - 1))->applyFromArray([
                'font' => [
                    'size' => 12,
                    'name' => 'Arial',
                ],
            ]);

            // Save the generated file to a temporary location
            $fileName = 'BPO-BRIDGE Job Applications - Exported Data.xlsx';
            $tempFilePath = storage_path("app/temp/$fileName");

            $writer = new Xlsx($spreadsheet);
            $writer->save($tempFilePath);

            return response()->download($tempFilePath, $fileName)->deleteFileAfterSend(true);
        } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            Log::error('Spreadsheet error: ' . $e->getMessage());
            return response()->json(['error' => 'Spreadsheet error', 'message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Export failed: ' . $e->getMessage());
            return response()->json(['error' => 'Export failed', 'message' => $e->getMessage()], 500);
        }
    }

     
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
