<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseController extends Controller
{
    // Sidebar: list all databases
    public function databases()
    {
        $databases = DB::select('SHOW DATABASES');
        $dbList = collect($databases)->pluck('Database');
        return view('db.index', compact('dbList'));
    }

    // Show tables of a selected database
    public function tables($database)
    {
        DB::statement("USE $database");
        $tables = DB::select("SHOW TABLES");
        $key = "Tables_in_" . $database;
        $tableList = collect($tables)->pluck($key);

        return view('db.tables', compact('database', 'tableList'));
    }

    // Show rows of a selected table
    public function rows($database, $table)
    {
        DB::statement("USE $database");
        $rows = DB::table($table)->limit(50)->get();
        $columns = Schema::getColumnListing($table);

        return view('db.rows', compact('database', 'table', 'rows', 'columns'));
    }
}
