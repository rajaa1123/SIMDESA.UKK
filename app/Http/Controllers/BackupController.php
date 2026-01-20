<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{
    public function download()
    {
        // Only Admin can backup
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $databaseName = config('database.connections.mysql.database');
        $fileName = 'backup_' . $databaseName . '_' . date('Y-m-d_H-i-s') . '.sql';

        return new StreamedResponse(function () {
            $tables = DB::select('SHOW TABLES');
            $tablesKey = 'Tables_in_' . config('database.connections.mysql.database');

            foreach ($tables as $table) {
                $tableName = $table->$tablesKey;
                
                // Drop table if exists
                echo "DROP TABLE IF EXISTS `$tableName`;\n";
                
                // Show create table
                $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0];
                $createTableKey = 'Create Table';
                echo $createTable->$createTableKey . ";\n\n";

                // Get table data
                $rows = DB::table($tableName)->get();
                foreach ($rows as $row) {
                    $row = (array)$row;
                    $keys = array_keys($row);
                    $values = array_values($row);
                    
                    $escapedValues = array_map(function($value) {
                        if (is_null($value)) return 'NULL';
                        return "'" . addslashes($value) . "'";
                    }, $values);

                    echo "INSERT INTO `$tableName` (`" . implode('`, `', $keys) . "`) VALUES (" . implode(', ', $escapedValues) . ");\n";
                }
                echo "\n\n";
            }
        }, 200, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
    }
}
