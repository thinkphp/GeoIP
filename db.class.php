<?php

//class for MySQL Database
class Database_MySQL {

  private $dbh;

  private $vec = array();

      //constructor
      public function __construct() {

      }
 
      //method for connect to database
      public function connect($host,$user,$pass,$db) {

             if(!$this->dbh = @mysql_connect($host,$user,$pass)) {
 
                        throw new Exception($this->error());
             }

             if(!@mysql_select_db($db,$this->dbh)) {
         
                        throw new Exception($this->error());
             }
  
         return true;
      }

       //do Query
      public function query($q) {

             $this->result = mysql_query($q);

             if(!$this->result) {echo"Could not successfully run query($sql) from DB: ".$this->error();} 

                          else 

                                {return true;}
      }


      public function getRows() {

             return mysql_num_rows($this->result);
      }


      //method that display the results on the tag table html
      public function display($width) {

             //if we have results then push in array
             while($row = mysql_fetch_assoc($this->result)) {

                   $this->vec[] = $row;             
             }

             $this->arr2table($this->vec,$width);
      }

      //method that check if we have a table or not
      public function table_exists($table) {

             $table = addSlashes($table);

             $sql = "SELECT * FROM $table";

             $r = @mysql_query($sql);

             if($r) return true;

                 else return false;
      }

      //method that drop a table sent as parameter
      public function delete_table($table) {

             $table = addSlashes($table);

             $sql = "drop table $table";

             echo$sql;

             $r = @mysql_query($sql);

             if($r) return true;

                 else return false;

      }

      //handle an error
      public function error() {

             return mysql_error($this->dbh); 
      }


    //arr to table
    public function arr2table($arr,$width) {

      $count = count($arr);

      $innercount = 0;

      if($count > 0){

        reset($arr);

        $num = count(current($arr));

        echo "<table align=\"center\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\" width=\"$width\">\n";

        echo "<thead>\n";

        echo"<th>useid.</th>";

       foreach(current($arr) as $key => $value) {

           echo "<th>";

           echo $key."&nbsp;";

           echo "</th>\n";  

       }//end foreach 

       echo "</thead>\n";

       while($curr_row = current($arr)) {

           echo "<tr>\n";

           $col = 1;

           echo"<td>$innercount</td>";

           while (false !== ($curr_field = current($curr_row))) {

               echo "<td>";

               echo $curr_field."&nbsp;";

               echo "</td>\n";

               next($curr_row);

               $col++;
           }

           while($col <= $num){

               echo "<td>&nbsp;</td>\n";

               $col++;      

           }

           echo "</tr>\n";

           next($arr);

           $innercount++;

         }//end while

         echo "</table>\n";

       }//end if

      }//end function
                          
};//end class     



//class for SQLite Database
class Database_SQLite {

  private $dbh;

  private $result;

      //contructor of class
      public function __construct() {

      }

      //method that achieve the connection to databaselite
      public function connect($db) {

             //connect to SQLite
             $this->dbh = new SQLitedatabase($db);
      }

      //do Query
      public function query($q) {

             //do Query
             $this->result = $this->dbh->query($q);
      }

      public function getRows() {

             return $this->result->numRows();
      }

      //method that display the results in table html
      public function display($width) {

             //hold results in variable result
             $result = $this->result;

             $output .= "<table align=\"center\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\" width=\"$width\">";

             $output .= "<thead>";

             $row = $result->current();

             foreach($row as $key=>$value) {

                     if(!is_numeric($key)) {

                            $output .= "<th>$key</th>";
                     }
             }

             $output .="</thead>";

             $output .="<tbody>";

             $count = 0;

             //using Iterator
             while($result->valid()) {

                     $row = $result->current();
                    
                     $output .='<tr>';
  
                           $n = count($row)/2;

                           $output .= "<td>$count</td>";  

                           for($i=1;$i<$n;$i++) {

                                  $output .= "<td>$row[$i]</td>";
                           } 
                  
                     $output .='</tr>';

                     $result->next(); 
 
                     $count++;

             }//end while  

             $output .="</tbody>"; 

             $output .="</table>"; 

         return $output;
      }

      //method that check if a table exists or not
      public function table_exists($table) {

             $table = addSlashes($table);

             $sql = "SELECT * FROM $table";

             $r = @$this->dbh->query($sql);

             if($r) return true;

                 else return false;  
      }

      //delete a table sent as parameter
      public function delete_table($table) {

             $table = addSlashes($table);

             $sql = "drop table $table";

             echo$sql;

             $r = $this->dbh->query($sql);

             if($r) return true;

                 else return false;

      }


        
                         
};//end class     


?>