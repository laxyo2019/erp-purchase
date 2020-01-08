<?php 
	namespace App\Helpers;
	use Session;
	use DB;

	class Helper
	{
	    public static function diffForHumans($date)
	    {
	        return \Carbon\Carbon::parse($date)->diffForHumans();
	    }

	    public static function emptyCart($type)
	    {
	    		//session()->flash($type);
	    		Session::forget($type);
	    }
	    public static function getAutoIncrementId()
	    {
	    		$db = DB::connection()->getDatabaseName();
        	$getAutoIncrementId = DB::select(DB::raw("SELECT auto_increment FROM INFORMATION_SCHEMA.TABLES WHERE table_name = 'items' and TABLE_SCHEMA = '".$db."'"));
        	return $getAutoIncrementId[0]->auto_increment;
        	//print_r($id); die;
	    }
	}