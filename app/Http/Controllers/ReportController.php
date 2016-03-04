<?php

namespace App\Http\Controllers;

use DB;
use App\Settings;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function displayReport(Request $request) {
    	    $settings = Settings::all();
    	    if(count($settings)>0){
    		//do nothing
    	    }
    	    else{
    	      $setobj1 = new Settings;
              $setobj1->parameter = 'textual_btree';
              $setobj1->value = 'Y';
              $setobj1->save();
              $setobj2 = new Settings;
              $setobj2->parameter = 'textual_wavelet';
              $setobj2->value = 'Y';
              $setobj2->save();
              $setobj3 = new Settings;
              $setobj3->parameter = 'dual_rtree_btree';
              $setobj3->value = 'Y';
              $setobj3->save();
              $setobj4 = new Settings;
              $setobj4->parameter = 'dual_rtree_wavelet';
              $setobj4->value = 'Y';
              $setobj4->save();
              $setobj5 = new Settings;
              $setobj5->parameter = 'dual_rstartree_btree';
              $setobj5->value = 'Y';
              $setobj5->save();
              $setobj6 = new Settings;
              $setobj6->parameter = 'dual_rstartree_wavelet';
              $setobj6->value = 'Y';
              $setobj6->save();
              $setobj7 = new Settings;
              $setobj7->parameter = 'dual_wavelet_btree';
              $setobj7->value = 'Y';
              $setobj7->save();
              $setobj8 = new Settings;
              $setobj8->parameter = 'dual_wavelet_wavelet';
              $setobj8->value = 'Y';
              $setobj8->save();
              $setobj9 = new Settings;
              $setobj9->parameter = 'hybrid_keyword_spatial_rtree_btree';
              $setobj9->value = 'Y';
              $setobj9->save();
              $setobj10 = new Settings;
              $setobj10->parameter = 'hybrid_spatial_keyword_rtree_btree';
              $setobj10->value = 'Y';
              $setobj10->save();
              $setobj11 = new Settings;
              $setobj11->parameter = 'hybrid_keyword_spatial_rtree_wavelet';
              $setobj11->value = 'Y';
              $setobj11->save();
              $setobj12 = new Settings;
              $setobj12->parameter = 'hybrid_spatial_keyword_rtree_wavelet';
              $setobj12->value = 'Y';
              $setobj12->save();
              $setobj13 = new Settings;
              $setobj13->parameter = 'hybrid_keyword_spatial_rstartree_btree';
              $setobj13->value = 'Y';
              $setobj13->save();
              $setobj14 = new Settings;
              $setobj14->parameter = 'hybrid_spatial_keyword_rstartree_btree';
              $setobj14->value = 'Y';
              $setobj14->save();
              $setobj15 = new Settings;
              $setobj15->parameter = 'hybrid_keyword_spatial_rstartree_wavelet';
              $setobj15->value = 'Y';
              $setobj15->save();
              $setobj16 = new Settings;
              $setobj16->parameter = 'hybrid_spatial_keyword_rstartree_wavelet';
              $setobj16->value = 'Y';
              $setobj16->save();
              $setobj17 = new Settings;
              $setobj17->parameter = 'hybrid_keyword_spatial_wavelet_btree';
              $setobj17->value = 'Y';
              $setobj17->save();
              $setobj18 = new Settings;
              $setobj18->parameter = 'hybrid_spatial_keyword_wavelet_btree';
              $setobj18->value = 'Y';
              $setobj18->save();
              $setobj19 = new Settings;
              $setobj19->parameter = 'hybrid_keyword_spatial_wavelet_wavelet';
              $setobj19->value = 'Y';
              $setobj19->save();
              $setobj20 = new Settings;
              $setobj20->parameter = 'hybrid_spatial_keyword_wavelet_wavelet';
              $setobj20->value = 'Y';
              $setobj20->save();
    	      $settings = Settings::all();
    	    }

          //Textual
          $textual_btree_space = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what', ['what' => 'text_b_tree'])[0];
          foreach ($textual_btree_space as $key => $value) {
            $textual_btree_space =  round(((float)($value)),6);          
          }
          $textual_btree_time = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what', ['what' => 'text_b_tree'])[0];
          foreach ($textual_btree_time as $key => $value) {
            $textual_btree_time =  round((float)($value),6);          
          }

          $textual_wavelet_space = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what', ['what' => 'text_wavelet'])[0];
          foreach ($textual_wavelet_space as $key => $value) {
            $textual_wavelet_space =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what', ['what' => 'text_wavelet'])[0];
          foreach ($textual_wavelet_time as $key => $value) {
            $textual_wavelet_time =  round((float)($value/100),6);          
          }

          //Dual
          $dual_btree_rtree_space = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree'])[0];
          foreach ($dual_btree_rtree_space as $key => $value) {
            $dual_btree_rtree_space =  round(((float)($value)),6);          
          }
          $dual_btree_rtree_time = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree'])[0];
          foreach ($dual_btree_rtree_time as $key => $value) {
            $dual_btree_rtree_time =  round((float)($value),6);          
          }

          $dual_wavelet_rtree_space = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree'])[0];
          foreach ($dual_wavelet_rtree_space as $key => $value) {
            $dual_wavelet_rtree_space =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rtree_time = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree'])[0];
          foreach ($dual_wavelet_rtree_time as $key => $value) {
            $dual_wavelet_rtree_time =  round((float)($value/100),6);          
          }

          $dual_btree_rstartree_space = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree'])[0];
          foreach ($dual_btree_rstartree_space as $key => $value) {
            $dual_btree_rstartree_space =  round(((float)($value)),6);          
          }
          $dual_btree_rstartree_time = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree'])[0];
          foreach ($dual_btree_rstartree_time as $key => $value) {
            $dual_btree_rstartree_time =  round((float)($value),6);          
          }

          $dual_wavelet_rstartree_space = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree'])[0];
          foreach ($dual_wavelet_rstartree_space as $key => $value) {
            $dual_wavelet_rstartree_space =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rstartree_time = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree'])[0];
          foreach ($dual_wavelet_rstartree_time as $key => $value) {
            $dual_wavelet_rstartree_time =  round((float)($value/100),6);          
          }

          $dual_btree_wavelet_space = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet'])[0];
          foreach ($dual_btree_wavelet_space as $key => $value) {
            $dual_btree_wavelet_space =  round(((float)($value/1.5)),6);          
          }
          $dual_btree_wavelet_time = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet'])[0];
          foreach ($dual_btree_wavelet_time as $key => $value) {
            $dual_btree_wavelet_time =  round((float)($value/100),6);          
          }
          
          $dual_wavelet_wavelet_space = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet'])[0];
          foreach ($dual_wavelet_wavelet_space as $key => $value) {
            $dual_wavelet_wavelet_space =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_wavelet_time = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet'])[0];
          foreach ($dual_wavelet_wavelet_time as $key => $value) {
            $dual_wavelet_wavelet_time =  round((float)($value/150),6);          
          }

          $result = array($textual_btree_space,$textual_btree_time,$textual_wavelet_space,$textual_wavelet_time,$dual_btree_rtree_space,$dual_btree_rtree_time,$dual_wavelet_rtree_space,$dual_wavelet_rtree_time,$dual_btree_rstartree_space,$dual_btree_rstartree_time,$dual_wavelet_rstartree_space,$dual_wavelet_rstartree_time,$dual_btree_wavelet_space,$dual_btree_wavelet_time,$dual_wavelet_wavelet_space,$dual_wavelet_wavelet_time);
        return view("report")->with('settings',$settings)->with('result',$result);
    }
}
