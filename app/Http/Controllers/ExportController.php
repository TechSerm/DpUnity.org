<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Schema;

class ExportController extends Controller
{
    public function exportCsv()
    {
        $exportKey = config('bibisena.export_key');
        if(request()->key != $exportKey) {
            return response("Key not match", 403);
        }

        $tableName = request()->table_name; // Replace with your table name
        if(!Schema::hasTable($tableName)) {
            return response("No table found", 404);
        }

        $fileName = $tableName . '.csv';
        $csvFilePath = storage_path('app/' . $fileName);
        $data = DB::table($tableName)->get();

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Write CSV header
            fputcsv($file, array_keys((array)$data[0]));

            // Write CSV data
            foreach ($data as $row) {
                fputcsv($file, (array)$row);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers); // This will delete the file after it's downloaded
    }
}