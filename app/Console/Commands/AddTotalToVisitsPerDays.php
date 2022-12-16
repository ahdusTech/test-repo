<?php

namespace App\Console\Commands;

use App\DailyVisit;
use App\Domain;
use App\VisitsPerDay;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AddTotalToVisitsPerDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-total-to-visits-per-day {day?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add total from daily visits to visits per days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
//        $domainId = DB::table('domains')
//            ->join('visits', 'visits.domain_id', '=', 'domains.id')
//            ->groupBy('visits.domain_id')->pluck('domains.id');
//        $nonAddedDomainsIds = Domain::whereNotIn('id', $domainId)->get();
//        ssh_tunnel_call();
//        $i = 0;
//        foreach ($nonAddedDomainsIds as $nonAddedDomainsId) {
//            $data = DB::connection('adomino_com')
//                ->table('dv_stats_requests')
//                ->where('datum', '2020-11-10')
//                ->where('domainid', $nonAddedDomainsId->adomino_com_id)
//                ->get()->toArray();
//            echo $nonAddedDomainsId->domain . "--" . $i . "\n";
//            if (!empty($data)) {
//                $visits = VisitsPerDay::where('domain_id', $nonAddedDomainsId->id)->first();
//                if (isset($visits->day20201110) && empty($visits->day20201110)) {
//                    $period = \Carbon\CarbonPeriod::create('2020-11-10', '2021-04-18');
//                    $periodArray = array();
//                    foreach ($period as $per) {
//                        array_push($periodArray, $per->format('Y-m-d'));
//                    }
//                    $dailyVisits = DailyVisit::whereIn('day', $periodArray)->where('domain_id', $nonAddedDomainsId->id)->get();
//                    foreach ($dailyVisits as $dailyVisit) {
//                        if (isset($dailyVisit->id) && empty($dailyVisit->day20201110)) {
//                            VisitsPerDay::updateOrCreate(
//                                ['domain_id' => $dailyVisit->domain_id],
//                                ['day' . $dailyVisit->day->format('Ymd') => $dailyVisit->total]
//                            );
//                        }
//                    }
//                }
//            }
//            $i++;
//        }
//        SELECT domains.id FROM domains INNER JOIN `visits` ON `visits`.`domain_id`=domains.id GROUP BY `visits`.`domain_id`
        $day = $this->argument('day') ?: 1;
        for ($i = 1; $i <= $day; $i++) {
            $date = now()->subDays($i);
            $columnName = 'day' . $date->format('Ymd');
            $columnExist = Schema::hasColumn('visits_per_days', $columnName);

            if (!$columnExist) {
                Schema::table('visits_per_days', function (Blueprint $table) use ($columnName) {
                    $table->integer($columnName)->default(0);
                });
            }
        }
        $dailyVisits = DailyVisit::where('day', '>=', $date->format('Y-m-d'))->get();
        foreach ($dailyVisits as $dailyVisit) {
            if ($dailyVisit->total == null && $dailyVisit->visits !== null) {
                $dailyVisit->total = $dailyVisit->visits;
            } else {
                $dailyVisit->total = 0;
            }
            VisitsPerDay::updateOrCreate(
                ['domain_id' => $dailyVisit->domain_id],
                ['day' . $dailyVisit->day->format('Ymd') => $dailyVisit->total]
            );
//            $dailyVisit->delete();
        }

        $existingDomains = VisitsPerDay::pluck('domain_id')->unique()->toArray();
        $nonAddedDomainsIds = Domain::whereNotIn('id', $existingDomains)->pluck('id');
        foreach ($nonAddedDomainsIds as $id) {
            VisitsPerDay::updateOrCreate(
                ['domain_id' => $id]
            );
        }
        DailyVisit::where('day', '<', \Carbon\Carbon::today()->subDays(8)->format('Y-m-d'))->delete();
        Log::info('Data added to visits per days table.', [
            'daily_visits' => $dailyVisits,
        ]);
    }
}
