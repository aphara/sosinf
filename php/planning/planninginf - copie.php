<?

//require_once("includes/connect.php");
//require_once ('includes/grab_globals.lib.php');
/*
if (isset($_POST["submitjojf"]))
{
	foreach($_POST as $key => $val)
	{
		if (!(strpos($key, "day_") === FALSE))
		{
			$day = split("_", $key);
			$query = "INSERT INTO day2time_slice set day = '".date("Y-m-d", $day[1])."',soc_id = ".$_SESSION["labase"].", JO='$val' ON DUPLICATE KEY UPDATE JO='$val'";
			mysql_query($query, $link); 
		}
		
	}
}
*/
if (!isset($year_offset) || !isset($month_offset))
{
	$year_offset = date("Y");
	$month_offset = date("m");
}
//Dernier jour du mois + fin de la semaine en cours
$nextmonth_firstendofweek =
	strtotime("monday" , strtotime("+1 month", mktime(0,0,0,$month_offset,1,$year_offset)));
$year_offset_end  = date("Y", $nextmonth_firstendofweek);
$month_offset_end = date("m", $nextmonth_firstendofweek); 
$day_offset_end   = date("d", $nextmonth_firstendofweek);

//calcul du nombre de jour pour afficher les colonnes du tableau HTML

define ('DATE_ENUM_DAY', 1);
/*
 * enumerate a date and call a user function
 * dateBeginTS, dateEndTS : Timestamp date
 * callbackfunc : name of the php function to callback
 *  this cb function receive 2 parameters : the current enumerated date (timestamp) and the $param parameter
 * step : DATE_ENUM_DAY or DATE_ENUM_MONTH
 * param : a user parameter
 */
function date_enumeration($dateBeginTS, $dateEndTS, $step, &$store_array)
{
   $cur = $dateBeginTS;
   while($cur <= $dateEndTS)
   {
	   $store_array[] = $cur;
	   if ($step == DATE_ENUM_DAY)
	   {
		   $cur = mktime(
			   date('h', $cur),
			   date('i', $cur),
			   date('s', $cur),
			   date('m', $cur),
			   date('d', $cur) + 1,
			   date('Y', $cur));
	   }
	   else if ($step == DATE_ENUM_MONTH)
	   {
		   $cur = mktime(
			   date('h', $cur),
			   date('i', $cur),
			   date('s', $cur),
			   date('m', $cur) + 1,
			   date('d', $cur),
			   date('Y', $cur));
	   }
	   else
	   {
		   die ('No step specified');
	   }
   }
}


date_enumeration(mktime(12,0,0,$month_offset,1,$year_offset), mktime(12,0,0,$month_offset_end,$day_offset_end,$year_offset_end),DATE_ENUM_DAY,$planning_days);
date_enumeration(mktime(12,0,0,$month_offset,1,$year_offset), mktime(12,0,0,$month_offset_end,$day_offset_end,$year_offset_end),DATE_ENUM_MONTH,$planning_months);


$nbdays = sizeof($planning_days);


end($planning_days);
if (date("j",current($planning_days)) > 7)
	$nbdays_mainmonth = key($planning_days);
else
{
	while (date("j",current($planning_days))<7)
		prev($planning_days);
	$nbdays_mainmonth = key($planning_days);
}
$nb_day_per_month = Array($nbdays_mainmonth+1, ($nbdays-$nbdays_mainmonth-1));
//print_r($nb_day_per_month);
$nbmonths = sizeof($planning_months);
//echo $nbdays ;
//echo $nbmonths ;
//FIN!!!!!!

//echo "$year_offset-$month_offset-01 et $year_offset_end-$month_offset_end-$day_offset_end";



$query = "SELECT idp, jourdeb, jourfin, ts_mode, zone, infirmier, planning.referent, inf_id as idi, inf_nom as nom, inf_prenom as prenom, inf_planning_color as planning_color, ordre from infirmiers, planning LEFT JOIN zone ON idz=zone
			where ((jourdeb>='$year_offset-$month_offset-01' and jourdeb<'$year_offset_end-$month_offset_end-$day_offset_end') or 
				  (jourfin<'$year_offset_end-$month_offset_end-$day_offset_end' and jourfin>='$year_offset-$month_offset-01')) and
				  inf_id=infirmier and idz=zone
			order by ordre, jourdeb";
//echo $query;
$res_planning = mysql_query($query,$link) or die("Erreur SQL : $query<br/>".mysql_error());;



$mois = array("Janvier", "F&eacute;vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Ao&ucirc;t", "Septembre", "Octobre", "Novembre", "D&eacute;cembre");	
$jours = array("L", "M", "M", "J", "V", "S", "D");

$color = "#FFFFFF";
function change_color($color)
{
	global $color;
	if ($color == "#DDDDDD")
		$color = "#FFFFFF";
		else
		$color = "#DDDDDD";
}

function get_ts_from_mysqlformat($in)
{
	$day 	= substr($in,8,2);
	$month 	= substr($in,5,2);
	$year 	= substr($in,0,4);
	return mktime(12,0,0,$month,$day,$year);
}

function get_event_nb_days($idp)
{
	global $row_planning,$year_offset,$month_offset;
	$start_date = get_ts_from_mysqlformat($row_planning["jourdeb"]);
	$first_day_in_month = mktime(12,0,0,$month_offset,1,$year_offset);
	//echo " $first_day_in_month et $start_date";
	if ($start_date<$first_day_in_month) $start_date = $first_day_in_month;
	$stop_date = get_ts_from_mysqlformat($row_planning["jourfin"]);
	//echo round(($stop_date - $start_date)/(3600*24),1);
	//echo "start : $start_date and stop : $stop_date<br>";
	return round(($stop_date - $start_date)/(3600*24),1);

}
	
	
	//Affichage de l'entête du tableau
?>

<HEAD>
<script language=Javascript>
var newwindow;
function addformwindow(idzone,jour)
{
<?
if ($visuonly != 1)
{
?>
	newwindow=window.open('addevent.php?base=<?php echo $_SESSION["labase"]; ?>&zone=' + idzone + '&date=' + jour,'newWin','toolbar=no, scrollbars=yes, width=300, height=450');
	newwindow.focus();
<?
}
?>
}

function modformwindow(id)
{
<?
if ($visuonly != 1)
{
?>
	newwindow=window.open('modevent.php?base=<?php echo $_SESSION["labase"]; ?>&id=' + id,'newWin','toolbar=no, scrollbars=yes, width=300, height=450');
	newwindow.focus();
<?
}
?>
}

function send_date()
{
	document.location.href='?page=<?echo $page?>&month_offset=' +
			document.form1.month_offset.options[document.form1.month_offset.selectedIndex].value +
			'&year_offset=' +
			document.form1.year_offset.options[document.form1.year_offset.selectedIndex].value;
}

</script>
</head>
<form method=POST name=form1>
<table style="border:1px solid black"><tr ><td width=50px><nobr>Acc&eacute;der &agrave; une date</nobr>
<center>
<select name=year_offset onchange="send_date()">
<?
echo "<option value=".($year_offset-1).">".($year_offset-1)."</option>";
echo "<option value=$year_offset selected>$year_offset</option>";
echo "<option value=".($year_offset+1).">".($year_offset+1)."</option>";
?>
</select>
</center>
</td>
<?
for($i=0;$i<$nbmonths;$i++)
{
	echo "<td colspan=".$nb_day_per_month[$i]." style=\"border-left:1px solid black; border-bottom:1px solid black\" align=center><font color=black><b>".
		 $mois[date("n",$planning_months[$i])-1]."</b></font></td>";
}
?>
</tr><tr>
<td>
<center>
<a href=# onclick="document.form1.month_offset.value='<?echo ($month_offset-1);?>'; send_date();"><</a>
<select name=month_offset onchange="send_date()">
<?
echo "<option value=".($month_offset-1).">".(($month_offset-1<10)?"0":"").($month_offset-1)."</option>";
echo "<option value=".($month_offset)." selected>".(($month_offset<10)?"0":"").($month_offset+0)."</option>";
echo "<option value=".($month_offset+1).">".(($month_offset+1<10)?"0":"").($month_offset+1)."</option>";
?>
</select>
<a href=# onclick="document.form1.month_offset.value='<?echo ($month_offset+1);?>'; send_date();">></a>
</center>
</td>
<?

	
if (isset($_POST["submitjojf"]))
{
  for($i=0;$i<$nbdays;$i++)
  {
//			$query = "INSERT INTO day2time_slice set day = '".date("Y-m-d", $planning_days[$i])."',soc_id = ".$_SESSION["labase"].", JO='0' ON DUPLICATE KEY UPDATE JO='0'";
			$query = "DELETE FROM day2time_slice WHERE day = '".date("Y-m-d", $planning_days[$i])."' AND soc_id = ".$_SESSION["labase"];
			mysql_query($query, $link); 
  }


	foreach($_POST as $key => $val)
	{
		if (!(strpos($key, "day_") === FALSE))
		{
			$day = split("_", $key);
			$query = "INSERT INTO day2time_slice set day = '".date("Y-m-d", $day[1])."',soc_id = ".$_SESSION["labase"].", JO='$val' ON DUPLICATE KEY UPDATE JO='$val'";
			mysql_query($query, $link); 
		}
		
	}
}


for($i=0;$i<$nbdays;$i++)
{

	$dayofweek = date("w",$planning_days[$i]);
	if ($dayofweek == 0) $dayofweek = 7;
	if ($dayofweek == 1) change_color($color);
	$checked = ((@mysql_result(@mysql_query("SELECT * from day2time_slice where soc_id = ".$_SESSION["labase"]." AND day = '".date("Y-m-d", $planning_days[$i])."'"),0,"JO") == 'on')?" checked":"");
	echo "<td align=center width=20px bgcolor=$color style=\"border-left:1px solid black\">&nbsp;&nbsp;".$jours[$dayofweek-1]."&nbsp;&nbsp;<br><font color=black>".date("j",$planning_days[$i])."</font><br><input type=checkbox name=day_".$planning_days[$i]." $checked></td>";
	
}
?> <td><input type=submit name=submitjojf value="Valider JO/JF"></td></tr>
<?
//on récupère les zones et leur descriptif

//count($result);

//echo "nombre d'evenements : ".(mysql_num_rows($res_planning));
echo "nombre d'evenements : ".(count($res_planning));
//on prend le premier résultat de $res_planning et on le case dès que possible
//$row_planning = mysql_fetch_array($res_planning);

$query = "SELECT * from zone WHERE soc_id = ".$_SESSION["labase"]." order by ordre";
$res_zones = mysql_query($query,$link);


$queryPlanningInf = "SELECT idp, jourdeb, jourfin, ts_mode, zone, infirmier, planning.referent, inf_id as idi, inf_nom as nom, inf_prenom as prenom, inf_planning_color as planning_color, ordre from infirmiers, planning LEFT JOIN zone ON idz=zone
			where ((jourdeb>='$year_offset-$month_offset-01' and jourdeb<'$year_offset_end-$month_offset_end-$day_offset_end') or 
				  (jourfin<'$year_offset_end-$month_offset_end-$day_offset_end' and jourfin>='$year_offset-$month_offset-01')) and
				  inf_id=infirmier and idz=zone
			order by ordre, jourdeb";
//echo $queryPlanningInf;
//mysql_fetch_array()

//echo "<br>nbday:".$nbdays;

$monTabTMP = array();
$res_planning2 = mysql_query($queryPlanningInf,$link) or die("Erreur SQL : $queryPlanningInf<br/>".mysql_error());
while ($row_planning = mysql_fetch_array($res_planning2))
{
  $monTabTMP[] = $row_planning;
}
//print_r($monTabTMP);
//echo count($monTabTMP);
//
// ci-dessous debugage en 2 2
//
$row_planning=array();
while ($row = mysql_fetch_array($res_zones))
{
	if ($zone_color_free == "#EEEEEE")
			$zone_color_free = "#CCCCCC"; else $zone_color_free = "#EEEEEE";
	echo "<tr><td style=\"border-top:0px solid black\" ".(($row["referent"]==1)?"bgcolor=red":"bgcolor=$zone_color_free")."><font color=black>".$row["libelle"]."</font></td>";
	
	
	for($i=0;$i<$nbdays;$i++)
	{
		//$event_nb_days = get_event_nb_days($row_planning["idp"])+1;
		 //echo $row_planning["zone"]." -- ".$row["idz"]."<br>";

      //$res_planning = mysql_query($queryPlanningInf,$link) or die("Erreur SQL : $queryPlanningInf<br/>".mysql_error());;
      $founded=false;
    //  $tmpvar=array();
      //$res_planning_tmp = $res_planning2;
    //  $res_planning2 = mysql_query($queryPlanningInf,$link) or die("Erreur SQL : $queryPlanningInf<br/>".mysql_error());
	//	if ($row["idz"] == 8)
		//{
      for ($j=0;$j<count($monTabTMP);$j++)
      {
      //echo $monTabTMP[$j]["zone"];

    //  if ($monTabTMP[$j]["zone"]==8) {
      		if (($monTabTMP[$j]["zone"] == $row["idz"]) && (get_ts_from_mysqlformat($monTabTMP[$j]["jourdeb"]) <= $planning_days[$i]) &&
      			 (get_ts_from_mysqlformat($monTabTMP[$j]["jourfin"]) >= $planning_days[$i])){
              $row_planning = $monTabTMP[$j];
             // echo $row_planning["prenom"];
              $founded=true;
              $event_nb_days = get_event_nb_days($row_planning["idp"])+1;
              //echo $event_nb_days;
            
            
              break;
             }
      
      
      //echo get_ts_from_mysqlformat($monTabTMP[$j]["jourdeb"]);
    //  }
		/*
        if ($founded==false)
        {
		     // $row_planning = $monTabTMP[$j];
      		if ($monTabTMP[$j]["zone"] == $row["idz"] &&
      		  get_ts_from_mysqlformat($monTabTMP[$j]["jourdeb"]) <= $planning_days[$i] &&
      			get_ts_from_mysqlformat($monTabTMP[$j]["jourfin"]) >= $planning_days[$i])
      		{
      		  $founded=true;
      		  $row_planning = $monTabTMP[$j];
      	//	  $tmpvar=$row_planning;
      		}
        }  
  
*/
   		}
  //  }
    
    //}  	
    if ($founded==true)
		/*
    if ($row_planning["zone"] == $row["idz"] &&
		  get_ts_from_mysqlformat($row_planning["jourdeb"]) <= $planning_days[$i] &&
			get_ts_from_mysqlformat($row_planning["jourfin"]) >= $planning_days[$i])
			*/
		{
		 // $row_planning = $tmpvar;
			echo "\n<td align=center colspan=$event_nb_days
					    bgcolor=".$row_planning["planning_color"]." width=25px 
						style=\"cursor:pointer\"
						onclick=\"modformwindow(".$row_planning["idp"].");\"><font color=black>".
						(($event_nb_days>1)?(($event_nb_days>2)?$row_planning["nom"]:substr($row_planning["nom"],0,5)):substr($row_planning["nom"],0,3)).
						(($row_planning["nom"]=="Stand" && $row_planning["prenom"]=="ard")?"":" ").
						(($event_nb_days>5)?$row_planning["prenom"]:"").
						"</font></td>";
			$i+=($event_nb_days-1);
		}
		else			
		echo "<td align=center bgcolor=$zone_color_free width=25px onclick=\"addformwindow(".$row["idz"].", ".$planning_days[$i].");\"></td>";
		//Est-ce qu'on prend le résultat suivant de $res_planning?
		//echo  $planning_days[$nbdays-1];
		//if ($row_planning["zone"] == "3") echo get_ts_from_mysqlformat($row_planning["jourfin"])." et ".$planning_days[$i]. " && " .($i+1)." et ".$nbdays." && ".get_ts_from_mysqlformat($row_planning["jourfin"])." et ".$planning_days[$nbdays-1]."<br><br>";

//		if ($row_planning["zone"] == $row["idz"] &&
	//		(get_ts_from_mysqlformat($row_planning["jourfin"]) <= $planning_days[$i] ||
		//	 (/*($i+1)==$nbdays &&*/ get_ts_from_mysqlformat($row_planning["jourfin"]) >= $planning_days[$nbdays-1])))
	//	{
	/*
		if ($row_planning["zone"] == $row["idz"] &&
		  get_ts_from_mysqlformat($row_planning["jourdeb"]) <= $planning_days[$i] &&
			get_ts_from_mysqlformat($row_planning["jourfin"]) >= $planning_days[$i])
		{
    
    	
			$row_planning = mysql_fetch_array($res_planning);
			//echo "On passe au suivant : ".$row_planning["jourfin"]." et zone : ".$row_planning['zone']."<br>";
		}*/
	}
	echo "</tr>";


}
//print_r($planning_days);
?>
</table>
</form>
</body>
</html>
