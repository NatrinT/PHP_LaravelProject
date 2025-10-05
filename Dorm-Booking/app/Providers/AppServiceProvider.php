<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AnnouncementModel;
use App\Models\RoomModel;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['home.mainpage', 'auth.login'], function ($view) {
            $AnnouncementList = AnnouncementModel::orderBy('updated_at', 'desc')->get();
            $view->with('AnnouncementList', $AnnouncementList);
        });

        View::composer(['home.homepage', 'auth.login'], function ($view) {
            // รายชื่อสาขาแบบไม่ซ้ำ เรียง A→Z
            $branches = RoomModel::whereNotNull('branch')
                ->where('branch', '!=', '')
                ->distinct()
                ->orderBy('branch')
                ->pluck('branch')            // ได้เป็น Illuminate\Support\Collection
                ->toArray();                 // ถ้าชอบเป็น array ก็ใส่ toArray()

            $view->with('branches', $branches);
        });
        
        View::composer(['home.mainpage', 'auth.login'], function ($view) {
            // รายชื่อสาขา
            $branches = RoomModel::select('branch')
                ->distinct()->orderBy('branch')->pluck('branch')->toArray();

            $types = ['STANDARD', 'DELUXE', 'LUXURY'];

            // --------- (A) นับจำนวนห้องว่าง แยกสาขา+ประเภท ---------
            $rawType = RoomModel::where('status', 'AVAILABLE')
                ->select('branch', 'type', DB::raw('COUNT(*) as total'))
                ->groupBy('branch', 'type')
                ->get();

            $byBranchType = []; // [$branch][$type] = count
            foreach ($rawType as $r) {
                $byBranchType[$r->branch][$r->type] = (int) $r->total;
            }
            // เติม 0 ให้ครบทุกประเภทในทุกสาขา และจัดลำดับคีย์
            foreach ($branches as $b) {
                foreach ($types as $t) {
                    if (!isset($byBranchType[$b][$t])) $byBranchType[$b][$t] = 0;
                }
                $byBranchType[$b] = [
                    'STANDARD' => $byBranchType[$b]['STANDARD'],
                    'DELUXE'   => $byBranchType[$b]['DELUXE'],
                    'LUXURY'   => $byBranchType[$b]['LUXURY'],
                ];
            }

            // --------- (B) ราคาเริ่มต้น/สูงสุด ต่อสาขา (รวมทุกประเภท) ---------
            $rawBranch = RoomModel::where('status', 'AVAILABLE')
                ->select(
                    'branch',
                    DB::raw('MIN(monthly_rent) as min_rent'),
                    DB::raw('MAX(monthly_rent) as max_rent')
                )
                ->groupBy('branch')
                ->get();

            $priceByBranch = []; // [$branch] = ['min'=>..., 'max'=>...]
            foreach ($rawBranch as $r) {
                $priceByBranch[$r->branch] = [
                    'min' => (float) $r->min_rent,
                    'max' => (float) $r->max_rent,
                ];
            }
            // สาขาที่ไม่มีห้องว่าง → ให้เป็น null
            foreach ($branches as $b) {
                if (!isset($priceByBranch[$b])) {
                    $priceByBranch[$b] = ['min' => null, 'max' => null];
                }
            }

            // ส่งตัวแปรเข้า view
            $view->with([
                'branches'      => $branches,
                'byBranchType'  => $byBranchType,
                'priceByBranch' => $priceByBranch,
            ]);
        });
    }
}
