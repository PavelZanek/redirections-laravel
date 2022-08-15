<?php

namespace PavelZanek\RedirectionsLaravel\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use PavelZanek\RedirectionsLaravel\Models\Redirect;

class ImportRedirectsService
{
    public $csv;

    public function __construct($csv)
    {
        $this->csv = $csv;
    }

    public function importItems()
    {
        LazyCollection::make(function () {
            $handle = fopen($this->csv, 'r');
            
            while (($line = fgetcsv($handle, 4096)) !== false) {
                $dataString = implode(", ", $line);
                $row = explode(';', $dataString);
                yield $row;
            }
    
            fclose($handle);
        })
        ->skip(1)
        ->chunk(1000)
        ->each(function (LazyCollection $chunk) {
            $records = $chunk
                        ->reject(function ($row) {
                            return !isset($row[0]) || !isset($row[1]) || !isset($row[2]);
                        })
                        ->map(function ($row) {
                            return [
                                "source_url" => $row[0],
                                "target_url" => $row[1],
                                "status_code" => $row[2]
                            ];
                        })
                        ->reject(function ($value, $key) {
                            return Cache::rememberForever('redirects_cache', function () {
                                return Redirect::select('source_url')->get();
                            })->where('source_url', $value['source_url'])->first();

                        })
                        ->toArray();
            
            DB::table('redirects')->insert($records);
            Cache::forget('redirects_cache');
        });
    }
}