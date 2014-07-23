<?PHP


include "includes/header.php";
include "includes/dbexplore.php";

echo $backbutton;

$explorer = new dbExplore();
if(strlen($IP)>0){
$explorer -> set_connection_data($IP,$USR,$PW,$DB);
$explorer -> connect();}else{die("<div style='font-size:18px; color:ff6666;'>Could not connect, please see your /includes/db_cfg file</div>");}

if(isset($_POST['table_selected'])){
echo "<div style = 'font-size:10px;'>";
echo "Current Table: ".$_POST['table_selected'];
echo "</div>";}


include "includes/footer.php";
?>