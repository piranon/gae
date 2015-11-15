<? 

  require_once("../../root_basedata/root_basedata.php");
  
  header("Connection: Keep-Alive:max=0");
  header("Access-Control-Allow-Origin: *");
  header("Content-type: text/css");

  //$font_base_url = "http://localhost/gae/root_sitefiles/fonts/";
  $font_base_url = root_sitefiles_url()."fonts/";


  $fontData = array(
      array("100","ultralight"),
      array("200","extralight"),
      array("300","light"),
      array("400","light"),
      array("normal","regular"),
  );
 
  foreach ($fontData as $index => $row) {
    
    echo "@font-face {
      font-family: 'ThaiSans Neue';
      font-style: normal;
      font-weight: ".$row[0].";
      src: local('ThaiSans Neue ".$row[1]."'), local('ThaiSans-Neue-".$row[1]."'), url(".$font_base_url."ThaiSans%20Neue%20v1.0/Woff/thaisansneue-".$row[1]."-webfont.woff) format('woff');
      unicode-range: U+0E00-U+0E7F;
    }
    ";

  }


?>



