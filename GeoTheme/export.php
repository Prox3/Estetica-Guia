<?php 
######################################
#########  EXPORT SCRIPT #############
######################################
function _valToCsvHelper($val, $separator, $trimFunction) {
			if ($trimFunction) $val = $trimFunction($val);
			//If there is a separator (;) or a quote (") or a linebreak in the string, we need to quote it.
			$needQuote = FALSE;
			do {
				if (strpos($val, '"') !== FALSE) {
					$val = str_replace('"', '""', $val);
					$needQuote = TRUE;
					break;
				}
				if (strpos($val, $separator) !== FALSE) {
					$needQuote = TRUE;
					//$val = str_replace(",", "-", $val); // stop excel fucking with my shit. // still fuckng with my shit....
					break;
				}
				if ((strpos($val, "\n") !== FALSE) || (strpos($val, "\r") !== FALSE)) { // \r is for mac
					$needQuote = TRUE;
					break;
				}
			} 
			while (FALSE);
			if ($needQuote) {
				$val = '"' . $val . '"';
			}
			return $val;
		}
function arrayToCsvString($array, $separator=';', $trim='both', $removeEmptyLines=TRUE) {
			if (!is_array($array) || empty($array)) return '';
			switch ($trim) {
				case 'none':
					$trimFunction = FALSE;
					break;
				case 'left':
					$trimFunction = 'ltrim';
					break;
				case 'right':
					$trimFunction = 'rtrim';
					break;
				default: //'both':
					$trimFunction = 'trim';
				break;
			}
			$ret = array();
			reset($array);
			if (is_array(current($array))) {
				while (list(,$lineArr) = each($array)) {
					if (!is_array($lineArr)) {
						//Could issue a warning ...
						$ret[] = array();
					} else {
						$subArr = array();
						while (list(,$val) = each($lineArr)) {
							$val      = _valToCsvHelper($val, $separator, $trimFunction);
							$subArr[] = $val;
						}
					}
					$ret[] = join($separator, $subArr);
				}
				$crlf = _define_newline();
				return join($crlf, $ret);
			} else {
				while (list(,$val) = each($array)) {
					$val   = _valToCsvHelper($val, $separator, $trimFunction);
					$ret[] = $val;
				}
				return join($separator, $ret);
			}
		}
		
function _define_newline() {
			$unewline = "\r\n";
			if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'win')) {
			   $unewline = "\r\n";
			} else if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'mac')) {
			   $unewline = "\r";
			} else {
			   $unewline = "\n";
			}
			return $unewline;
		}
		
function createcsv($table = 'city', $sep) {
			global $wpdb,$multicountry_db_table_name,$multiregion_db_table_name,$multicity_db_table_name,$multihood_db_table_name;
			// Get the columns and create the first row of the CSV
			
			switch($table) {
				case 'city':
					$fields = array('city_id','cityname','city_slug','lat','lng','scall_factor','sortorder','is_zoom_home','categories','is_default','cat_ex','home_desc','meta_desc');
					break;
				case 'country':
					$fields = array('country_id','countryname','country_slug','lat','lng','scall_factor','sortorder','is_zoom_home','categories','cities','regions','is_default','cat_ex','home_desc','meta_desc');
					break;
				case 'region':
					$fields = array('region_id','regionname','region_slug','lat','lng','scall_factor','sortorder','is_zoom_home','categories','cities','is_default','cat_ex','home_desc','meta_desc');
					break;
				case 'hoods':
					$fields = array('hood_id','hoodname','hood_slug','lat','lng','scall_factor','sortorder','is_zoom_home','categories','cities','is_default','cat_ex','home_desc','meta_desc');
					break;
			}
			$csv = arrayToCsvString($fields, $sep);
			$csv .= _define_newline();

			// Query the entire contents from the Users table and put it into the CSV
			switch($table) {
				case 'city':
					$query = "SELECT city_id,cityname,city_slug,lat,lng,scall_factor,sortorder,is_zoom_home,categories,is_default,cat_ex,home_desc,meta_desc FROM $multicity_db_table_name";
					break;
				case 'country':
					$query = "SELECT country_id,countryname,country_slug,lat,lng,scall_factor,sortorder,is_zoom_home,categories,cities,regions,is_default,cat_ex,home_desc,meta_desc FROM $multicountry_db_table_name";
					break;
				case 'region':
					$query = "SELECT region_id,regionname,region_slug,lat,lng,scall_factor,sortorder,is_zoom_home,categories,cities,is_default,cat_ex,home_desc,meta_desc FROM $multiregion_db_table_name";
					break;
				case 'hoods':
					$query = "SELECT hood_id,hoodname,hood_slug,lat,lng,scall_factor,sortorder,is_zoom_home,categories,cities,is_default,cat_ex,home_desc,meta_desc FROM $multihood_db_table_name";
					break;
			}
			$results = $wpdb->get_results($query,ARRAY_A);
			$i=0;
			$csv .= arrayToCsvString($results, $sep);

			$now = gmdate('D, d M Y H:i:s') . ' GMT';

			header('Content-Type: application/octetstream');
			header('Expires: ' . $now);

			header('Content-Disposition: attachment; filename="'.$table.'.csv"');
			header('Pragma: no-cache');

			echo $csv;
		}
		
		
if($_REQUEST['export']=='city'){createcsv('city', ",");exit;}		
if($_REQUEST['export']=='country'){createcsv('country', ",");exit;}		
if($_REQUEST['export']=='region'){createcsv('region', ",");exit;}		
if($_REQUEST['export']=='hoods'){createcsv('hoods', ",");exit;}		
?>