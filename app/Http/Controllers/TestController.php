<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * Prueba la conexión a la base de datos
     */
    public function testDbConnection()
    {
        try {
            // Intenta obtener una conexión a la base de datos
            DB::connection()->getPdo();
            
            // Si llegamos aquí, la conexión fue exitosa
            $connectionInfo = [
                'database_name' => DB::connection()->getDatabaseName(),
                'connected' => true,
                'version' => DB::select('select version() as version')[0]->version,
                'tables' => []
            ];
            
            // Obtener información sobre las tablas
            $tables = DB::select('SHOW TABLES');
            $dbName = DB::connection()->getDatabaseName();
            $tableProperty = 'Tables_in_' . $dbName;
            
            foreach ($tables as $table) {
                if (isset($table->$tableProperty)) {
                    $currentTableName = $table->$tableProperty;
                    $recordCount = DB::table($currentTableName)->count();
                    
                    $connectionInfo['tables'][] = [
                        'name' => $currentTableName,
                        'record_count' => $recordCount,
                    ];
                }
            }
            
            return view('test.db-connection', compact('connectionInfo'));
            
        } catch (\Exception $e) {
            $error = [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ];
            
            return view('test.db-connection', compact('error'));
        }
    }
}