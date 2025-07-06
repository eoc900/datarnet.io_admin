<?php
namespace App\Helpers;

class Filter{

    static public function runQuerySingleParam($request,$object,$execQueries,$defaultQuery){
        /* 
            It is a single param as we only use $searchFor as query parameter
            $execQueries takes an input like this
            ["FilterName"=>"QueryName"]
        */
        $searchFor = "";
        $page = 1;
        $filter = "";

        if($request->search != "" && $request->search != null && isset($request->search)){
            $searchFor = $cleanedString = filter_var($request->search, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        }
        if($request->page != "" && $request->page != null && isset($request->page)){
            $page = $request->page;
        }
        if($request->filter != "" && $request->filter != null && isset($request->filter)){
            $filter = preg_replace("/[^a-zA-Z0-9]/", "", $request->filter);
        }
        foreach ($execQueries as $key => $value) {
            if($filter!=preg_replace("/[^a-zA-Z0-9]/", "",$key)){
                continue;
            }
            if(method_exists($object, $value)){
                return call_user_func_array([$object, $value], [$searchFor]);
            }
        }
        
        if(method_exists($object, $defaultQuery)){
                return call_user_func_array([$object, $defaultQuery], [$searchFor]);
        }

        

        return false;

    }


    static public function cleanSearchParams($request){
        $searchFor = "";
        $page = 1;
        $filter = "";

        if($request->search != "" && $request->search != null && isset($request->search)){
            $searchFor = $cleanedString = filter_var($request->search, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        }
        if($request->page != "" && $request->page != null && isset($request->page)){
            $page = filter_var($request->page, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        }
        if($request->filter != "" && $request->filter != null && isset($request->filter)){
            $filter = preg_replace("/[^a-zA-Z0-9]/", "", $request->filter);
        }

        return array("search"=>$searchFor,"page"=>$page,"filter"=>$filter);
    }



}



?>