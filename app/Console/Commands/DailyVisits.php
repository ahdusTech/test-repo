<?php

namespace App\Console\Commands;

use App\{
    DailyVisit, Visit, Domain
};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyVisits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily-visits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count daily visits before today from visits table.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
//        $notVisitsDomainIds = DB::table('domains')
//            ->join('visits', 'visits.domain_id', '=', 'domains.id')
//            ->groupBy('visits.domain_id')->pluck('domains.id');
//
//        $nonAddedDomainsIds = Domain::whereNotIn('id', $notVisitsDomainIds)->get();
//
//        ssh_tunnel_call();
//
//        $adomino_com_connection = DB::connection('adomino_com');
//        $final_data = $adomino_com_connection
//            ->table('dv_stats_requests')
////                ->where('datum', $yesterdayDate)
//            ->where('datum', 'like','%2021-01-%')
//            ->where('domainid', 2406)
//            ->get();
//        print_r($final_data);
//        die;
//        $yesterdayDate = date('Y-m-d', strtotime('-1 day'));

//        foreach ($nonAddedDomainsIds as $nonAddedDomainsId) {
//            $check_adomino_com_detail_exists = $adomino_com_connection
//                ->table('dv_stats_requests')
////                ->where('datum', $yesterdayDate)
//                ->where('datum', '2020-11-10')
//                ->where('domainid', $nonAddedDomainsId->adomino_com_id)
//                ->first();
//            echo $nonAddedDomainsId->domain . "\n";
//            if (!empty($check_adomino_com_detail_exists)) {
////                DailyVisit::where('domain_id', $nonAddedDomainsId->id)->delete();
//                $period = \Carbon\CarbonPeriod::create('2020-11-10', '2021-04-18');
//                foreach ($period as $date) {
//                    $final_data = $adomino_com_connection
//                        ->table('dv_stats_requests')
////                ->where('datum', $yesterdayDate)
//                        ->where('datum', $date->format('Y-m-d'))
//                        ->where('domainid', $nonAddedDomainsId->adomino_com_id)
//                        ->get();
//                    if (isset($final_data[0]->datum) && !empty($final_data[0]->datum)) {
//                        $totalCount = 0;
//                        foreach ($final_data as $final_dat) {
//                            $totalCount += $final_dat->num;
//                        }
//                        DailyVisit::insert([
//                            'domain_id' => $nonAddedDomainsId->id,
//                            'day' => $date->format('Y-m-d'),
//                            'visits' => 0,
//                            'created_at' => now(),
//                            'updated_at' => now(),
//                            'adomino_com_ok' => true,
//                            'total' => $totalCount,
//                        ]);
//                    }
//                }
////                die('done');
//            }
//        }
//        die;
        $visits = Visit::where('created_at', 'like', date('Y-m-d', strtotime('-1 day')) . "%");
        $dailyVisits = $visits->get()->groupBy(function ($item) {
            return $item['created_at']->format('Y-m-d');
        })->map(function ($visits, $date) {
            return $visits
                ->groupBy('domain_id')
                ->map(function ($visits, $domainId) use ($date) {
                    return [
                        'domain_id' => $domainId,
                        'day' => $date,
                        'visits' => $visits->unique('ip')->count(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                });
        })
            ->flatten(1)
            ->toArray();

        DailyVisit::insert($dailyVisits);

//        import adomino.com domain visits start

        $notVisitsDomainIds = DB::table('domains')
            ->join('visits', 'visits.domain_id', '=', 'domains.id')
            ->groupBy('visits.domain_id')->pluck('domains.id');

        $nonAddedDomainsIds = Domain::whereNotIn('id', $notVisitsDomainIds)->get();

        ssh_tunnel_call();

        $adomino_com_connection = DB::connection('adomino_com');

        $yesterdayDate = date('Y-m-d', strtotime('-1 day'));

        foreach ($nonAddedDomainsIds as $nonAddedDomainsId) {
            $check_adomino_com_detail_exists = $adomino_com_connection
                ->table('dv_stats_requests')
                ->where('datum', $yesterdayDate)
                ->where('domainid', $nonAddedDomainsId->adomino_com_id)
                ->get();
            if (isset($check_adomino_com_detail_exists[0]->datum) && !empty($check_adomino_com_detail_exists[0]->datum)) {
                $totalCount = 0;
                foreach ($check_adomino_com_detail_exists as $adomino_com_detail_exist) {
                    $totalCount += $adomino_com_detail_exist->num;
                }
                DailyVisit::insert([
                    'domain_id' => $nonAddedDomainsId->id,
                    'day' => $yesterdayDate,
                    'visits' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'adomino_com_ok' => true,
                    'total' => $totalCount,
                ]);
            }
        }
        Visit::where('created_at', '<', \Carbon\Carbon::today()->subDays(8)->format('Y-m-d'))->delete();
//        import adomino domain visits start
        Log::info('Daily visits inserted successfully.', [
            'daily_visits' => $dailyVisits
        ]);
//
////        $visits->delete();
        Log::info('Visits deleted successfully.');
    }
}
