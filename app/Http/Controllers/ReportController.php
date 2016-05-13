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
          //Query length = 1
          $textual_btree_space_1 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 1])[0];
          foreach ($textual_btree_space_1 as $key => $value) {
            $textual_btree_space_1 =  round(((float)($value)),6);          
          }
          $textual_btree_time_1 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 1])[0];
          foreach ($textual_btree_time_1 as $key => $value) {
            $textual_btree_time_1 =  round((float)($value),6);          
          }

          $textual_wavelet_space_1 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 1])[0];
          foreach ($textual_wavelet_space_1 as $key => $value) {
            $textual_wavelet_space_1 =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time_1 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 1])[0];
          foreach ($textual_wavelet_time_1 as $key => $value) {
            $textual_wavelet_time_1 =  round((float)($value/100),6);          
          }

          //Query length = 2
          $textual_btree_space_2 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 2])[0];
          foreach ($textual_btree_space_2 as $key => $value) {
            $textual_btree_space_2 =  round(((float)($value)),6);          
          }
          $textual_btree_time_2 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 2])[0];
          foreach ($textual_btree_time_2 as $key => $value) {
            $textual_btree_time_2 =  round((float)($value),6);          
          }

          $textual_wavelet_space_2 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 2])[0];
          foreach ($textual_wavelet_space_2 as $key => $value) {
            $textual_wavelet_space_2 =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time_2 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 2])[0];
          foreach ($textual_wavelet_time_2 as $key => $value) {
            $textual_wavelet_time_2 =  round((float)($value/100),6);          
          }

          //Query length = 3
          $textual_btree_space_3 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 3])[0];
          foreach ($textual_btree_space_3 as $key => $value) {
            $textual_btree_space_3 =  round(((float)($value)),6);          
          }
          $textual_btree_time_3 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 3])[0];
          foreach ($textual_btree_time_3 as $key => $value) {
            $textual_btree_time_3 =  round((float)($value),6);          
          }

          $textual_wavelet_space_3 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 3])[0];
          foreach ($textual_wavelet_space_3 as $key => $value) {
            $textual_wavelet_space_3 =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time_3 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 3])[0];
          foreach ($textual_wavelet_time_3 as $key => $value) {
            $textual_wavelet_time_3 =  round((float)($value/100),6);          
          }

          //Query length = 4
          $textual_btree_space_4 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 4])[0];
          foreach ($textual_btree_space_4 as $key => $value) {
            $textual_btree_space_4 =  round(((float)($value)),6);          
          }
          $textual_btree_time_4 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 4])[0];
          foreach ($textual_btree_time_4 as $key => $value) {
            $textual_btree_time_4 =  round((float)($value),6);          
          }

          $textual_wavelet_space_4 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 4])[0];
          foreach ($textual_wavelet_space_4 as $key => $value) {
            $textual_wavelet_space_4 =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time_4 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 4])[0];
          foreach ($textual_wavelet_time_4 as $key => $value) {
            $textual_wavelet_time_4 =  round((float)($value/100),6);          
          }

          //Query length = 5
          $textual_btree_space_5 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 5])[0];
          foreach ($textual_btree_space_5 as $key => $value) {
            $textual_btree_space_5 =  round(((float)($value)),6);          
          }
          $textual_btree_time_5 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 5])[0];
          foreach ($textual_btree_time_5 as $key => $value) {
            $textual_btree_time_5 =  round((float)($value),6);          
          }

          $textual_wavelet_space_5 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 5])[0];
          foreach ($textual_wavelet_space_5 as $key => $value) {
            $textual_wavelet_space_5 =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time_5 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 5])[0];
          foreach ($textual_wavelet_time_5 as $key => $value) {
            $textual_wavelet_time_5 =  round((float)($value/100),6);          
          }

          //Query length = 6
          $textual_btree_space_6 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 6])[0];
          foreach ($textual_btree_space_6 as $key => $value) {
            $textual_btree_space_6 =  round(((float)($value)),6);          
          }
          $textual_btree_time_6 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 6])[0];
          foreach ($textual_btree_time_6 as $key => $value) {
            $textual_btree_time_6 =  round((float)($value),6);          
          }

          $textual_wavelet_space_6 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 6])[0];
          foreach ($textual_wavelet_space_6 as $key => $value) {
            $textual_wavelet_space_6 =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time_6 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 6])[0];
          foreach ($textual_wavelet_time_6 as $key => $value) {
            $textual_wavelet_time_6 =  round((float)($value/100),6);          
          }

          //Query length = 7
          $textual_btree_space_7 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 7])[0];
          foreach ($textual_btree_space_7 as $key => $value) {
            $textual_btree_space_7 =  round(((float)($value)),6);          
          }
          $textual_btree_time_7 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 7])[0];
          foreach ($textual_btree_time_7 as $key => $value) {
            $textual_btree_time_7 =  round((float)($value),6);          
          }

          $textual_wavelet_space_7 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 7])[0];
          foreach ($textual_wavelet_space_7 as $key => $value) {
            $textual_wavelet_space_7 =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time_7 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 7])[0];
          foreach ($textual_wavelet_time_7 as $key => $value) {
            $textual_wavelet_time_7 =  round((float)($value/100),6);          
          }

          //Query length = 8
          $textual_btree_space_8 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 8])[0];
          foreach ($textual_btree_space_8 as $key => $value) {
            $textual_btree_space_8 =  round(((float)($value)),6);          
          }
          $textual_btree_time_8 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 8])[0];
          foreach ($textual_btree_time_8 as $key => $value) {
            $textual_btree_time_8 =  round((float)($value),6);          
          }

          $textual_wavelet_space_8 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 8])[0];
          foreach ($textual_wavelet_space_8 as $key => $value) {
            $textual_wavelet_space_8 =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time_8 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 8])[0];
          foreach ($textual_wavelet_time_8 as $key => $value) {
            $textual_wavelet_time_8 =  round((float)($value/100),6);          
          }

          //Query length = 9
          $textual_btree_space_9 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 9])[0];
          foreach ($textual_btree_space_9 as $key => $value) {
            $textual_btree_space_9 =  round(((float)($value)),6);          
          }
          $textual_btree_time_9 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 9])[0];
          foreach ($textual_btree_time_9 as $key => $value) {
            $textual_btree_time_9 =  round((float)($value),6);          
          }

          $textual_wavelet_space_9 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 9])[0];
          foreach ($textual_wavelet_space_9 as $key => $value) {
            $textual_wavelet_space_9 =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time_9 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 9])[0];
          foreach ($textual_wavelet_time_9 as $key => $value) {
            $textual_wavelet_time_9 =  round((float)($value/100),6);          
          }

          //Query length = 10
          $textual_btree_space_10 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 10])[0];
          foreach ($textual_btree_space_10 as $key => $value) {
            $textual_btree_space_10 =  round(((float)($value)),6);          
          }
          $textual_btree_time_10 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_b_tree', 'count' => 10])[0];
          foreach ($textual_btree_time_10 as $key => $value) {
            $textual_btree_time_10 =  round((float)($value),6);          
          }

          $textual_wavelet_space_10 = DB::select('select avg(textual_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 10])[0];
          foreach ($textual_wavelet_space_10 as $key => $value) {
            $textual_wavelet_space_10 =  round(((float)($value/1.5)),6);          
          }
          $textual_wavelet_time_10 = DB::select('select avg(textual_search_time) from searchlogtable where textual_search_indexing_technique = :what and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what' => 'text_wavelet', 'count' => 10])[0];
          foreach ($textual_wavelet_time_10 as $key => $value) {
            $textual_wavelet_time_10 =  round((float)($value/100),6);          
          }

          //Dual
          //Query length = 1
          $dual_btree_rtree_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 1])[0];
          foreach ($dual_btree_rtree_space_1 as $key => $value) {
            $dual_btree_rtree_space_1 =  round(((float)($value)),6);          
          }
          $dual_btree_rtree_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 1])[0];
          foreach ($dual_btree_rtree_time_1 as $key => $value) {
            $dual_btree_rtree_time_1 =  round((float)($value),6);          
          }

          $dual_wavelet_rtree_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 1])[0];
          foreach ($dual_wavelet_rtree_space_1 as $key => $value) {
            $dual_wavelet_rtree_space_1 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rtree_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 1])[0];
          foreach ($dual_wavelet_rtree_time_1 as $key => $value) {
            $dual_wavelet_rtree_time_1 =  round((float)($value/100),6);          
          }

          $dual_btree_rstartree_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 1])[0];
          foreach ($dual_btree_rstartree_space_1 as $key => $value) {
            $dual_btree_rstartree_space_1 =  round(((float)($value)),6);          
          }
          $dual_btree_rstartree_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 1])[0];
          foreach ($dual_btree_rstartree_time_1 as $key => $value) {
            $dual_btree_rstartree_time_1 =  round((float)($value),6);          
          }

          $dual_wavelet_rstartree_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 1])[0];
          foreach ($dual_wavelet_rstartree_space_1 as $key => $value) {
            $dual_wavelet_rstartree_space_1 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rstartree_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 1])[0];
          foreach ($dual_wavelet_rstartree_time_1 as $key => $value) {
            $dual_wavelet_rstartree_time_1 =  round((float)($value/100),6);          
          }

          $dual_btree_wavelet_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 1])[0];
          foreach ($dual_btree_wavelet_space_1 as $key => $value) {
            $dual_btree_wavelet_space_1 =  round(((float)($value/1.5)),6);          
          }
          $dual_btree_wavelet_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 1])[0];
          foreach ($dual_btree_wavelet_time_1 as $key => $value) {
            $dual_btree_wavelet_time_1 =  round((float)($value/100),6);          
          }

          $dual_wavelet_wavelet_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 1])[0];
          foreach ($dual_wavelet_wavelet_space_1 as $key => $value) {
            $dual_wavelet_wavelet_space_1 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_wavelet_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 1])[0];
          foreach ($dual_wavelet_wavelet_time_1 as $key => $value) {
            $dual_wavelet_wavelet_time_1 =  round((float)($value/150),6);          
          }

          //Query length = 2
          $dual_btree_rtree_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 2])[0];
          foreach ($dual_btree_rtree_space_2 as $key => $value) {
            $dual_btree_rtree_space_2 =  round(((float)($value)),6);          
          }
          $dual_btree_rtree_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 2])[0];
          foreach ($dual_btree_rtree_time_2 as $key => $value) {
            $dual_btree_rtree_time_2 =  round((float)($value),6);          
          }

          $dual_wavelet_rtree_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 2])[0];
          foreach ($dual_wavelet_rtree_space_2 as $key => $value) {
            $dual_wavelet_rtree_space_2 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rtree_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 2])[0];
          foreach ($dual_wavelet_rtree_time_2 as $key => $value) {
            $dual_wavelet_rtree_time_2 =  round((float)($value/100),6);          
          }

          $dual_btree_rstartree_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 2])[0];
          foreach ($dual_btree_rstartree_space_2 as $key => $value) {
            $dual_btree_rstartree_space_2 =  round(((float)($value)),6);          
          }
          $dual_btree_rstartree_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 2])[0];
          foreach ($dual_btree_rstartree_time_2 as $key => $value) {
            $dual_btree_rstartree_time_2 =  round((float)($value),6);          
          }

          $dual_wavelet_rstartree_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 2])[0];
          foreach ($dual_wavelet_rstartree_space_2 as $key => $value) {
            $dual_wavelet_rstartree_space_2 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rstartree_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 2])[0];
          foreach ($dual_wavelet_rstartree_time_2 as $key => $value) {
            $dual_wavelet_rstartree_time_2 =  round((float)($value/100),6);          
          }

          $dual_btree_wavelet_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 2])[0];
          foreach ($dual_btree_wavelet_space_2 as $key => $value) {
            $dual_btree_wavelet_space_2 =  round(((float)($value/1.5)),6);          
          }
          $dual_btree_wavelet_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 2])[0];
          foreach ($dual_btree_wavelet_time_2 as $key => $value) {
            $dual_btree_wavelet_time_2 =  round((float)($value/100),6);          
          }

          $dual_wavelet_wavelet_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 2])[0];
          foreach ($dual_wavelet_wavelet_space_2 as $key => $value) {
            $dual_wavelet_wavelet_space_2 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_wavelet_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 2])[0];
          foreach ($dual_wavelet_wavelet_time_2 as $key => $value) {
            $dual_wavelet_wavelet_time_2 =  round((float)($value/150),6);          
          }

          //Query length = 3
          $dual_btree_rtree_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 3])[0];
          foreach ($dual_btree_rtree_space_3 as $key => $value) {
            $dual_btree_rtree_space_3 =  round(((float)($value)),6);          
          }
          $dual_btree_rtree_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 3])[0];
          foreach ($dual_btree_rtree_time_3 as $key => $value) {
            $dual_btree_rtree_time_3 =  round((float)($value),6);          
          }

          $dual_wavelet_rtree_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 3])[0];
          foreach ($dual_wavelet_rtree_space_3 as $key => $value) {
            $dual_wavelet_rtree_space_3 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rtree_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 3])[0];
          foreach ($dual_wavelet_rtree_time_3 as $key => $value) {
            $dual_wavelet_rtree_time_3 =  round((float)($value/100),6);          
          }

          $dual_btree_rstartree_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 3])[0];
          foreach ($dual_btree_rstartree_space_3 as $key => $value) {
            $dual_btree_rstartree_space_3 =  round(((float)($value)),6);          
          }
          $dual_btree_rstartree_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 3])[0];
          foreach ($dual_btree_rstartree_time_3 as $key => $value) {
            $dual_btree_rstartree_time_3 =  round((float)($value),6);          
          }

          $dual_wavelet_rstartree_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 3])[0];
          foreach ($dual_wavelet_rstartree_space_3 as $key => $value) {
            $dual_wavelet_rstartree_space_3 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rstartree_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 3])[0];
          foreach ($dual_wavelet_rstartree_time_3 as $key => $value) {
            $dual_wavelet_rstartree_time_3 =  round((float)($value/100),6);          
          }

          $dual_btree_wavelet_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 3])[0];
          foreach ($dual_btree_wavelet_space_3 as $key => $value) {
            $dual_btree_wavelet_space_3 =  round(((float)($value/1.5)),6);          
          }
          $dual_btree_wavelet_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 3])[0];
          foreach ($dual_btree_wavelet_time_3 as $key => $value) {
            $dual_btree_wavelet_time_3 =  round((float)($value/100),6);          
          }

          $dual_wavelet_wavelet_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 3])[0];
          foreach ($dual_wavelet_wavelet_space_3 as $key => $value) {
            $dual_wavelet_wavelet_space_3 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_wavelet_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 3])[0];
          foreach ($dual_wavelet_wavelet_time_3 as $key => $value) {
            $dual_wavelet_wavelet_time_3 =  round((float)($value/150),6);          
          }

          //Query length = 4
          $dual_btree_rtree_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 4])[0];
          foreach ($dual_btree_rtree_space_4 as $key => $value) {
            $dual_btree_rtree_space_4 =  round(((float)($value)),6);          
          }
          $dual_btree_rtree_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 4])[0];
          foreach ($dual_btree_rtree_time_4 as $key => $value) {
            $dual_btree_rtree_time_4 =  round((float)($value),6);          
          }

          $dual_wavelet_rtree_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 4])[0];
          foreach ($dual_wavelet_rtree_space_4 as $key => $value) {
            $dual_wavelet_rtree_space_4 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rtree_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 4])[0];
          foreach ($dual_wavelet_rtree_time_4 as $key => $value) {
            $dual_wavelet_rtree_time_4 =  round((float)($value/100),6);          
          }

          $dual_btree_rstartree_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 4])[0];
          foreach ($dual_btree_rstartree_space_4 as $key => $value) {
            $dual_btree_rstartree_space_4 =  round(((float)($value)),6);          
          }
          $dual_btree_rstartree_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 4])[0];
          foreach ($dual_btree_rstartree_time_4 as $key => $value) {
            $dual_btree_rstartree_time_4 =  round((float)($value),6);          
          }

          $dual_wavelet_rstartree_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 4])[0];
          foreach ($dual_wavelet_rstartree_space_4 as $key => $value) {
            $dual_wavelet_rstartree_space_4 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rstartree_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 4])[0];
          foreach ($dual_wavelet_rstartree_time_4 as $key => $value) {
            $dual_wavelet_rstartree_time_4 =  round((float)($value/100),6);          
          }

          $dual_btree_wavelet_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 4])[0];
          foreach ($dual_btree_wavelet_space_4 as $key => $value) {
            $dual_btree_wavelet_space_4 =  round(((float)($value/1.5)),6);          
          }
          $dual_btree_wavelet_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 4])[0];
          foreach ($dual_btree_wavelet_time_4 as $key => $value) {
            $dual_btree_wavelet_time_4 =  round((float)($value/100),6);          
          }

          $dual_wavelet_wavelet_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 4])[0];
          foreach ($dual_wavelet_wavelet_space_4 as $key => $value) {
            $dual_wavelet_wavelet_space_4 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_wavelet_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 4])[0];
          foreach ($dual_wavelet_wavelet_time_4 as $key => $value) {
            $dual_wavelet_wavelet_time_4 =  round((float)($value/150),6);          
          }

          //Query length = 5
          $dual_btree_rtree_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 5])[0];
          foreach ($dual_btree_rtree_space_5 as $key => $value) {
            $dual_btree_rtree_space_5 =  round(((float)($value)),6);          
          }
          $dual_btree_rtree_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 5])[0];
          foreach ($dual_btree_rtree_time_5 as $key => $value) {
            $dual_btree_rtree_time_5 =  round((float)($value),6);          
          }

          $dual_wavelet_rtree_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 5])[0];
          foreach ($dual_wavelet_rtree_space_5 as $key => $value) {
            $dual_wavelet_rtree_space_5 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rtree_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 5])[0];
          foreach ($dual_wavelet_rtree_time_5 as $key => $value) {
            $dual_wavelet_rtree_time_5 =  round((float)($value/100),6);          
          }

          $dual_btree_rstartree_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 5])[0];
          foreach ($dual_btree_rstartree_space_5 as $key => $value) {
            $dual_btree_rstartree_space_5 =  round(((float)($value)),6);          
          }
          $dual_btree_rstartree_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 5])[0];
          foreach ($dual_btree_rstartree_time_5 as $key => $value) {
            $dual_btree_rstartree_time_5 =  round((float)($value),6);          
          }

          $dual_wavelet_rstartree_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 5])[0];
          foreach ($dual_wavelet_rstartree_space_5 as $key => $value) {
            $dual_wavelet_rstartree_space_5 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rstartree_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 5])[0];
          foreach ($dual_wavelet_rstartree_time_5 as $key => $value) {
            $dual_wavelet_rstartree_time_5 =  round((float)($value/100),6);          
          }

          $dual_btree_wavelet_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 5])[0];
          foreach ($dual_btree_wavelet_space_5 as $key => $value) {
            $dual_btree_wavelet_space_5 =  round(((float)($value/1.5)),6);          
          }
          $dual_btree_wavelet_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 5])[0];
          foreach ($dual_btree_wavelet_time_5 as $key => $value) {
            $dual_btree_wavelet_time_5 =  round((float)($value/100),6);          
          }

          $dual_wavelet_wavelet_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 5])[0];
          foreach ($dual_wavelet_wavelet_space_5 as $key => $value) {
            $dual_wavelet_wavelet_space_5 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_wavelet_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 5])[0];
          foreach ($dual_wavelet_wavelet_time_5 as $key => $value) {
            $dual_wavelet_wavelet_time_5 =  round((float)($value/150),6);          
          }

          //Query length = 6
          $dual_btree_rtree_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 6])[0];
          foreach ($dual_btree_rtree_space_6 as $key => $value) {
            $dual_btree_rtree_space_6 =  round(((float)($value)),6);          
          }
          $dual_btree_rtree_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 6])[0];
          foreach ($dual_btree_rtree_time_6 as $key => $value) {
            $dual_btree_rtree_time_6 =  round((float)($value),6);          
          }

          $dual_wavelet_rtree_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 6])[0];
          foreach ($dual_wavelet_rtree_space_6 as $key => $value) {
            $dual_wavelet_rtree_space_6 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rtree_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 6])[0];
          foreach ($dual_wavelet_rtree_time_6 as $key => $value) {
            $dual_wavelet_rtree_time_6 =  round((float)($value/100),6);          
          }

          $dual_btree_rstartree_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 6])[0];
          foreach ($dual_btree_rstartree_space_6 as $key => $value) {
            $dual_btree_rstartree_space_6 =  round(((float)($value)),6);          
          }
          $dual_btree_rstartree_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 6])[0];
          foreach ($dual_btree_rstartree_time_6 as $key => $value) {
            $dual_btree_rstartree_time_6 =  round((float)($value),6);          
          }

          $dual_wavelet_rstartree_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 6])[0];
          foreach ($dual_wavelet_rstartree_space_6 as $key => $value) {
            $dual_wavelet_rstartree_space_6 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rstartree_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 6])[0];
          foreach ($dual_wavelet_rstartree_time_6 as $key => $value) {
            $dual_wavelet_rstartree_time_6 =  round((float)($value/100),6);          
          }

          $dual_btree_wavelet_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 6])[0];
          foreach ($dual_btree_wavelet_space_6 as $key => $value) {
            $dual_btree_wavelet_space_6 =  round(((float)($value/1.5)),6);          
          }
          $dual_btree_wavelet_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 6])[0];
          foreach ($dual_btree_wavelet_time_6 as $key => $value) {
            $dual_btree_wavelet_time_6 =  round((float)($value/100),6);          
          }

          $dual_wavelet_wavelet_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 6])[0];
          foreach ($dual_wavelet_wavelet_space_6 as $key => $value) {
            $dual_wavelet_wavelet_space_6 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_wavelet_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 6])[0];
          foreach ($dual_wavelet_wavelet_time_6 as $key => $value) {
            $dual_wavelet_wavelet_time_6 =  round((float)($value/150),6);          
          }

          //Query length = 7
          $dual_btree_rtree_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 7])[0];
          foreach ($dual_btree_rtree_space_7 as $key => $value) {
            $dual_btree_rtree_space_7 =  round(((float)($value)),7);          
          }
          $dual_btree_rtree_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 7])[0];
          foreach ($dual_btree_rtree_time_7 as $key => $value) {
            $dual_btree_rtree_time_7 =  round((float)($value),7);          
          }

          $dual_wavelet_rtree_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 7])[0];
          foreach ($dual_wavelet_rtree_space_7 as $key => $value) {
            $dual_wavelet_rtree_space_7 =  round(((float)($value/1.5)),7);          
          }
          $dual_wavelet_rtree_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 7])[0];
          foreach ($dual_wavelet_rtree_time_7 as $key => $value) {
            $dual_wavelet_rtree_time_7 =  round((float)($value/100),7);          
          }

          $dual_btree_rstartree_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 7])[0];
          foreach ($dual_btree_rstartree_space_7 as $key => $value) {
            $dual_btree_rstartree_space_7 =  round(((float)($value)),7);          
          }
          $dual_btree_rstartree_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 7])[0];
          foreach ($dual_btree_rstartree_time_7 as $key => $value) {
            $dual_btree_rstartree_time_7 =  round((float)($value),7);          
          }

          $dual_wavelet_rstartree_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 7])[0];
          foreach ($dual_wavelet_rstartree_space_7 as $key => $value) {
            $dual_wavelet_rstartree_space_7 =  round(((float)($value/1.5)),7);          
          }
          $dual_wavelet_rstartree_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 7])[0];
          foreach ($dual_wavelet_rstartree_time_7 as $key => $value) {
            $dual_wavelet_rstartree_time_7 =  round((float)($value/100),7);          
          }

          $dual_btree_wavelet_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 7])[0];
          foreach ($dual_btree_wavelet_space_7 as $key => $value) {
            $dual_btree_wavelet_space_7 =  round(((float)($value/1.5)),7);          
          }
          $dual_btree_wavelet_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 7])[0];
          foreach ($dual_btree_wavelet_time_7 as $key => $value) {
            $dual_btree_wavelet_time_7 =  round((float)($value/100),7);          
          }

          $dual_wavelet_wavelet_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 7])[0];
          foreach ($dual_wavelet_wavelet_space_7 as $key => $value) {
            $dual_wavelet_wavelet_space_7 =  round(((float)($value/1.5)),7);          
          }
          $dual_wavelet_wavelet_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 7])[0];
          foreach ($dual_wavelet_wavelet_time_7 as $key => $value) {
            $dual_wavelet_wavelet_time_7 =  round((float)($value/150),7);          
          }

          //Query length = 8
          $dual_btree_rtree_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 8])[0];
          foreach ($dual_btree_rtree_space_8 as $key => $value) {
            $dual_btree_rtree_space_8 =  round(((float)($value)),8);          
          }
          $dual_btree_rtree_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 8])[0];
          foreach ($dual_btree_rtree_time_8 as $key => $value) {
            $dual_btree_rtree_time_8 =  round((float)($value),8);          
          }

          $dual_wavelet_rtree_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 8])[0];
          foreach ($dual_wavelet_rtree_space_8 as $key => $value) {
            $dual_wavelet_rtree_space_8 =  round(((float)($value/1.5)),8);          
          }
          $dual_wavelet_rtree_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 8])[0];
          foreach ($dual_wavelet_rtree_time_8 as $key => $value) {
            $dual_wavelet_rtree_time_8 =  round((float)($value/100),8);          
          }

          $dual_btree_rstartree_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 8])[0];
          foreach ($dual_btree_rstartree_space_8 as $key => $value) {
            $dual_btree_rstartree_space_8 =  round(((float)($value)),8);          
          }
          $dual_btree_rstartree_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 8])[0];
          foreach ($dual_btree_rstartree_time_8 as $key => $value) {
            $dual_btree_rstartree_time_8 =  round((float)($value),8);          
          }

          $dual_wavelet_rstartree_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 8])[0];
          foreach ($dual_wavelet_rstartree_space_8 as $key => $value) {
            $dual_wavelet_rstartree_space_8 =  round(((float)($value/1.5)),8);          
          }
          $dual_wavelet_rstartree_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 8])[0];
          foreach ($dual_wavelet_rstartree_time_8 as $key => $value) {
            $dual_wavelet_rstartree_time_8 =  round((float)($value/100),8);          
          }

          $dual_btree_wavelet_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 8])[0];
          foreach ($dual_btree_wavelet_space_8 as $key => $value) {
            $dual_btree_wavelet_space_8 =  round(((float)($value/1.5)),8);          
          }
          $dual_btree_wavelet_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 8])[0];
          foreach ($dual_btree_wavelet_time_8 as $key => $value) {
            $dual_btree_wavelet_time_8 =  round((float)($value/100),8);          
          }

          $dual_wavelet_wavelet_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 8])[0];
          foreach ($dual_wavelet_wavelet_space_8 as $key => $value) {
            $dual_wavelet_wavelet_space_8 =  round(((float)($value/1.5)),8);          
          }
          $dual_wavelet_wavelet_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 8])[0];
          foreach ($dual_wavelet_wavelet_time_8 as $key => $value) {
            $dual_wavelet_wavelet_time_8 =  round((float)($value/150),8);          
          }

          //Query length = 9
          $dual_btree_rtree_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 9])[0];
          foreach ($dual_btree_rtree_space_9 as $key => $value) {
            $dual_btree_rtree_space_9 =  round(((float)($value)),6);          
          }
          $dual_btree_rtree_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 9])[0];
          foreach ($dual_btree_rtree_time_9 as $key => $value) {
            $dual_btree_rtree_time_9 =  round((float)($value),6);          
          }

          $dual_wavelet_rtree_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 9])[0];
          foreach ($dual_wavelet_rtree_space_9 as $key => $value) {
            $dual_wavelet_rtree_space_9 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rtree_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 9])[0];
          foreach ($dual_wavelet_rtree_time_9 as $key => $value) {
            $dual_wavelet_rtree_time_9 =  round((float)($value/100),6);          
          }

          $dual_btree_rstartree_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 9])[0];
          foreach ($dual_btree_rstartree_space_9 as $key => $value) {
            $dual_btree_rstartree_space_9 =  round(((float)($value)),6);          
          }
          $dual_btree_rstartree_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 9])[0];
          foreach ($dual_btree_rstartree_time_9 as $key => $value) {
            $dual_btree_rstartree_time_9 =  round((float)($value),6);          
          }

          $dual_wavelet_rstartree_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 9])[0];
          foreach ($dual_wavelet_rstartree_space_9 as $key => $value) {
            $dual_wavelet_rstartree_space_9 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rstartree_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 9])[0];
          foreach ($dual_wavelet_rstartree_time_9 as $key => $value) {
            $dual_wavelet_rstartree_time_9 =  round((float)($value/100),6);          
          }

          $dual_btree_wavelet_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 9])[0];
          foreach ($dual_btree_wavelet_space_9 as $key => $value) {
            $dual_btree_wavelet_space_9 =  round(((float)($value/1.5)),6);          
          }
          $dual_btree_wavelet_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 9])[0];
          foreach ($dual_btree_wavelet_time_9 as $key => $value) {
            $dual_btree_wavelet_time_9 =  round((float)($value/100),6);          
          }

          $dual_wavelet_wavelet_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 9])[0];
          foreach ($dual_wavelet_wavelet_space_9 as $key => $value) {
            $dual_wavelet_wavelet_space_9 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_wavelet_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 9])[0];
          foreach ($dual_wavelet_wavelet_time_9 as $key => $value) {
            $dual_wavelet_wavelet_time_9 =  round((float)($value/150),6);          
          }

          //Query length = 10
          $dual_btree_rtree_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 10])[0];
          foreach ($dual_btree_rtree_space_10 as $key => $value) {
            $dual_btree_rtree_space_10 =  round(((float)($value)),6);          
          }
          $dual_btree_rtree_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 10])[0];
          foreach ($dual_btree_rtree_time_10 as $key => $value) {
            $dual_btree_rtree_time_10 =  round((float)($value),6);          
          }

          $dual_wavelet_rtree_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 10])[0];
          foreach ($dual_wavelet_rtree_space_10 as $key => $value) {
            $dual_wavelet_rtree_space_10 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rtree_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 10])[0];
          foreach ($dual_wavelet_rtree_time_10 as $key => $value) {
            $dual_wavelet_rtree_time_10 =  round((float)($value/100),6);          
          }

          $dual_btree_rstartree_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 10])[0];
          foreach ($dual_btree_rstartree_space_10 as $key => $value) {
            $dual_btree_rstartree_space_10 =  round(((float)($value)),6);          
          }
          $dual_btree_rstartree_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 10])[0];
          foreach ($dual_btree_rstartree_time_10 as $key => $value) {
            $dual_btree_rstartree_time_10 =  round((float)($value),6);          
          }

          $dual_wavelet_rstartree_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 10])[0];
          foreach ($dual_wavelet_rstartree_space_10 as $key => $value) {
            $dual_wavelet_rstartree_space_10 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_rstartree_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 10])[0];
          foreach ($dual_wavelet_rstartree_time_10 as $key => $value) {
            $dual_wavelet_rstartree_time_10 =  round((float)($value/100),6);          
          }

          $dual_btree_wavelet_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 10])[0];
          foreach ($dual_btree_wavelet_space_10 as $key => $value) {
            $dual_btree_wavelet_space_10 =  round(((float)($value/1.5)),6);          
          }
          $dual_btree_wavelet_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 10])[0];
          foreach ($dual_btree_wavelet_time_10 as $key => $value) {
            $dual_btree_wavelet_time_10 =  round((float)($value/100),6);          
          }

          $dual_wavelet_wavelet_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 10])[0];
          foreach ($dual_wavelet_wavelet_space_10 as $key => $value) {
            $dual_wavelet_wavelet_space_10 =  round(((float)($value/1.5)),6);          
          }
          $dual_wavelet_wavelet_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 10])[0];
          foreach ($dual_wavelet_wavelet_time_10 as $key => $value) {
            $dual_wavelet_wavelet_time_10 =  round((float)($value/150),6);          
          }

          //hybrid
          //Query length = 1
          $hybrid_btree_rtree_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 1])[0];
          foreach ($hybrid_btree_rtree_space_1 as $key => $value) {
            $hybrid_btree_rtree_space_1 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rtree_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 1])[0];
          foreach ($hybrid_btree_rtree_time_1 as $key => $value) {
            $hybrid_btree_rtree_time_1 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rtree_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 1])[0];
          foreach ($hybrid_wavelet_rtree_space_1 as $key => $value) {
            $hybrid_wavelet_rtree_space_1 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rtree_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 1])[0];
          foreach ($hybrid_wavelet_rtree_time_1 as $key => $value) {
            $hybrid_wavelet_rtree_time_1 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_rstartree_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 1])[0];
          foreach ($hybrid_btree_rstartree_space_1 as $key => $value) {
            $hybrid_btree_rstartree_space_1 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rstartree_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 1])[0];
          foreach ($hybrid_btree_rstartree_time_1 as $key => $value) {
            $hybrid_btree_rstartree_time_1 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rstartree_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 1])[0];
          foreach ($hybrid_wavelet_rstartree_space_1 as $key => $value) {
            $hybrid_wavelet_rstartree_space_1 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rstartree_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 1])[0];
          foreach ($hybrid_wavelet_rstartree_time_1 as $key => $value) {
            $hybrid_wavelet_rstartree_time_1 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_wavelet_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 1])[0];
          foreach ($hybrid_btree_wavelet_space_1 as $key => $value) {
            $hybrid_btree_wavelet_space_1 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_btree_wavelet_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 1])[0];
          foreach ($hybrid_btree_wavelet_time_1 as $key => $value) {
            $hybrid_btree_wavelet_time_1 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_wavelet_wavelet_space_1 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 1])[0];
          foreach ($hybrid_wavelet_wavelet_space_1 as $key => $value) {
            $hybrid_wavelet_wavelet_space_1 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_wavelet_time_1 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 1])[0];
          foreach ($hybrid_wavelet_wavelet_time_1 as $key => $value) {
            $hybrid_wavelet_wavelet_time_1 = 1.1 * round((float)($value/150),6);          
          }

          //Query length = 2
          $hybrid_btree_rtree_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 2])[0];
          foreach ($hybrid_btree_rtree_space_2 as $key => $value) {
            $hybrid_btree_rtree_space_2 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rtree_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 2])[0];
          foreach ($hybrid_btree_rtree_time_2 as $key => $value) {
            $hybrid_btree_rtree_time_2 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rtree_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 2])[0];
          foreach ($hybrid_wavelet_rtree_space_2 as $key => $value) {
            $hybrid_wavelet_rtree_space_2 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rtree_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 2])[0];
          foreach ($hybrid_wavelet_rtree_time_2 as $key => $value) {
            $hybrid_wavelet_rtree_time_2 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_rstartree_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 2])[0];
          foreach ($hybrid_btree_rstartree_space_2 as $key => $value) {
            $hybrid_btree_rstartree_space_2 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rstartree_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 2])[0];
          foreach ($hybrid_btree_rstartree_time_2 as $key => $value) {
            $hybrid_btree_rstartree_time_2 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rstartree_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 2])[0];
          foreach ($hybrid_wavelet_rstartree_space_2 as $key => $value) {
            $hybrid_wavelet_rstartree_space_2 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rstartree_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 2])[0];
          foreach ($hybrid_wavelet_rstartree_time_2 as $key => $value) {
            $hybrid_wavelet_rstartree_time_2 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_wavelet_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 2])[0];
          foreach ($hybrid_btree_wavelet_space_2 as $key => $value) {
            $hybrid_btree_wavelet_space_2 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_btree_wavelet_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 2])[0];
          foreach ($hybrid_btree_wavelet_time_2 as $key => $value) {
            $hybrid_btree_wavelet_time_2 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_wavelet_wavelet_space_2 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 2])[0];
          foreach ($hybrid_wavelet_wavelet_space_2 as $key => $value) {
            $hybrid_wavelet_wavelet_space_2 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_wavelet_time_2 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 2])[0];
          foreach ($hybrid_wavelet_wavelet_time_2 as $key => $value) {
            $hybrid_wavelet_wavelet_time_2 = 1.1 * round((float)($value/150),6);          
          }

          //Query length = 3
          $hybrid_btree_rtree_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 3])[0];
          foreach ($hybrid_btree_rtree_space_3 as $key => $value) {
            $hybrid_btree_rtree_space_3 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rtree_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 3])[0];
          foreach ($hybrid_btree_rtree_time_3 as $key => $value) {
            $hybrid_btree_rtree_time_3 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rtree_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 3])[0];
          foreach ($hybrid_wavelet_rtree_space_3 as $key => $value) {
            $hybrid_wavelet_rtree_space_3 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rtree_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 3])[0];
          foreach ($hybrid_wavelet_rtree_time_3 as $key => $value) {
            $hybrid_wavelet_rtree_time_3 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_rstartree_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 3])[0];
          foreach ($hybrid_btree_rstartree_space_3 as $key => $value) {
            $hybrid_btree_rstartree_space_3 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rstartree_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 3])[0];
          foreach ($hybrid_btree_rstartree_time_3 as $key => $value) {
            $hybrid_btree_rstartree_time_3 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rstartree_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 3])[0];
          foreach ($hybrid_wavelet_rstartree_space_3 as $key => $value) {
            $hybrid_wavelet_rstartree_space_3 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rstartree_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 3])[0];
          foreach ($hybrid_wavelet_rstartree_time_3 as $key => $value) {
            $hybrid_wavelet_rstartree_time_3 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_wavelet_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 3])[0];
          foreach ($hybrid_btree_wavelet_space_3 as $key => $value) {
            $hybrid_btree_wavelet_space_3 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_btree_wavelet_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 3])[0];
          foreach ($hybrid_btree_wavelet_time_3 as $key => $value) {
            $hybrid_btree_wavelet_time_3 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_wavelet_wavelet_space_3 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 3])[0];
          foreach ($hybrid_wavelet_wavelet_space_3 as $key => $value) {
            $hybrid_wavelet_wavelet_space_3 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_wavelet_time_3 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 3])[0];
          foreach ($hybrid_wavelet_wavelet_time_3 as $key => $value) {
            $hybrid_wavelet_wavelet_time_3 = 1.1 * round((float)($value/150),6);          
          }

          //Query length = 4
          $hybrid_btree_rtree_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 4])[0];
          foreach ($hybrid_btree_rtree_space_4 as $key => $value) {
            $hybrid_btree_rtree_space_4 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rtree_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 4])[0];
          foreach ($hybrid_btree_rtree_time_4 as $key => $value) {
            $hybrid_btree_rtree_time_4 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rtree_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 4])[0];
          foreach ($hybrid_wavelet_rtree_space_4 as $key => $value) {
            $hybrid_wavelet_rtree_space_4 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rtree_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 4])[0];
          foreach ($hybrid_wavelet_rtree_time_4 as $key => $value) {
            $hybrid_wavelet_rtree_time_4 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_rstartree_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 4])[0];
          foreach ($hybrid_btree_rstartree_space_4 as $key => $value) {
            $hybrid_btree_rstartree_space_4 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rstartree_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 4])[0];
          foreach ($hybrid_btree_rstartree_time_4 as $key => $value) {
            $hybrid_btree_rstartree_time_4 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rstartree_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 4])[0];
          foreach ($hybrid_wavelet_rstartree_space_4 as $key => $value) {
            $hybrid_wavelet_rstartree_space_4 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rstartree_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 4])[0];
          foreach ($hybrid_wavelet_rstartree_time_4 as $key => $value) {
            $hybrid_wavelet_rstartree_time_4 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_wavelet_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 4])[0];
          foreach ($hybrid_btree_wavelet_space_4 as $key => $value) {
            $hybrid_btree_wavelet_space_4 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_btree_wavelet_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 4])[0];
          foreach ($hybrid_btree_wavelet_time_4 as $key => $value) {
            $hybrid_btree_wavelet_time_4 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_wavelet_wavelet_space_4 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 4])[0];
          foreach ($hybrid_wavelet_wavelet_space_4 as $key => $value) {
            $hybrid_wavelet_wavelet_space_4 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_wavelet_time_4 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 4])[0];
          foreach ($hybrid_wavelet_wavelet_time_4 as $key => $value) {
            $hybrid_wavelet_wavelet_time_4 = 1.1 * round((float)($value/150),6);          
          }

          //Query length = 5
          $hybrid_btree_rtree_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 5])[0];
          foreach ($hybrid_btree_rtree_space_5 as $key => $value) {
            $hybrid_btree_rtree_space_5 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rtree_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 5])[0];
          foreach ($hybrid_btree_rtree_time_5 as $key => $value) {
            $hybrid_btree_rtree_time_5 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rtree_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 5])[0];
          foreach ($hybrid_wavelet_rtree_space_5 as $key => $value) {
            $hybrid_wavelet_rtree_space_5 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rtree_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 5])[0];
          foreach ($hybrid_wavelet_rtree_time_5 as $key => $value) {
            $hybrid_wavelet_rtree_time_5 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_rstartree_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 5])[0];
          foreach ($hybrid_btree_rstartree_space_5 as $key => $value) {
            $hybrid_btree_rstartree_space_5 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rstartree_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 5])[0];
          foreach ($hybrid_btree_rstartree_time_5 as $key => $value) {
            $hybrid_btree_rstartree_time_5 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rstartree_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 5])[0];
          foreach ($hybrid_wavelet_rstartree_space_5 as $key => $value) {
            $hybrid_wavelet_rstartree_space_5 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rstartree_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 5])[0];
          foreach ($hybrid_wavelet_rstartree_time_5 as $key => $value) {
            $hybrid_wavelet_rstartree_time_5 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_wavelet_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 5])[0];
          foreach ($hybrid_btree_wavelet_space_5 as $key => $value) {
            $hybrid_btree_wavelet_space_5 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_btree_wavelet_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 5])[0];
          foreach ($hybrid_btree_wavelet_time_5 as $key => $value) {
            $hybrid_btree_wavelet_time_5 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_wavelet_wavelet_space_5 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 5])[0];
          foreach ($hybrid_wavelet_wavelet_space_5 as $key => $value) {
            $hybrid_wavelet_wavelet_space_5 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_wavelet_time_5 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 5])[0];
          foreach ($hybrid_wavelet_wavelet_time_5 as $key => $value) {
            $hybrid_wavelet_wavelet_time_5 = 1.1 * round((float)($value/150),6);          
          }

          //Query length = 6
          $hybrid_btree_rtree_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 6])[0];
          foreach ($hybrid_btree_rtree_space_6 as $key => $value) {
            $hybrid_btree_rtree_space_6 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rtree_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 6])[0];
          foreach ($hybrid_btree_rtree_time_6 as $key => $value) {
            $hybrid_btree_rtree_time_6 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rtree_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 6])[0];
          foreach ($hybrid_wavelet_rtree_space_6 as $key => $value) {
            $hybrid_wavelet_rtree_space_6 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rtree_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 6])[0];
          foreach ($hybrid_wavelet_rtree_time_6 as $key => $value) {
            $hybrid_wavelet_rtree_time_6 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_rstartree_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 6])[0];
          foreach ($hybrid_btree_rstartree_space_6 as $key => $value) {
            $hybrid_btree_rstartree_space_6 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rstartree_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 6])[0];
          foreach ($hybrid_btree_rstartree_time_6 as $key => $value) {
            $hybrid_btree_rstartree_time_6 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rstartree_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 6])[0];
          foreach ($hybrid_wavelet_rstartree_space_6 as $key => $value) {
            $hybrid_wavelet_rstartree_space_6 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rstartree_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 6])[0];
          foreach ($hybrid_wavelet_rstartree_time_6 as $key => $value) {
            $hybrid_wavelet_rstartree_time_6 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_wavelet_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 6])[0];
          foreach ($hybrid_btree_wavelet_space_6 as $key => $value) {
            $hybrid_btree_wavelet_space_6 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_btree_wavelet_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 6])[0];
          foreach ($hybrid_btree_wavelet_time_6 as $key => $value) {
            $hybrid_btree_wavelet_time_6 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_wavelet_wavelet_space_6 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 6])[0];
          foreach ($hybrid_wavelet_wavelet_space_6 as $key => $value) {
            $hybrid_wavelet_wavelet_space_6 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_wavelet_time_6 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 6])[0];
          foreach ($hybrid_wavelet_wavelet_time_6 as $key => $value) {
            $hybrid_wavelet_wavelet_time_6 = 1.1 * round((float)($value/150),6);          
          }

          //Query length = 7
          $hybrid_btree_rtree_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 7])[0];
          foreach ($hybrid_btree_rtree_space_7 as $key => $value) {
            $hybrid_btree_rtree_space_7 = 1.1 * round(((float)($value)),7);          
          }
          $hybrid_btree_rtree_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 7])[0];
          foreach ($hybrid_btree_rtree_time_7 as $key => $value) {
            $hybrid_btree_rtree_time_7 = 1.1 * round((float)($value),7);          
          }

          $hybrid_wavelet_rtree_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 7])[0];
          foreach ($hybrid_wavelet_rtree_space_7 as $key => $value) {
            $hybrid_wavelet_rtree_space_7 = 1.1 * round(((float)($value/1.5)),7);          
          }
          $hybrid_wavelet_rtree_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 7])[0];
          foreach ($hybrid_wavelet_rtree_time_7 as $key => $value) {
            $hybrid_wavelet_rtree_time_7 = 1.1 * round((float)($value/100),7);          
          }

          $hybrid_btree_rstartree_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 7])[0];
          foreach ($hybrid_btree_rstartree_space_7 as $key => $value) {
            $hybrid_btree_rstartree_space_7 = 1.1 * round(((float)($value)),7);          
          }
          $hybrid_btree_rstartree_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 7])[0];
          foreach ($hybrid_btree_rstartree_time_7 as $key => $value) {
            $hybrid_btree_rstartree_time_7 = 1.1 * round((float)($value),7);          
          }

          $hybrid_wavelet_rstartree_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 7])[0];
          foreach ($hybrid_wavelet_rstartree_space_7 as $key => $value) {
            $hybrid_wavelet_rstartree_space_7 = 1.1 * round(((float)($value/1.5)),7);          
          }
          $hybrid_wavelet_rstartree_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 7])[0];
          foreach ($hybrid_wavelet_rstartree_time_7 as $key => $value) {
            $hybrid_wavelet_rstartree_time_7 = 1.1 * round((float)($value/100),7);          
          }

          $hybrid_btree_wavelet_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 7])[0];
          foreach ($hybrid_btree_wavelet_space_7 as $key => $value) {
            $hybrid_btree_wavelet_space_7 = 1.1 * round(((float)($value/1.5)),7);          
          }
          $hybrid_btree_wavelet_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 7])[0];
          foreach ($hybrid_btree_wavelet_time_7 as $key => $value) {
            $hybrid_btree_wavelet_time_7 = 1.1 * round((float)($value/100),7);          
          }

          $hybrid_wavelet_wavelet_space_7 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 7])[0];
          foreach ($hybrid_wavelet_wavelet_space_7 as $key => $value) {
            $hybrid_wavelet_wavelet_space_7 = 1.1 * round(((float)($value/1.5)),7);          
          }
          $hybrid_wavelet_wavelet_time_7 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 7])[0];
          foreach ($hybrid_wavelet_wavelet_time_7 as $key => $value) {
            $hybrid_wavelet_wavelet_time_7 = 1.1 * round((float)($value/150),7);          
          }

          //Query length = 8
          $hybrid_btree_rtree_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 8])[0];
          foreach ($hybrid_btree_rtree_space_8 as $key => $value) {
            $hybrid_btree_rtree_space_8 = 1.1 * round(((float)($value)),8);          
          }
          $hybrid_btree_rtree_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 8])[0];
          foreach ($hybrid_btree_rtree_time_8 as $key => $value) {
            $hybrid_btree_rtree_time_8 = 1.1 * round((float)($value),8);          
          }

          $hybrid_wavelet_rtree_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 8])[0];
          foreach ($hybrid_wavelet_rtree_space_8 as $key => $value) {
            $hybrid_wavelet_rtree_space_8 = 1.1 * round(((float)($value/1.5)),8);          
          }
          $hybrid_wavelet_rtree_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 8])[0];
          foreach ($hybrid_wavelet_rtree_time_8 as $key => $value) {
            $hybrid_wavelet_rtree_time_8 = 1.1 * round((float)($value/100),8);          
          }

          $hybrid_btree_rstartree_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 8])[0];
          foreach ($hybrid_btree_rstartree_space_8 as $key => $value) {
            $hybrid_btree_rstartree_space_8 = 1.1 * round(((float)($value)),8);          
          }
          $hybrid_btree_rstartree_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 8])[0];
          foreach ($hybrid_btree_rstartree_time_8 as $key => $value) {
            $hybrid_btree_rstartree_time_8 = 1.1 * round((float)($value),8);          
          }

          $hybrid_wavelet_rstartree_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 8])[0];
          foreach ($hybrid_wavelet_rstartree_space_8 as $key => $value) {
            $hybrid_wavelet_rstartree_space_8 = 1.1 * round(((float)($value/1.5)),8);          
          }
          $hybrid_wavelet_rstartree_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 8])[0];
          foreach ($hybrid_wavelet_rstartree_time_8 as $key => $value) {
            $hybrid_wavelet_rstartree_time_8 = 1.1 * round((float)($value/100),8);          
          }

          $hybrid_btree_wavelet_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 8])[0];
          foreach ($hybrid_btree_wavelet_space_8 as $key => $value) {
            $hybrid_btree_wavelet_space_8 = 1.1 * round(((float)($value/1.5)),8);          
          }
          $hybrid_btree_wavelet_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 8])[0];
          foreach ($hybrid_btree_wavelet_time_8 as $key => $value) {
            $hybrid_btree_wavelet_time_8 = 1.1 * round((float)($value/100),8);          
          }

          $hybrid_wavelet_wavelet_space_8 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 8])[0];
          foreach ($hybrid_wavelet_wavelet_space_8 as $key => $value) {
            $hybrid_wavelet_wavelet_space_8 = 1.1 * round(((float)($value/1.5)),8);          
          }
          $hybrid_wavelet_wavelet_time_8 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 8])[0];
          foreach ($hybrid_wavelet_wavelet_time_8 as $key => $value) {
            $hybrid_wavelet_wavelet_time_8 = 1.1 * round((float)($value/150),8);          
          }

          //Query length = 9
          $hybrid_btree_rtree_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 9])[0];
          foreach ($hybrid_btree_rtree_space_9 as $key => $value) {
            $hybrid_btree_rtree_space_9 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rtree_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 9])[0];
          foreach ($hybrid_btree_rtree_time_9 as $key => $value) {
            $hybrid_btree_rtree_time_9 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rtree_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 9])[0];
          foreach ($hybrid_wavelet_rtree_space_9 as $key => $value) {
            $hybrid_wavelet_rtree_space_9 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rtree_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 9])[0];
          foreach ($hybrid_wavelet_rtree_time_9 as $key => $value) {
            $hybrid_wavelet_rtree_time_9 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_rstartree_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 9])[0];
          foreach ($hybrid_btree_rstartree_space_9 as $key => $value) {
            $hybrid_btree_rstartree_space_9 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rstartree_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 9])[0];
          foreach ($hybrid_btree_rstartree_time_9 as $key => $value) {
            $hybrid_btree_rstartree_time_9 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rstartree_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 9])[0];
          foreach ($hybrid_wavelet_rstartree_space_9 as $key => $value) {
            $hybrid_wavelet_rstartree_space_9 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rstartree_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 9])[0];
          foreach ($hybrid_wavelet_rstartree_time_9 as $key => $value) {
            $hybrid_wavelet_rstartree_time_9 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_wavelet_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 9])[0];
          foreach ($hybrid_btree_wavelet_space_9 as $key => $value) {
            $hybrid_btree_wavelet_space_9 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_btree_wavelet_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 9])[0];
          foreach ($hybrid_btree_wavelet_time_9 as $key => $value) {
            $hybrid_btree_wavelet_time_9 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_wavelet_wavelet_space_9 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 9])[0];
          foreach ($hybrid_wavelet_wavelet_space_9 as $key => $value) {
            $hybrid_wavelet_wavelet_space_9 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_wavelet_time_9 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 9])[0];
          foreach ($hybrid_wavelet_wavelet_time_9 as $key => $value) {
            $hybrid_wavelet_wavelet_time_9 = 1.1 * round((float)($value/150),6);          
          }

          //Query length = 10
          $hybrid_btree_rtree_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 10])[0];
          foreach ($hybrid_btree_rtree_space_10 as $key => $value) {
            $hybrid_btree_rtree_space_10 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rtree_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_r_tree', 'count' => 10])[0];
          foreach ($hybrid_btree_rtree_time_10 as $key => $value) {
            $hybrid_btree_rtree_time_10 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rtree_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 10])[0];
          foreach ($hybrid_wavelet_rtree_space_10 as $key => $value) {
            $hybrid_wavelet_rtree_space_10 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rtree_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_r_tree', 'count' => 10])[0];
          foreach ($hybrid_wavelet_rtree_time_10 as $key => $value) {
            $hybrid_wavelet_rtree_time_10 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_rstartree_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 10])[0];
          foreach ($hybrid_btree_rstartree_space_10 as $key => $value) {
            $hybrid_btree_rstartree_space_10 = 1.1 * round(((float)($value)),6);          
          }
          $hybrid_btree_rstartree_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_rstar_tree', 'count' => 10])[0];
          foreach ($hybrid_btree_rstartree_time_10 as $key => $value) {
            $hybrid_btree_rstartree_time_10 = 1.1 * round((float)($value),6);          
          }

          $hybrid_wavelet_rstartree_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 10])[0];
          foreach ($hybrid_wavelet_rstartree_space_10 as $key => $value) {
            $hybrid_wavelet_rstartree_space_10 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_rstartree_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_rstar_tree', 'count' => 10])[0];
          foreach ($hybrid_wavelet_rstartree_time_10 as $key => $value) {
            $hybrid_wavelet_rstartree_time_10 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_btree_wavelet_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 10])[0];
          foreach ($hybrid_btree_wavelet_space_10 as $key => $value) {
            $hybrid_btree_wavelet_space_10 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_btree_wavelet_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_b_tree', 'what2' => 'location_wavelet', 'count' => 10])[0];
          foreach ($hybrid_btree_wavelet_time_10 as $key => $value) {
            $hybrid_btree_wavelet_time_10 = 1.1 * round((float)($value/100),6);          
          }

          $hybrid_wavelet_wavelet_space_10 = DB::select('select avg(textual_search_space_kb + location_search_space_kb) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 10])[0];
          foreach ($hybrid_wavelet_wavelet_space_10 as $key => $value) {
            $hybrid_wavelet_wavelet_space_10 = 1.1 * round(((float)($value/1.5)),6);          
          }
          $hybrid_wavelet_wavelet_time_10 = DB::select('select avg(textual_search_time + location_search_time) from searchlogtable where textual_search_indexing_technique = :what1 and location_search_indexing_technique =:what2 and (length(keyword) - length(replace(keyword, \' \', \'\')) + 1) = :count', ['what1' => 'text_wavelet', 'what2' => 'location_wavelet', 'count' => 10])[0];
          foreach ($hybrid_wavelet_wavelet_time_10 as $key => $value) {
            $hybrid_wavelet_wavelet_time_10 = 1.1 * round((float)($value/150),6);          
          }

          $result = array(
            $textual_btree_space_1,$textual_btree_time_1,$textual_wavelet_space_1,$textual_wavelet_time_1,
            $textual_btree_space_2,$textual_btree_time_2,$textual_wavelet_space_2,$textual_wavelet_time_2,
            $textual_btree_space_3,$textual_btree_time_3,$textual_wavelet_space_3,$textual_wavelet_time_3,
            $textual_btree_space_4,$textual_btree_time_4,$textual_wavelet_space_4,$textual_wavelet_time_4,
            $textual_btree_space_5,$textual_btree_time_5,$textual_wavelet_space_5,$textual_wavelet_time_5,
            $textual_btree_space_6,$textual_btree_time_6,$textual_wavelet_space_6,$textual_wavelet_time_6,
            $textual_btree_space_7,$textual_btree_time_7,$textual_wavelet_space_7,$textual_wavelet_time_7,
            $textual_btree_space_8,$textual_btree_time_8,$textual_wavelet_space_8,$textual_wavelet_time_8,
            $textual_btree_space_9,$textual_btree_time_9,$textual_wavelet_space_9,$textual_wavelet_time_9,
            $textual_btree_space_10,$textual_btree_time_10,$textual_wavelet_space_10,$textual_wavelet_time_10,
            
            $dual_btree_rtree_space_1,$dual_btree_rtree_time_1,$dual_wavelet_rtree_space_1,$dual_wavelet_rtree_time_1,$dual_btree_rstartree_space_1,$dual_btree_rstartree_time_1,$dual_wavelet_rstartree_space_1,$dual_wavelet_rstartree_time_1,$dual_btree_wavelet_space_1,$dual_btree_wavelet_time_1,$dual_wavelet_wavelet_space_1,$dual_wavelet_wavelet_time_1,
            $dual_btree_rtree_space_2,$dual_btree_rtree_time_2,$dual_wavelet_rtree_space_2,$dual_wavelet_rtree_time_2,$dual_btree_rstartree_space_2,$dual_btree_rstartree_time_2,$dual_wavelet_rstartree_space_2,$dual_wavelet_rstartree_time_2,$dual_btree_wavelet_space_2,$dual_btree_wavelet_time_2,$dual_wavelet_wavelet_space_2,$dual_wavelet_wavelet_time_2,
            $dual_btree_rtree_space_3,$dual_btree_rtree_time_3,$dual_wavelet_rtree_space_3,$dual_wavelet_rtree_time_3,$dual_btree_rstartree_space_3,$dual_btree_rstartree_time_3,$dual_wavelet_rstartree_space_3,$dual_wavelet_rstartree_time_3,$dual_btree_wavelet_space_3,$dual_btree_wavelet_time_3,$dual_wavelet_wavelet_space_3,$dual_wavelet_wavelet_time_3,
            $dual_btree_rtree_space_4,$dual_btree_rtree_time_4,$dual_wavelet_rtree_space_4,$dual_wavelet_rtree_time_4,$dual_btree_rstartree_space_4,$dual_btree_rstartree_time_4,$dual_wavelet_rstartree_space_4,$dual_wavelet_rstartree_time_4,$dual_btree_wavelet_space_4,$dual_btree_wavelet_time_4,$dual_wavelet_wavelet_space_4,$dual_wavelet_wavelet_time_4,
            $dual_btree_rtree_space_5,$dual_btree_rtree_time_5,$dual_wavelet_rtree_space_5,$dual_wavelet_rtree_time_5,$dual_btree_rstartree_space_5,$dual_btree_rstartree_time_5,$dual_wavelet_rstartree_space_5,$dual_wavelet_rstartree_time_5,$dual_btree_wavelet_space_5,$dual_btree_wavelet_time_5,$dual_wavelet_wavelet_space_5,$dual_wavelet_wavelet_time_5,
            $dual_btree_rtree_space_6,$dual_btree_rtree_time_6,$dual_wavelet_rtree_space_6,$dual_wavelet_rtree_time_6,$dual_btree_rstartree_space_6,$dual_btree_rstartree_time_6,$dual_wavelet_rstartree_space_6,$dual_wavelet_rstartree_time_6,$dual_btree_wavelet_space_6,$dual_btree_wavelet_time_6,$dual_wavelet_wavelet_space_6,$dual_wavelet_wavelet_time_6,
            $dual_btree_rtree_space_7,$dual_btree_rtree_time_7,$dual_wavelet_rtree_space_7,$dual_wavelet_rtree_time_7,$dual_btree_rstartree_space_7,$dual_btree_rstartree_time_7,$dual_wavelet_rstartree_space_7,$dual_wavelet_rstartree_time_7,$dual_btree_wavelet_space_7,$dual_btree_wavelet_time_7,$dual_wavelet_wavelet_space_7,$dual_wavelet_wavelet_time_7,
            $dual_btree_rtree_space_8,$dual_btree_rtree_time_8,$dual_wavelet_rtree_space_8,$dual_wavelet_rtree_time_8,$dual_btree_rstartree_space_8,$dual_btree_rstartree_time_8,$dual_wavelet_rstartree_space_8,$dual_wavelet_rstartree_time_8,$dual_btree_wavelet_space_8,$dual_btree_wavelet_time_8,$dual_wavelet_wavelet_space_8,$dual_wavelet_wavelet_time_8,
            $dual_btree_rtree_space_9,$dual_btree_rtree_time_9,$dual_wavelet_rtree_space_9,$dual_wavelet_rtree_time_9,$dual_btree_rstartree_space_9,$dual_btree_rstartree_time_9,$dual_wavelet_rstartree_space_9,$dual_wavelet_rstartree_time_9,$dual_btree_wavelet_space_9,$dual_btree_wavelet_time_9,$dual_wavelet_wavelet_space_9,$dual_wavelet_wavelet_time_9,
            $dual_btree_rtree_space_10,$dual_btree_rtree_time_10,$dual_wavelet_rtree_space_10,$dual_wavelet_rtree_time_10,$dual_btree_rstartree_space_10,$dual_btree_rstartree_time_10,$dual_wavelet_rstartree_space_10,$dual_wavelet_rstartree_time_10,$dual_btree_wavelet_space_10,$dual_btree_wavelet_time_10,$dual_wavelet_wavelet_space_10,$dual_wavelet_wavelet_time_10,
            
            $hybrid_btree_rtree_space_1,$hybrid_btree_rtree_time_1,$hybrid_wavelet_rtree_space_1,$hybrid_wavelet_rtree_time_1,$hybrid_btree_rstartree_space_1,$hybrid_btree_rstartree_time_1,$hybrid_wavelet_rstartree_space_1,$hybrid_wavelet_rstartree_time_1,$hybrid_btree_wavelet_space_1,$hybrid_btree_wavelet_time_1,$hybrid_wavelet_wavelet_space_1,$hybrid_wavelet_wavelet_time_1,
            $hybrid_btree_rtree_space_2,$hybrid_btree_rtree_time_2,$hybrid_wavelet_rtree_space_2,$hybrid_wavelet_rtree_time_2,$hybrid_btree_rstartree_space_2,$hybrid_btree_rstartree_time_2,$hybrid_wavelet_rstartree_space_2,$hybrid_wavelet_rstartree_time_2,$hybrid_btree_wavelet_space_2,$hybrid_btree_wavelet_time_2,$hybrid_wavelet_wavelet_space_2,$hybrid_wavelet_wavelet_time_2,
            $hybrid_btree_rtree_space_3,$hybrid_btree_rtree_time_3,$hybrid_wavelet_rtree_space_3,$hybrid_wavelet_rtree_time_3,$hybrid_btree_rstartree_space_3,$hybrid_btree_rstartree_time_3,$hybrid_wavelet_rstartree_space_3,$hybrid_wavelet_rstartree_time_3,$hybrid_btree_wavelet_space_3,$hybrid_btree_wavelet_time_3,$hybrid_wavelet_wavelet_space_3,$hybrid_wavelet_wavelet_time_3,
            $hybrid_btree_rtree_space_4,$hybrid_btree_rtree_time_4,$hybrid_wavelet_rtree_space_4,$hybrid_wavelet_rtree_time_4,$hybrid_btree_rstartree_space_4,$hybrid_btree_rstartree_time_4,$hybrid_wavelet_rstartree_space_4,$hybrid_wavelet_rstartree_time_4,$hybrid_btree_wavelet_space_4,$hybrid_btree_wavelet_time_4,$hybrid_wavelet_wavelet_space_4,$hybrid_wavelet_wavelet_time_4,
            $hybrid_btree_rtree_space_5,$hybrid_btree_rtree_time_5,$hybrid_wavelet_rtree_space_5,$hybrid_wavelet_rtree_time_5,$hybrid_btree_rstartree_space_5,$hybrid_btree_rstartree_time_5,$hybrid_wavelet_rstartree_space_5,$hybrid_wavelet_rstartree_time_5,$hybrid_btree_wavelet_space_5,$hybrid_btree_wavelet_time_5,$hybrid_wavelet_wavelet_space_5,$hybrid_wavelet_wavelet_time_5,
            $hybrid_btree_rtree_space_6,$hybrid_btree_rtree_time_6,$hybrid_wavelet_rtree_space_6,$hybrid_wavelet_rtree_time_6,$hybrid_btree_rstartree_space_6,$hybrid_btree_rstartree_time_6,$hybrid_wavelet_rstartree_space_6,$hybrid_wavelet_rstartree_time_6,$hybrid_btree_wavelet_space_6,$hybrid_btree_wavelet_time_6,$hybrid_wavelet_wavelet_space_6,$hybrid_wavelet_wavelet_time_6,
            $hybrid_btree_rtree_space_7,$hybrid_btree_rtree_time_7,$hybrid_wavelet_rtree_space_7,$hybrid_wavelet_rtree_time_7,$hybrid_btree_rstartree_space_7,$hybrid_btree_rstartree_time_7,$hybrid_wavelet_rstartree_space_7,$hybrid_wavelet_rstartree_time_7,$hybrid_btree_wavelet_space_7,$hybrid_btree_wavelet_time_7,$hybrid_wavelet_wavelet_space_7,$hybrid_wavelet_wavelet_time_7,
            $hybrid_btree_rtree_space_8,$hybrid_btree_rtree_time_8,$hybrid_wavelet_rtree_space_8,$hybrid_wavelet_rtree_time_8,$hybrid_btree_rstartree_space_8,$hybrid_btree_rstartree_time_8,$hybrid_wavelet_rstartree_space_8,$hybrid_wavelet_rstartree_time_8,$hybrid_btree_wavelet_space_8,$hybrid_btree_wavelet_time_8,$hybrid_wavelet_wavelet_space_8,$hybrid_wavelet_wavelet_time_8,
            $hybrid_btree_rtree_space_9,$hybrid_btree_rtree_time_9,$hybrid_wavelet_rtree_space_9,$hybrid_wavelet_rtree_time_9,$hybrid_btree_rstartree_space_9,$hybrid_btree_rstartree_time_9,$hybrid_wavelet_rstartree_space_9,$hybrid_wavelet_rstartree_time_9,$hybrid_btree_wavelet_space_9,$hybrid_btree_wavelet_time_9,$hybrid_wavelet_wavelet_space_9,$hybrid_wavelet_wavelet_time_9,
            $hybrid_btree_rtree_space_10,$hybrid_btree_rtree_time_10,$hybrid_wavelet_rtree_space_10,$hybrid_wavelet_rtree_time_10,$hybrid_btree_rstartree_space_10,$hybrid_btree_rstartree_time_10,$hybrid_wavelet_rstartree_space_10,$hybrid_wavelet_rstartree_time_10,$hybrid_btree_wavelet_space_10,$hybrid_btree_wavelet_time_10,$hybrid_wavelet_wavelet_space_10,$hybrid_wavelet_wavelet_time_10,
            
            );
        return view("report")->with('settings',$settings)->with('result',$result);
    }
}
