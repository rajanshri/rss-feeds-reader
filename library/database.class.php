<?php



class database  {

	

	function getNumberDisplayAll($table_name, $where = null) {



        $sql = "SELECT COUNT(*) AS `count_all` FROM ".$table_name." ".$where;

        $sql_run = mysql_query($sql);

        $arr = mysql_fetch_array($sql_run);

        return $arr['count_all'];



    }

    

    function getColumnValue($table_name, $column_name, $where = null) {



        $sql = "SELECT  $column_name as `column`  FROM ".$table_name." ".$where;

        $sql_run = mysql_query($sql);

        $arr = mysql_fetch_array($sql_run);         

        return $arr['column'];		

    }



    function getNumberofRow($table_name, $column_name, $where = null) {



        $sql = "SELECT  $column_name as `column`  FROM ".$table_name." ".$where;

        $sql_run = mysql_query($sql);

        $arr = mysql_num_rows($sql_run);

        return $arr;



    }



    function numberofRow($table_name, $field, $where) {



        $sql_del_data = "SELECT `".$field."` FROM `".$table_name."`".$where;

        $sql_del_data_run = mysql_query($sql_del_data);

        $numberofrow=mysql_num_rows($sql_del_data_run);

        return $numberofrow;



    }



    function getDistinctNumberDisplayAll($table_name, $column_name, $where = null) {



        $sql = "SELECT COUNT(DISTINCT $column_name) AS `count_all` FROM ".$table_name." ".$where;

        $sql_run = mysql_query($sql);

        $arr = mysql_fetch_array($sql_run);

        return $arr['count_all'];



    }

    

    function getSumColumnValue($table_name, $column_name, $where = null) {



        $sql = "SELECT sum($column_name) AS `sum_column` FROM ".$table_name." ".$where;

        $sql_run = mysql_query($sql);

        $arr = mysql_fetch_array($sql_run);

        return $arr['sum_column'];



    }



    function getDistinctRowDisplayAll($table_name, $column_name, $where = null) {



        $sql = "SELECT DISTINCT $column_name AS `count_all`  FROM ".$table_name." ".$where;

        $sql_run = mysql_query($sql);



        $rid=array();

        $i=0;

        while($arr=mysql_fetch_array($sql_run)) {



            $rid[$i]=$arr;

            $i++;



        }

        //print_r($rid);

        return $rid;



    }

	

	  public function countSpecificRecords($table_name, $where=null){





        $sql = "SELECT COUNT(*) AS `count_all` FROM `".$table_name."` ".$where;

        $sql_run = mysql_query($sql) or die(mysql_error());



        $arr = mysql_fetch_array($sql_run);

        return $arr['count_all'];

    }



    function getDisplayAll($table_name, $fields, $where=null, $limit_from, $total_row_display, $sort, $order) {



        if(is_array($fields)) {

            $select_fields = implode($fields,', ');

        }else {

            $select_fields = ' * ';

        }



      $sql = "SELECT ".$select_fields." FROM `".$table_name."` ".$where." ORDER BY `".$sort."` ". $order." LIMIT ".$limit_from.", ".$total_row_display;

        

        $sql_run = mysql_query($sql) or die(mysql_error());

		$i=0;

        $arrayData = array ();

                

        while($row = mysql_fetch_array($sql_run)) {

			$arrayData[$i] = $row;

            $i++;



        }

        //print_r($arrayData);

        return $arrayData;

    }



 function getDisplayAllWithGroupBy($table_name, $fields, $where=null, $group_by, $limit_from=null, $total_row_display=null, $sort, $order) {



        if(is_array($fields)) {

            $select_fields = implode($fields,', ');

        }else {

            $select_fields = ' * ';

        }



        $sql = "SELECT ".$select_fields." FROM `".$table_name."` ".$where." GROUP BY  `".$group_by."` ORDER BY `".$sort."` ". $order." LIMIT ".$limit_from.", ".$total_row_display;

        

        $sql_run = mysql_query($sql) or die(mysql_error());

		$i=0;

        $arrayData = array ();

                

        while($row = mysql_fetch_array($sql_run)) {

			$arrayData[$i] = $row;

            $i++;



        }

        //print_r($arrayData);

        return $arrayData;

    }

    

    

    function getDisplayAllWithoutLimit($table_name, $fields, $sort, $order, $where=null) {



        if(is_array($fields)) {

            $select_fields = implode($fields,', ');

        }else {

            $select_fields = ' * ';

        }



    	$sql = "SELECT ".$select_fields." FROM `".$table_name."` ".$where." ORDER BY `".$sort."` ". $order;

        $sql_run = mysql_query($sql);



        $i=0;

        $arrayData = array ();



        while($row = mysql_fetch_array($sql_run)) {



            $arrayData[$i] = $row;

            $i++;



        }

        return $arrayData;

    }



    public function getDisplayAllInnerJoin($main_table_name, $fields, $join , $limit_from, $total_row_display, $sort, $order, $where = null) {





        //$alias = explode("AS", $main_table_name);



        if(is_array($fields )) {



            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            //$join_str .= ' INNER JOIN '.implode($inner_array, ' ON ');

            $join_str .= ' INNER JOIN  '.$inner_array[0].' ON '.$inner_array[1];

            if(count($inner_array) > 2) {

                for($i=2;$i<count($inner_array);$i++) {

                    $join_str .= ' AND '.$inner_array[$i];

                }

            }

        }



        $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where." ORDER BY ".$sort." ". $order." LIMIT ".$limit_from.", ".$total_row_display;

        $sql_run = mysql_query($sql);



        $i=0;

        $arrayData = array ();



        while($row=mysql_fetch_array($sql_run)) {



            $arrayData[$i] = $row;



            $i++;

        }

        return $arrayData;

    }

	

	public function getDisplayAllInnerJoinWithoutSortOrder($main_table_name, $fields, $join , $limit_from, $total_row_display, $where = null) {





        //$alias = explode("AS", $main_table_name);



        if(is_array($fields )) {



            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            //$join_str .= ' INNER JOIN '.implode($inner_array, ' ON ');

            $join_str .= ' INNER JOIN  '.$inner_array[0].' ON '.$inner_array[1];

            if(count($inner_array) > 2) {

                for($i=2;$i<count($inner_array);$i++) {

                    $join_str .= ' AND '.$inner_array[$i];

                }

            }

        }



        $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where." LIMIT ".$limit_from.", ".$total_row_display;

        $sql_run = mysql_query($sql);



        $i=0;

        $arrayData = array ();



        while($row=mysql_fetch_array($sql_run)) {



            $arrayData[$i] = $row;



            $i++;

        }

        return $arrayData;

    }

	

	public function getDisplayAllLeftJoin($main_table_name, $fields, $join , $limit_from, $total_row_display, $sort, $order, $where = null){



		if(is_array($fields)){

			$select_fields = implode($fields,', ');

		}



		$join_str = "";



		foreach($join as $inner_array)

		{

			$join_str .= ' LEFT JOIN '.implode($inner_array, ' ON ');

		}



             $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where." ORDER BY ".$sort." ". $order." LIMIT ".$limit_from.", ".$total_row_display;

		$sql_run = mysql_query($sql);



		$i=0;

		$arrayData = array ();



		while($row=mysql_fetch_array($sql_run)){



			$arrayData[$i] = $row;



			$i++;

		}

		return $arrayData;

	}

    

 	public function getPreviousByJoin($main_table_name, $field, $join, $sort, $itemNumber, $order, $where=null){       

        $offset = $itemNumber-2;

        $fld = explode('AS',$field);

        if($offset >= 0 && $offset <= $this->getNumberDisplayAll($main_table_name,$where)){            

            $join_str = "";



            foreach($join as $inner_array)

            {

                $join_str .= ' LEFT JOIN '.implode($inner_array, ' ON ');

            }



           $sql = "SELECT ".$field." FROM ".$main_table_name." ".$join_str." ".$where." ORDER BY ".$sort." ". $order." LIMIT ".$offset.", 1";

            $sql_run = mysql_query($sql);

            $arr = mysql_fetch_array($sql_run);

            $results = $arr[trim($fld[1])];



        }else{



            $results="none";

            

        }



        return $results;



    }

 	public function getNextByJoin($main_table_name, $field, $join, $sort, $itemNumber, $order, $where=null){

        /*if(is_array($fields)){

            $select_fields = implode($fields,', ');

        }*/

        $fld = explode('AS',$field);

        if($itemNumber < $this->getNumberDisplayAll($main_table_name,$where)){

            $join_str = "";



            foreach($join as $inner_array)

            {

                $join_str .= ' LEFT JOIN '.implode($inner_array, ' ON ');

            }



            $sql = "SELECT ".$field." FROM ".$main_table_name." ".$join_str." ".$where." ORDER BY ".$sort." ". $order." LIMIT ".$itemNumber.", 1";

            $sql_run = mysql_query($sql);

            $arr = mysql_fetch_array($sql_run);

            $results = $arr[trim($fld[1])];

        }else{

            $results="none";

        }

        return $results;

    }



    public function getDisplayAllInnerJoinWithGroupby($main_table_name, $fields, $join , $limit_from, $total_row_display, $sort, $order, $where = null,$groupby) {



        //$alias = explode("AS", $main_table_name);



        if(is_array($fields )) {



            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            // print $count=count($inner_array);

            $join_str .= ' INNER JOIN  '.$inner_array[0].' ON '.$inner_array[1];



            for($i=2;$i<count($inner_array);$i++) {

                $join_str .= ' AND '.$inner_array[$i];

            }

        }



         $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where." group by ".$groupby." ORDER BY ".$sort." ". $order." LIMIT ".$limit_from.", ".$total_row_display;

        $sql_run = mysql_query($sql);



        $i=0;

        $arrayData = array ();



        while($row=mysql_fetch_array($sql_run)) {



            $arrayData[$i] = $row;



            $i++;

        }

        return $arrayData;

    }



    public function getTotalRowInnerJoinWithGroupby($main_table_name, $fields, $join , $limit_from, $total_row_display, $sort, $order, $where = null,$groupby) {



        //$alias = explode("AS", $main_table_name);



        if(is_array($fields )) {



            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            // print $count=count($inner_array);

            $join_str .= ' INNER JOIN  '.$inner_array[0].' ON '.$inner_array[1];



            for($i=2;$i<count($inner_array);$i++) {

                $join_str .= ' AND '.$inner_array[$i];

            }

        }



        $sql = "SELECT  COUNT(*) AS `count_all`  FROM ".$main_table_name." ".$join_str." ".$where." group by ".$groupby." ORDER BY ".$sort." ". $order." LIMIT ".$limit_from.", ".$total_row_display;

        $sql_run = mysql_query($sql);





        $arr=mysql_fetch_array($sql_run);







        return $arr['count_all'];

    }



    public function getTotalRowInnerJoinWithGroupbyWithoutLimit($main_table_name, $fields, $join ,$sort, $order, $where = null,$groupby) {



        if(is_array($fields )) {



            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            // print $count=count($inner_array);

            $join_str .= ' INNER JOIN  '.$inner_array[0].' ON '.$inner_array[1];



            for($i=2;$i<count($inner_array);$i++) {

                $join_str .= ' AND '.$inner_array[$i];

            }

        }



         $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where." group by ".$groupby." ORDER BY ".$sort." ". $order;

        $sql_run = mysql_query($sql);



        $i=0;

        $arrayData = array ();



        while($row=mysql_fetch_array($sql_run)) {



            $arrayData[$i] = $row;



            $i++;

        }

        return $arrayData;



    }



    public function getDisplayAllInnerJoinWithoutArray($main_table_name, $fields, $join , $limit_from , $total_row_display, $sort, $order, $where = null) {



        if(is_array($fields)) {

            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            $join_str .= ' INNER JOIN '.implode($inner_array, ' ON ');

        }



        $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where." ORDER BY ".$sort." ". $order." LIMIT ".$limit_from.", ".$total_row_display;

        $sql_run = mysql_query($sql);







        $arrayData = array ();



        while($row=mysql_fetch_array($sql_run)) {



            $arrayData = $row;



        }

        return $arrayData;

    }



    public function getDisplayAllInnerJoinWithoutArrayGroupby($main_table_name, $fields, $join , $limit_from , $total_row_display, $sort, $order, $where = null,$groupby) {



        if(is_array($fields)) {

            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            // print $count=count($inner_array);

            $join_str .= ' INNER JOIN  '.$inner_array[0].' ON '.$inner_array[1];



            for($i=2;$i<count($inner_array);$i++) {

                $join_str .= ' AND '.$inner_array[$i];

            }

        }



        $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where." group by ".$groupby."  ORDER BY ".$sort." ". $order." LIMIT ".$limit_from.", ".$total_row_display;

        $sql_run = mysql_query($sql);







        $arrayData = array ();



        while($row=mysql_fetch_array($sql_run)) {



            $arrayData = $row;



        }

        return $arrayData;

    }



    public function getDisplayAllInnerJoinWithoutArrayGroupbyCount($main_table_name, $fields, $join , $limit_from , $total_row_display, $sort, $order, $where = null,$groupby) {



        if(is_array($fields)) {

            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            $join_str .= ' INNER JOIN '.implode($inner_array, ' ON ');

        }



       $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where." group by ".$groupby."  ORDER BY ".$sort." ". $order." LIMIT ".$limit_from.", ".$total_row_display;

        $sql_run = mysql_query($sql);



        //$arrayData = array ();



        $rownum=mysql_num_rows($sql_run);



        return $rownum;

    }



    public function getDisplayAllInnerJoinWithoutLimit($main_table_name, $fields, $join , $sort, $order, $where = null) {



        if(is_array($fields)) {

            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            $join_str .= ' INNER JOIN  '.$inner_array[0].' ON '.$inner_array[1];

            if(count($inner_array) > 2) {

                for($i=2;$i<count($inner_array);$i++) {

                    $join_str .= ' AND '.$inner_array[$i];

                }

            }

        }



        $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where." ORDER BY ".$sort." ". $order;

        $sql_run = mysql_query($sql);





        $i=0;

        $arrayData = array ();



        while($row=mysql_fetch_array($sql_run)) {



            $arrayData[$i] = $row;



            $i++;

        }

        return $arrayData;

    }



    public function getDisplayAllInnerJoinWithoutLimitCount($main_table_name, $fields, $join , $where = null) {



        if(is_array($fields)) {

            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            // print $count=count($inner_array);

            $join_str .= ' INNER JOIN  '.$inner_array[0].' ON '.$inner_array[1];



            for($i=2;$i<count($inner_array);$i++) {

                $join_str .= ' AND '.$inner_array[$i];

            }

        }



        $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where;

        $sql_run = mysql_query($sql);





        $numberrow=mysql_num_rows($sql_run);



        return $numberrow;

    }



    public function getDisplayAllInnerJoinWithoutLimitOrder($main_table_name, $fields, $join , $where = null) {



        if(is_array($fields)) {

            $select_fields = implode($fields,', ');

        }



        $join_str = "";



        foreach($join as $inner_array) {

            // print $count=count($inner_array);

            $join_str .= ' INNER JOIN  '.$inner_array[0].' ON '.$inner_array[1];



            for($i=2;$i<count($inner_array);$i++) {

                $join_str .= ' AND '.$inner_array[$i];

            }

        }



        $sql = "SELECT ".$select_fields." FROM ".$main_table_name." ".$join_str." ".$where;

        $sql_run = mysql_query($sql);





        $i=0;

        $arrayData = array ();



        while($row=mysql_fetch_array($sql_run)) {



            $arrayData[$i] = $row;



            $i++;

        }

        return $arrayData;

    }



    public function getSpecificRecords($table_name, $fields, $where=null) {



        if($fields!=''){

			if(is_array($fields)){

				$select_fields = implode($fields,', ');

			}else{

				$select_fields = $fields;

			}

		}else{

			$select_fields = ' * ';

		}



		$sql = "SELECT ".$select_fields." FROM `".$table_name."` ".$where;

		$sql_run = mysql_query($sql) or die(mysql_error()) ;



		$arrayData = array ();

		if(mysql_num_rows($sql_run) > 0)

		{

			if(mysql_num_rows($sql_run) == 1)

			{

				$row = mysql_fetch_array($sql_run);

				if(is_array($fields) && count($fields) == 1)

				{					

					$arrayData[0]=$row;

					return $arrayData;

					exit();

				}

				else

				{

					$arrayData[0]=$row;

					return $arrayData;

					exit();

				}

			}

			else{

				$i=0;



				while($row=mysql_fetch_array($sql_run)){



					$arrayData[$i] = $row;



					$i++;

				}

			}

			return $arrayData;

		}

		else

		{

			return "no_result";

		}

    }

	

	//get specific record using limit by default 1

	public function getSpecificRecordsWithLimit($table_name, $fields, $where=null,$limit=1) {



        if(is_array($fields)) {

            $select_fields = implode($fields,', ');

        }else {

            $select_fields = ' * ';

        }



        $sql = "SELECT ".$select_fields." FROM `".$table_name."` ".$where." LIMIT 0,".$limit;

        $sql_run = mysql_query($sql) or die(mysql_error()) ;



        $arrayData = array ();

        if(mysql_num_rows($sql_run) > 0) {

            if(mysql_num_rows($sql_run) == 1) {

                $row = mysql_fetch_array($sql_run);



                if(is_array($fields) && count($fields) == 1) {

					$arrayData[0]=$row;

                    //return $row[$select_fields];

					return $arrayData;

                    exit();

                }

                else {

                    //return $row;

					$arrayData[0]=$row;

					return $arrayData;

                    exit();

                }

            }

            else {

                $i=1;

                while($row=mysql_fetch_array($sql_run)) {

					if($i <= $limit){

							$arrayData[$i] = $row;

							$i++;

						}

                }

            }

            return $arrayData;

        }

        else {

            return "no_result";

        }

    }



    public function insert($table_name, $fields, $expression=null) {



        $column_string = "";

        $data_string = "";

        $general_fields = false;



        if($fields != null) {

            $general_fields = true;





            $copy_of_fields = $fields;



            end($copy_of_fields);

            $last_index = key($copy_of_fields);



            foreach($fields as $key=>$value) {

                if($key == $last_index) {



                    $column_string .= "`$key`";

                    $data_string .= "'$value'";

                }

                else {

                    $column_string .= "`$key`, ";

                    $data_string .= "'$value', ";

                }

            }

        }



        if($expression != null) {



            $copy_of_expression = $expression;



            end($copy_of_expression);

            $last_key = key($copy_of_expression);



            foreach($expression as $key=>$value) {

                if($key == $last_key) {



                    if($general_fields == true) {

                        $column_string .= ", `$key`";

                        $data_string .= ", $value";

                    }

                    else {

                        $column_string .= "`$key`";

                        $data_string .= "$value";

                    }

                }

                else {



                    if($general_fields == true) {

                        $column_string .= ", `$key`, ";

                        $data_string .= ", $value, ";



                    }else {

                        $column_string .= "`$key`, ";

                        $data_string .= "$value, ";

                    }

                }

            }

        }



        $sql_insert_data = "INSERT INTO `".$table_name."` (".$column_string.") VALUES (".$data_string.")";



        $resultset = mysql_query($sql_insert_data);

		

		$last_insert_id = mysql_insert_id();

		

		return $last_insert_id;

    }



    public function update($table_name, $where, $fields, $expression=null) {





        $data_string = "";

        $general_fields = false;



        if($fields != null) {

            $copy_of_fields = $fields;



            end($copy_of_fields);

            $last_index = key($copy_of_fields);



            $general_fields = true;



            foreach($fields as $key=>$value) {

                if($key == $last_index) {



                    $data_string .= "`$key` = '$value'";



                }

                else {

                    $data_string .= "`$key` = '$value', ";

                }

            }

        }



        if($expression != null) {



            $copy_of_expression = $expression;



            end($copy_of_expression);

            $last_key = key($copy_of_expression);



            foreach($expression as $key=>$value) {

                if($key == $last_key) {

                    if($general_fields == true) {

                        $data_string .= ", `$key` = ".$value;

                    }

                    else

                        $data_string .= "`$key` = ".$value;



                }

                else {

                    if($general_fields == true) {

                        $data_string .= ", `$key` = ".$value.", ";

                    }

                    else

                        $data_string .= "`$key` = ".$value.", ";

                }

            }

        }

		if($where==''){

			$sql_insert_data = "UPDATE `".$table_name."` SET ".$data_string;

		}else{

        	 $sql_insert_data = "UPDATE `".$table_name."` SET ".$data_string. " WHERE ".$where;

		}

		//echo $sql_insert_data;die;

        $resultset = mysql_query($sql_insert_data);

    }



    function delete($table_name, $field, $data) {



        $sql_del_data = "DELETE FROM `".$table_name."` WHERE `".$field."` = '".$data."'";

        $sql_del_data_run = mysql_query($sql_del_data);



    }



    function __destruct() {

		//echo 'yahoo'.__LINE__;

		//exit;

    }



}



?>