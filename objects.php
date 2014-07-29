<?PHP

	class linkMaker{
		public function makeLinks($linkwords, $linkdata){
			echo '<a href= "'.$linkdata.'">'.$linkwords.'</a>';
		}


		public function makeImageLink($linkImage, $linkdata){

			$linkImage = '<img src = "includes/buttons/'.$linkImage.'">';
			echo '<a href= "'.$linkdata.'">'.$linkImage.'</a>';

		}


		public function onHoverImageLink($linkhImage, $hoverlinkimage, $linkhdata){

			$first = "<img src = '".$linkhImage."'" ;
			$onhov = "onmouseover = \"this.src = '".$hoverlinkimage."'\" onmouseout= \"this.src = '".$linkhImage."' \">";
			
			$fin = $first.$onhov;
			echo '<a href= "'.$linkhdata.'">'.$fin.'</a>';

		}

	}


	class form_factory{

		public function openForm($formName, $formAction, $formMethod){
			$inputs[0] = $formName;
			$inputs[1] = $formAction;
			$inputs[2] = $formMethod; 

			$form_pieces[0] = '<form type = "text/javascript" name = "';
			$form_pieces[1] = '" action = "';
			$form_pieces[2] = '" method = "';
			$form_pieces[3] = '">';	

			for($i = 0 ; $i<3; $i++){echo "".$form_pieces[$i].$inputs[$i];}
			echo $form_pieces[3];
		}


		public function insertInput($inputType, $inputName, $inputValue){
			$input_inputs[0] = $inputType;
			$input_inputs[1] = $inputName;
			$input_inputs[2] = $inputValue;
			$input_pieces[0] = '
								<input type = "';
			$input_pieces[1] = '"name ="';
			$input_pieces[2] = '"value ="';
			$echostan = "";
			for($i = 0; $i <3; $i++){ if($input_inputs[$i]!=NULL){$echostan = $echostan . $input_pieces[$i] . $input_inputs[$i];}}
			$echostan = $echostan . '">';
			echo $echostan."<br>";
		}






		public function closeForm(){
			echo "</form>";
		}

		public function insertSelect($select_name , $options){
			$select_open = '
			<select name ="'.$select_name.'"">';
			$select_close = '
			</select>';
			$option_array = '';
			$ticker = 0;

			foreach($options as $option){
				$tempstr = '<option value ="'.$option.'">'.$option.'</option>';
				$option_array[$ticker] = $tempstr;
				$ticker++;
			}

			echo $select_open;

			foreach($option_array as $output_option){echo "
				".$output_option;
			}
			echo $select_close."<br>";
		}
	}





	class divMaker{

	  	public function openDiv($name, $align, $style){

  			$opend = '<div name = "'.$name.'" align = "'.$align;

  			if($style){ $opend = $opend . '" style ="';
  				foreach($style as $styl){
  					$opend = $opend . $styl;
  					$opend = $opend .  "; ";
  				}
  			}
  			$opend = $opend . '">';
  			echo "".$opend;
  			//return $opend;
  		}


	  	public function closeDiv(){
  			$closed = "</div>";

  			echo "".$closed;
  			//return $closed;
  		}



	  	public function returnopenDiv($name, $align, $style){

  			$openderp = '<div name = "'.$name.'" align = "'.$align;

  			if($style){ $openderp = $openderp . '" style ="';
  				foreach($style as $styl){
  					$openderp = $openderp . $styl;
  					$openderp = $openderp .  "; ";
  				}
  			}
  			$openderp = $openderp . '">';
  			//file_put_contents("contents_of_openderp.txt", $openderp);
  			return $openderp;
  		}


	  	public function returncloseDiv(){
  			$closederp = "</div>";

  			//echo "".$closed;
  			//file_put_contents("contents_of_closedderp.txt", $closederp);
  			return $closederp;
  		}
	}






	class MySQL_OPERATOR{
		
		public $currentConnection;
		public $result_array;
		public $table_headers;
		public $currentTable;
		public $mysqlDiv;
		public function establish_connection($connectionData, $dbname){
			if($this -> currentConnection = mysql_connect($connectionData[0], $connectionData[1], $connectionData[2])){
				echo "it connected<br>";
				mysql_select_db($dbname, $this -> currentConnection);
				echo "database ". $dbname . " selected<br>"; 
			}else{echo "something didnt work while connecting<br>"; print_r($connectionData);}
		}



		public function insert_form_data($formNames){
			//$formNames = $this -> table_headers;
			$mysql_insert_1 = "INSERT INTO ";
			$mysql_insert_2 = "`".$_POST['last_table']."`";
			$mysql_insert_3 = " (";
			$mysql_column_list = " ";
			$securityConfirm = true;
			
			foreach($formNames as $formV){
				
					$formV = "`".$formV."`";
					$mysql_column_list = $mysql_column_list . $formV . ", ";
				
			}


			//why did I put in that -2?
			$mysql_column_list[(strlen($mysql_column_list)-2)] = " ";


			$mysql_insert_4 = ") VALUES ( ";
			$mysql_insert_list = "";
			$count_insert_list = 0;
			foreach($formNames as $formU){

				$temp = $_POST[$formU];

				
					$temp = " ".$temp."";
					$mysql_insert_list = $mysql_insert_list .$temp.",";
				

			}

			$mysql_insert_5 = ") ";

			$final_insert = $mysql_insert_1.$mysql_insert_2.$mysql_insert_3.$mysql_column_list.$mysql_insert_4.$mysql_insert_list.$mysql_insert_5;
			
			$final_insert[(strlen($final_insert) - 3)] = " ";

			$final_insert = $final_insert . " ";

			$queryStyle[0] = "color:#ff0000"; 
			$queryStyle[1] = "font-size:18px";
			$queryStyle[2] = "width:200px";
			$queryStyle[3] = "position:fixed";
			$queryStyle[4] = "bottom:200px";
			$queryStyle[5] = "right:12px";

			$mysqlDiv = new divMaker();
			$mysqlDiv -> openDiv("querydiv","left", $queryStyle);
			

			echo "FINAL INSERT: ".$final_insert;

			
			//if($securityConfirm){
				if(mysql_query($final_insert)){echo "<br>the query worked<br>";}else{echo "the query didnt work"; echo "<br>ERROR: ".mysql_error();}
			//}else{echo "<br> please only enter letters and numbers";}

			$mysqlDiv -> closeDiv();

		}

		public function echo_table($tablename){

			$debugData = new divMaker();
			$debugDataStyle[0] = "color:#ff0000"; 
			$debugDataStyle[1] = "font-size:18px";
			$debugDataStyle[2] = "width:200px";
			$debugDataStyle[3] = "position:fixed";
			$debugDataStyle[4] = "bottom:60px";
			$debugDataStyle[5] = "right:12px";

			$currentTable = $tablename;
			$mysql_query = "SELECT * FROM $tablename";
			if($query_result = mysql_query($mysql_query)){echo "<br> the query worked";}else{echo "the query didnt work"; echo "YOUR QUERY: ".$mysql_query;}
			//print_r($query_result);

			if(mysql_num_rows($query_result)>0){echo "<br>number of rows is greater than zero<br> "; }else{echo"<br>number of rows is not greater than zero";}
			$sort_counter = 0;
			$sort_counter_two = 0;

			if(mysql_num_rows($query_result)>0){
				foreach(mysql_fetch_array($query_result) as $key =>  $val){
					//echo "<br><br><br> KEY: ". $key . "<br> VALUE: " . $val . " <br>sort count: ". $sort_counter;
					if(($sort_counter%2) != 0){$table_headers[$sort_counter_two] = $key; $sort_counter_two++;}
					$sort_counter++;
				}

			

			mysql_free_result($query_result);
			if(isset($_POST['generated_submit'])){$this -> insert_form_data($table_headers);}
			$query_res = mysql_query($mysql_query);

			echo '
			<table border = "1"><tr>';
			foreach($table_headers as $header){
				echo "
				<td>". $header . "</td>";
			}



			while($row = mysql_fetch_array($query_res)){
				//print_r($row);
				$headcount = 0;
				echo "<tr>";
				//echo "<br> size of table headers: ".sizeof($table_headers) . "<br>";
				//echo " <br>HEAD COUNT: ".$headcount;
				while($headcount<sizeof($table_headers)){
					//$field_types[$headcount] = mysql_field_type($row[$headcount] , $headcount);
					echo "<td>";
					echo $row[$table_headers[$headcount]];
					echo "</td>";
					$headcount++;
				}
				echo "</tr>";
			}
			echo "</table>";






			mysql_free_result($query_res);

		}
			if(isset($table_headers)){
				$this -> table_headers = $table_headers;
				$this -> generateForms($table_headers);
			}

			$debugData -> openDiv("debugDiv2" ,"right", $debugDataStyle);
			echo "<br>current connection: ".$this -> currentConnection;
			mysql_close($this -> currentConnection);
			echo "<br>connection closed";
			$debugData -> closeDiv();

		}
 

		public function checkInput($inputString){
						if(strlen($inputString)>=0 &&$inputString[0]!= "\'"){
				echo "<br>INPUT STRING: ".$inputString[0]; 
					return true;
				}else{

					if(strlen($inputString) == 0){return true;}
					else{echo "<br>wtf are you doing stop entering unsanitary data";return false;}
				}
		}

		public function generateForms($column_names){
			$formData = new formDataStore;
			$maintain_connection;
			if(isset($_POST['select_one'])){
				$maintain_connection = $_POST['select_one'];
			}else{
				if(isset($_POST['last_table'])){
					$maintain_connection = $_POST['last_table'];
				}else{echo "ERROR WITH POST DATA: <br>".print_r($_POST);}
			}
			$formGen = new form_factory();

			$formGen -> openForm("generic_table_form", "index.php", "POST");

			$i = 0;
			foreach($column_names as  $v){
				$formGen -> insertInput($formData -> jobs[$i] , "$v", NULL);
				$i++;
			}

			
			$formGen -> insertInput("submit" , "generated_submit" , "Submit");
			$formGen -> insertInput("hidden" , "last_table", $maintain_connection);
			$formGen -> closeForm();


		}







	}




 class formDataStore{
 	public $jobs = array("number" , "date" , "number");
 	public $expenses = array("number", "date", "number", "textArea");
 }







?>