<?php
    include_once("Database.php");
    
    class Functions extends Database{
        
        function check( $field )
        {
            $field = strip_tags( $field );
            $field = trim( $field );
            $field = stripslashes( $field );
            $field = mysqli_real_escape_string( $this->con,  $field );
            return $field;
        }
        
       
        
        function checkEditor( $field )
        {
           
            $field = trim( $field );
            $field = stripslashes( $field );
            $field = mysqli_real_escape_string( $this->con,  $field );
            return $field;
        }
        
        
        
        
        
       function subString($str,$strlen,$strpos=0)
		{
			if(strlen($str)>$strlen)
				return substr(strip_tags(html_entity_decode($str)),$strpos,$strlen)."...";
			else
				return strip_tags(html_entity_decode($str));
		}
        
        function encodePassword( $string )
        {
            return hash('sha512',$string);
        }
        
        function debugDump( $var )
        {
            echo "<pre>";
            var_dump( $var );
            echo "</pre>";
            exit();
        }
        
        function debugPrint( $arr )
        {
            echo "<pre>";
            print_r( $arr );
            echo "</pre>";
            exit();
        }
        
        function flush_table()
        {
            $this->table = "";
            $this->data = array();
            $this->tableField = "*";
            $this->order = "";
            $this->cond = array();
            $this->limit = "";
        }
        
        
        
    }
    
?>