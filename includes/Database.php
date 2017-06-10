<?php
    include_once("constants.php");
	include_once("class.paging.php");
	
	class Database
	{
		var $con, $table, $data, $tableField, $order, $cond, $sqlDebug;
        
        
        function __construct()
        {
            $this->con = "";
            $this->table = "";
            $this->data = "";
            $this->tableField = "*";
            $this->order = "";
            $this->cond = "";
            $this->limit = "";
            $this->sqlDebug = false;
        }
        
		function connect_db()
		{
			$this->con = mysqli_connect(HOST, USER, PASS) or die("Server Connection Failed!");
			$sel_db = mysqli_select_db( $this->con, DATABASENAME ) or die("Database Connection Failed! ".mysqli_error($this->con));
			mysqli_set_charset($this->con, 'utf8');
			return $this->con;		
		}
        
        function connect_sql()
        {
            $serverName = SQLHOST; //serverName\instanceName

            // Since UID and PWD are not specified in the $connectionInfo array,
            // The connection will be attempted using Windows Authentication.
            $connectionInfo = array( "Database"=>SQLDATABASE, "UID"=>SQLUID, "PWD"=>SQLPASS );
            $this->sqlcon = sqlsrv_connect( $serverName, $connectionInfo);
            
            if( $this->sqlcon ) {
                // echo "Connection established.<br />";
                return $this->sqlcon;
            }else{
                 echo "Connection could not be established.<br />";
                 echo "<pre>";
                 print_r( sqlsrv_errors());
                 echo "</pre>";
                 die();
            }
        }
        
        

        
        
        
		
		function exec( $sql )
		{
		 
			// $result = mysqli_query( $this->con, $sql ) or $this->loadError();
			$result = mysqli_query( $this->con, $sql ) or die( mysqli_error($this->con) );
			if( $result )
			{
				return $result;
			}
		}
		
		function pageExec( $conn, $sql )
		{
			$result = mysqli_query( $conn, $sql ) or $this->loadError();
			
			if( $result )
			{
				return $result;	
			}
		}
        
		function fetch_array( $rs )
		{
			return mysqli_fetch_array( $rs );
		}
		
		function fetch_assoc( $rs )
		{
			return mysqli_fetch_assoc( $rs );
		}
		
		function fetch_object( $rs )
		{
			return mysqli_fetch_object( $rs );
		}
		
		function total_rows( $rs )
		{
			return mysqli_num_rows( $rs );
		}
		
		
		function insert()
		{
			$query = "INSERT INTO $this->table SET ";
			
			foreach( $this->data as $k => $v )
			{
				$arr[$k] = " $k = '$v' ";
			}
			
			if( count( $arr ) > 0 )
			{
				$str  = implode( ",", $arr );
			}
			
			$query = $query.$str;
			
			$result = $this->exec( $query );
			
			return $result;
        }


        function update()
        {
            $query = "UPDATE $this->table SET ";
            
            foreach( $this->data as $k => $v )
            {
                $arr[$k] = "$k = '$v'";
            }
            if( count( $arr ) > 0 )
            {
                $str = implode(",", $arr);
                $query .= $str;
            }
            foreach( $this->cond as $k => $v )
            {
                $carr[$k] = "$k = '$v'";
            }
            if( count( $carr ) > 0 )
            {
                $cstr = " WHERE ".implode(" AND ", $carr );
                $query .= $cstr;
            }
            $result = $this->exec( $query );
            return $result;
            
        }	
        
        
        function delete()
        {
            $query = "DELETE FROM $this->table ";
            
            foreach( $this->cond as $k => $v )
            {
                $carr[$k] = "$k = '$v'";
            }
            if( count( $carr ) > 0 )
            {
                $cstr = " WHERE ".implode(" AND ", $carr );
                $query .= $cstr;
            }
           
            $result = $this->exec( $query );
            return $result;
            
        }
        
        function select(  $single = FALSE, $pagination = FALSE, $path = NULL, $plimit = NULL, $pid = NULL, $search = NULL )
        {
            $query = "SELECT $this->tableField FROM $this->table ";
            $carr = array();
            if( $this-> cond != "" )
            {
            
                foreach( $this->cond as $k => $v )
                {
                    $carr[$k] = "$k = '$v'";
                }
                if( count( $carr ) > 0 )
                {
                    $cstr = " WHERE ".implode(" AND ", $carr );
                    $query .= $cstr;
                }
            }
            
            if( $search != NULL )
            {
                if( $this->cond == "" ){
                    $query .= " WHERE 1 = 1 ";   
                }
                $query .= " AND ".$search." ";
            }
            
            if( $this-> order != "" )
            {
                $query .= " ORDER BY ".$this->order." ";
            }
            
            if( $this-> limit != "" )
            {
                $query .= " LIMIT ".$this->limit." ";
            }
            if( $this->sqlDebug == TRUE )
            {
                return $query;
            }
            if( $single == TRUE )
            {
                //return single array
                $result = $this->exec( $query );
                return $this->fetch_assoc( $result );
            }
            
            else if( $pagination == TRUE )
            {
                $vals = $this->listings( $query, $path, $plimit,0,false, $pid );
                return $vals;
            }
            else{
                
                    return $this->exec( $query );
                
            }
            
            
            
        }
        
        
        function listings($sql, $path, $plimit=10000, $seo=0, $debug=false, $pid = 0) { 
	
		if($debug){
			die($sql);
		}
		else{
				$pagelist=$sql;
				$pageid =1;	// Get the pid value 	
				if(isset($_REQUEST['np'])) $pageid = $_REQUEST['np'];
                //$pageid = $pid;
                
				$Paging = new paging($seo);
				$Paging->conObj = $this->obj=new Database;
				$records = $Paging->myRecordCount($this->con,$pagelist); // count records
				$totalpage = $Paging->processPaging($plimit,$pageid);
				$resultlist = $Paging->startPaging($pagelist); // get records in the databse
				$links = $Paging->pageLinks($path.(isset($queryString)?"?".$queryString:"")); // 1234 links
				unset($Paging);
				
				$pagingValue = array($records,$resultlist,$links);
				return $pagingValue; 
			}
		}
        
        
        
        function insert_id()
        {
            return mysqli_insert_id($this->con);
        }
        
        
        
        
        function redirect( $url )
        {
            
            if(headers_sent())
            {
                echo "<script language=\"Javascript\">window.location.href='$url';</script>";
                
                exit();
            }else{
                session_write_close();
                header("Location:$url");
                exit();
            }
        }
        
        
		
		
	}




?>