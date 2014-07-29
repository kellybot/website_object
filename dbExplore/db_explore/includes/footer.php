<?PHP



if(!isset($_POST["table_selected"])){
	
	$explorer -> show_tables($explorer->link);

}else{

	$explorer -> check_updates();

	echo "<sm>";

	
	echo "<br>";

	echo "<br></sm><div id='updatediv_two'>Description of ".$_POST['table_selected'];
	echo $backbutton;
	echo "<div id = 'scroller_div'>";
	$explorer -> describe_table($_POST["table_selected"], $explorer->link);
	echo "<br></div></div><div id = 'all_records_div'>";
	$explorer -> show_all_records($_POST["table_selected"], $explorer->link);
	echo "</div><br></sm>";

	for($i = 0; $i < 30; $i++){echo "<br>";}

	echo "<div id = 'updatediv'>";
	
	$explorer -> return_update_form();

	echo "</div><br><br><br><br><br><br>";
}

echo $closing_html;








?>