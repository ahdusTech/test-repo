<?php

namespace App\Console\Commands;

use App\Domain;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-domains';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import domains from old database.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Command Import Domains started.');

        ssh_tunnel_call();

//        $res = DB::connection('adomino_com')
//            ->table('dv_domains')
//            ->where('id', 969)->get();
//        print_r($res);
//
//        die;

        $existingDomainIds = Domain::whereNotNull('adomino_com_id')
            ->pluck('adomino_com_id')
            ->toArray();

        DB::connection('adomino_com')
            ->table('dv_domains')
            ->whereNotIn('id', $existingDomainIds)
            ->orderBy('id')
            ->chunk(500, function ($domains) {
                $newDomains = collect($domains)->map(function ($domain) {
                    return [
                        'adomino_com_id' => $domain->id,
                        'domain' => $domain->domain,
                        // Utf8 encode is used because some characters have another
                        // encoding and it throws a mysql error
                        'title' => !empty($domain->parking_title) ? utf8_encode($domain->parking_title) : null,
                        'info' => json_encode(['de' => utf8_encode($domain->info)]),
                        'brandable' => $domain->brandable || $domain->heikel,
                    ];
                })->toArray();

                Domain::insert($newDomains);
            });

        Log::info('Command Import Domains finished.');
        $this->info('Command Import Domains finished.');
    }
}
