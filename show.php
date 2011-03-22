<style>

table {margin:1em 0; border:none;text-align: center}

table td {border: none;}

table {border:1px solid #036;}

th {background:#036; color:#fff; border:none; border-bottom:1px solid #fff;}

table tr:hover{background: #CCFFAE;cursor: pointer;color: #292;}

.hilite {background: #CCFFAE;cursor: pointer;color: #292;}

.addcolor {background: #E9E9E9}

h1{font-family: tohama,arial,verdana,sans-serif;font-size: 30px;color: #393;text-transform: capitalize}

</style>

<center><h1>GeoIP - Serendipity Administration Suite</h1></center>
<center>
<?php

    require_once('init.php');

    if($db->table_exists($table)) {

           $sql = "SELECT * FROM $table";

           $db->query($sql);

                if($db->getRows() > 0) {


                           echo$db->display(1000);


                } else {
                          echo"Table <strong>$table</strong> is empty.";  
                       }

           } else {
 
                echo"Table <strong>$table</strong> doesn`t exists.";

           }//end if-else
?>
</center>


<script type="text/javascript">

(function(){

          var trs = document.getElementsByTagName('tr');

              for(var i=0;i<trs.length;i++) {

                        trs[i].onmouseover = function() {

                              this.className += ' hilite';  
                        }    


                        trs[i].onmouseout = function() {

                              this.className = this.className.replace('hilite',' ');
                        }    

                   if(i%2!=0) {
 
                        trs[i].className = 'addcolor'; 
                   }

              }//end-for

})(); 

</script>