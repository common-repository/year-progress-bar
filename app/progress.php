<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
		$tm = strtotime("tomorrow");	
		$T = exec('time /T');
		$ct = strtotime ($T);
		$pt = $tm - $ct;
		$rt = ($pt/86400)*100;
		$r = 100 - $rt;
		?>
		
		<?php 
		$year = date("Y");
		if (!function_exists('YPBP_cal_days_in_year'))
			{
		 function YPBP_cal_days_in_year($year){
			$days=0; 
			for($month=1;$month<=12;$month++){ 
				$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$year);
			 }
		 return $days;
		}}
		$DaysNow = date("z")+1;
		$DaysYear = YPBP_cal_days_in_year($year);
		$tmpd = ($DaysYear - $DaysNow);
		$tfdp = ($tmpd/$DaysYear)*100;
		$py = 100 - $tfdp;
		?>

		<?php
		$cd = date("d");
		$days = date("t");
		$pm = 100 - (($days - $cd)/$days)*100;
		?>