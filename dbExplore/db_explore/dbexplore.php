<?PHP

	class dbExplore{

		public static $dbcnx = array ("","","","");
		public static $link;
		static $currentTables = array();
		static $colnames = array();
		static $record_qty = 0;
		

		public function check_updates(){

			if(isset($_POST['update'])
				&& isset($_POST['field'])
				&& isset($_POST['attribute'])
				&& isset($_POST['setting'])
				&& isset($_POST['table_selected'])){



				$update_query = "UPDATE ".$_POST['table_selected']." SET ".$_POST['field']." = '".$_POST['update']."' WHERE ".$_POST['attribute']." = '".$_POST['setting']."'";
				echo "<br>update query: ".$update_query."<br>";
				$mysql_connection = $this -> link;
				if($res = $mysql_connection -> query($update_query)){echo "<br>it worked<br>";}else{echo "it didnt work".mysqli_error($mysql_connection);}




			}



		}
		
		public function set_connection_data($ipaddr,$username,$pass,$dbname){


			$this -> dbcnx[0] = $ipaddr;
			$this -> dbcnx[1] = $username;
			$this -> dbcnx[2] = $pass;
			$this -> dbcnx[3] = $dbname;

			




		}
		
		public function connect(){

			 $conn = mysqli_connect($this -> dbcnx[0],$this -> dbcnx[1],$this -> dbcnx[2],$this -> dbcnx[3]);
			
			if($conn){ $this->link = $conn; echo"<br>link obtained<br>";}else{echo "<br>couldn't obtain link";}
		}

		public function show_tables($thelink){
			$tablesIndex = 0;
			$result = $thelink -> query("show tables");
			while($row = mysqli_fetch_row($result)){
				$this -> currentTables[$tablesIndex] = $row[0];
				echo "<form name = '".$row[0]."' value = 'active' method='POST' action = 'index.php'><input type = 'submit' name = 'table_selected' value = '".$row[0]."'></input></form>"; 
				$tablesIndex++; 
			}
		}

		public function describe_table($table, $thelink_two){
			echo "<table id = 'description' border = '1' >";
			echo "<tr style = 'color:#ff0000;'><td>field</td><td>type</td><td>null</td><td>key</td><td>default</td><td>extra</td></tr>";
						
			$items = array();
			$itemcount = 0;
			$result = $thelink_two -> query("describe ".$table);
			while($row = mysqli_fetch_row($result)){
				$items[$itemcount] = $row[0];
				echo "<tr class = 'datarow'>";
				for($i = 0; $i < sizeof($row); $i++){echo "<td>".$row[$i]."</td>";}
				echo "</tr>"; 
				$itemcount++;
			}
			echo "</table>";
			$this -> colnames[0] = $items;
		}

		public function show_all_records($table, $thelink_two){
			echo "<table id = 'all_records' border = '1' >";
			//echo "<tr style ='color:#ff0000;'><td>field</td><td>type</td><td>null</td><td>key</td><td>default</td><td>extra</td></tr>";
			$this -> record_qty = 0;
			$result = $thelink_two -> query("select * from ".$table." where 1");

			echo "<tr style = 'color:#ff0000'>";
			for($i = 0; $i < sizeof($this -> colnames[0]); $i++){echo "<td>".$this -> colnames[0][$i]."</td>";}
			echo "</tr>";	

			while($row = mysqli_fetch_assoc($result)){
				echo "<tr class = 'datarow'>";

				//intentionally incremented once before any data is stored so as to avoid overwriting the column names in colnames[0]
				$this -> record_qty++;

				for($j = 0; $j < sizeof($this -> colnames[0]); $j++){
					echo "<td>".$row[$this -> colnames[0][$j]]."</td>";
					$this -> colnames[$this -> record_qty][$j] = $row[$this -> colnames[0][$j]];
				}
				
				echo "</tr>"; 
			}
			echo "</table>";
		}	

		public function return_update_form(){

			$div_open = "<form 	name = 'updateform' 
								action = 'index.php' 
								method = 'POST' 
								>";
			$div_close = "</form>";
			$dropdown_one = "<select>";
			$attr_text = "<input type = 'text' name = 'attribute' ></input>";
			$setting_text = "<input type = 'text' name = 'setting' ></input>";
			$datatext = "<input type = 'text' name = 'update' ></input>";
			$submit = "<input type = 'submit' name = 'table_selected' value = '".$_POST['table_selected']."' >";
			$field_input = "<input type = 'text' name = 'field' ></input>";



			for($i = 0; $i < $this -> record_qty; $i++){$dropdown_one = $dropdown_one . "<option>".$i."</option>";}

			$dropdown_one = $dropdown_one."<select>";



			echo $div_open;
			//echo "items" . $dropdown_one;

			
			echo "UPDATE " . $_POST['table_selected'] . " SET ".$field_input." = ".$datatext;
			echo " WHERE ";
			echo $attr_text . " = " . $setting_text;
			echo $submit . $div_close;

			echo $div_close;






		}

	}
?>