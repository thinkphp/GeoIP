<?php

       $ip = trim($_SERVER['REMOTE_ADDR']);

       if($ip === '127.0.0.1') { $ip = '128.30.52.72'; $ip = '80.97.88.77';}

       $host = trim(getisp($ip));

       $root = 'http://query.yahooapis.com/v1/public/yql?q=';     

       $yql = "use 'http://thinkphp.ro/apps/YQL/ip.location2.xml' as ip.location; select * from ip.location where ip='".$ip."'";

       $url = $root . urlencode($yql). '&diagnostics=false&format=json';

       $content = get($url);

       $json = json_decode($content);

       $json = $json->query->results->Response;

       $postcode = $json->ZipPostalCode;
 
       if(isset($json->Latitude) && isset($json->Longitude)) {

           $yql2 = 'select woeid,postal from geo.places where woeid in (select place.woeid from flickr.places where lat = "'.$json->Latitude.'" and lon="'.$json->Longitude.'")'; 

           $url2 = $root . urlencode($yql2). '&diagnostics=false&format=json';

           $content2 = get($url2);

           $json2 = json_decode($content2);

           if(!isset($postcode)) $postcode = $json2->query->results->place->postal->content; 

           $woeid = $json2->query->results->place->woeid; 
       }

       $output = '{';

       $output .= '"ip":"'.$json->Ip.'","host":"'.$host.'","rc":"'.$json->RegionCode.'","rn":"'.$json->RegionName.'","cc":"'.$json->CountryCode.'","cn":"'.$json->CountryName.'","woeid":"'.$woeid.'","city":"'.$json->City.'","pc":"'.$postcode.'","lat":"'.$json->Latitude.'","lon":"'.$json->Longitude.'"';

       $output .= '}'; 

       $html = '<table id="mydata">';

       $html .= '<tbody>';
 
       $html .= '<tr><td><strong>Your IP:</strong></td><td>'.$json->Ip.'</td></tr>';    

       $html .= '<tr><td><strong>Host:</strong></td><td>'.$host.'</td></tr>';    

       $html .= '<tr><td><strong>Country Code:</strong></td><td>'.$json->CountryCode.'</td></tr>';

       $html .= '<tr><td><strong>Country Name:</strong></td><td>'.$json->CountryName.'</td></tr>';

       $html .= '<tr><td><strong>Region Code:</strong></td><td>'.$json->RegionCode.'</td></tr>';

       $html .= '<tr><td><strong>Region Name:</strong></td><td>'.$json->RegionName.'</td></tr>';

       $html .= '<tr><td><strong>Woeid:</strong></td><td>'.$woeid.'</td></tr>';

       $html .= '<tr><td><strong>City:</strong></td><td>'.$json->City.'</td></tr>';

       $html .= '<tr><td><strong>Postal Code:</strong></td><td>'.$postcode.'</td></tr>';

       $html .= '<tr><td><strong>Latitude:</strong></td><td>'.$json->Latitude.'</td></tr>';

       $html .= '<tr><td><strong>Longitude:</strong></td><td>'.$json->Longitude.'</td></tr>';

       $html .= '</tbody>';

       $html .= '</table>';

       include('insert-into-table.php');

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<html dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <title>GeoIP</title>
   <style>

  html,body {background:#666;font-family: arial,verdana,sans-serif,tahoma}

  h1,h2,h3 {font-family:Calibri,sans-serif;}

  h1 {font-size:200%;margin:0 0 10px 0;color:#fff;font-weight: bold}

  #hd{margin-top: 40px}

  #bd{background:#fff;border: 7px solid #fff;}

  #map{width: 600px;height: 400px;}
 
  #mydata {margin-left: 150px;margin-top: 0px;}

  #mydata tr td{padding: 10px}

  #mydata2 {width: 250px;}

  #mydata2 tr td{padding: 4px}

  #ft{ color:#ccc;margin: 4px}

  #ft a { color:#ccc;}

  strong{font-weight: bold}
   
   </style>
</head>
<body>

<div id="doc2" class="yui-t7">
   <div id="hd" role="banner"><h1>GeoIP - get locations by IP</h1></div>
   <div id="bd" role="main">

	<div class="yui-g">

               <div class="yui-u first">

                     <div id="map"></div>

               </div>
               <div class="yui-u">

                     <?php echo$html; ?>

               </div>

         </div><!-- end yui-g -->

   </div><!-- end bd -->
   <div id="ft" role="contentinfo"><p>written by <a href="http://thinkphp.ro">Adrian Statescu.</a> Using YUI and Yahoo! Maps</p></div>

</div>

<script type="text/javascript" src="http://yui.yahooapis.com/2.6.0/build/utilities/utilities.js"></script>
<script type="text/javascript" src="http://l.yimg.com/d/lib/map/js/api/ymapapi_3_8_2_3.js"></script>
<script type="text/javascript">

var YMAPPID = "OrnaXSnV34F26uD7a0DyZY9XdBtz4_YfDNG7EcX69S1Adk1SqFK8FYKRB4Gbjr4-";

function placeonmap(json) {

                      if(json.length > 0) { 
 
                            var geopoints = [];

                            var map = new YMap(document.getElementById('map'));
 
                                map.addZoomLong();

                                map.addPanControl();

                            for(var i=0;i<json.length;i++) {

                                  var myPoint = new YGeoPoint(json[i].lat,json[i].lon);

                                      geopoints.push(myPoint);

                                  var newMarker = new YMarker(myPoint,'marker' + i);

                                       var label = json[i].ip; 
 
                                       newMarker.addAutoExpand(label);

                                       map.addOverlay(newMarker); 

                                       var ip = json[i].ip;  

                                       var host = json[i].host;

                                       var city = json[i].city;

                                       var country = json[i].cn;

                                       var postcode = json[i].pc;

                                       var lat = json[i].lat;

                                       var lon = json[i].lon;

                                       var cc = json[i].cc;

                                       var rc = json[i].rc;

                                       var rn = json[i].rn;

                                       var woeid = json[i].woeid;

                                       YEvent.Capture(newMarker, EventsList.MouseClick, function(e){

                                            var html = '<table id="mydata2"><tbody>';

                                                html += '<tr><td><strong>IP: </strong></td> <td><strong>'+ip+'</strong></td></tr>';

                                                html += '<tr><td><strong>Host name: </strong></td> <td>'+host+'</td></tr>';

                                                html += '<tr><td><strong>Country code: </strong></td> <td>'+cc+'</td></tr>';

                                                html += '<tr><td><strong>Country name: </strong></td> <td>'+country+'</td></tr>';

                                                html += '<tr><td><strong>Region code: </strong></td> <td>'+rc+'</td></tr>';

                                                html += '<tr><td><strong>Region name: </strong></td> <td>'+rn+'</td></tr>';

                                                html += '<tr><td><strong>Woeid: </strong></td> <td>'+woeid+'</td></tr>';

                                                html += '<tr><td><strong>City: </strong></td> <td>'+city+'</td></tr>';

                                                html += '<tr><td><strong>Postal Code: </strong></td> <td>'+postcode+'</td></tr>';

                                                html += '<tr><td><strong>Latitude: </strong></td> <td>'+lat+'</td></tr>';

                                                html += '<tr><td><strong>Longitude: </strong></td> <td>'+lon+'</td></tr>';

                                                html += '</tbody></table>';
 
                                                this.openSmartWindow(html);
                                       });


                            }//endfor


                            map.drawZoomAndCenter(myPoint, 7);

                      }//endif


}//end function

</script>
<script type="text/javascript">placeonmap([<?php echo $output;?>])</script>

</body>
</html>


<?php

     //using cURL
     function get($url) {

          $ch = curl_init();  

          curl_setopt($ch,CURLOPT_URL,$url);

          curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

          curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

          $data = curl_exec($ch);

          curl_close($ch);

          if(empty($data))  {return 'Server Timeout';}

                    else 
                            {return $data;}
     }

     //get ISP
     function getisp($ip='') {

          if ($ip === '') $ip = $_SERVER['REMOTE_ADDR'];

               $longisp = @gethostbyaddr($ip);

               $isp = explode('.', $longisp);

               $isp = array_reverse($isp);

               $tmp = $isp[0];

               if (preg_match("/(org?|com?|net?|ro?|uk)/i", $tmp)) {

                         $myisp = $isp[2].'.'.$isp[1].'.'.$isp[0];

               } else {

                         $myisp = $isp[1].'.'.$isp[0];
          }

             if(preg_match("/[0-9]{1,3}\.[0-9]{1,3}/", $myisp)) return 'ISP lookup failed.';

       return $myisp;

     }//end function

?>
