<?

/*=*=*=* CONNECTING TO DB *=*=*=*/
if($_SERVER["SERVER_ADDR"]=="127.0.0.1"){ @$connect = mysql_connect("localhost", "root", "root"); @$select_db = mysql_select_db("trojuhelniky");}
else{                                     @$connect = mysql_connect("mysql5", "svec", "mknjbhvg"); @$select_db = mysql_select_db("svec");}
@mysql_query("SET NAMES utf8");
if($connect && $select_db){$db_connect = true;}else {$db_connect = false; errorHandler("db"); die();}


function soudelne($a, $b, $c){
    // set up an array of values to be evaluated
  $values = array($a, $b, $c);
    // count the number of values in the array
  $num_values = count($values);
    // get the first 2 values in the array        
  $x = current($values);
  $y = next($values);  
    // set up a for-loop to check through all of the values in the array
    // the first pass will check 2 numbers then each additional pass will check 1
    // make ($num_values - 1) passes
  for ($i = 1; $i < $num_values; $i ++){
        // set up the larger and smaller of the values
      $a = max( $x, $y );
      $b = min( $x, $y );
      $c = 1;
        // find the GCF of $a and $b
        // it will be found when $c == 0
      do{
          $c = $a % $b;
            // capture last value of $b as the potential last GCF result
          $gcf = $b;
            // if $c did not = 0 we need to repeat with the values held in $b and $c
            // at this point $b is higher than $c so we set up for the next iteration
            // set $a to the higher number and $b to the lower number
          $a = $b;
          $b = $c;     
      }
      while ($c != 0);
        // if $c did == 0 then we have found the GCF of 2 numbers
        // now set up to find the GCF of the last GCF we found and the next value in the array()
      $x = $gcf;
      $y = next($values);
  }  // end for loop through array()
    //
    // the greatest common factor of our array of values is now held in $gcf
    //
  return $gcf;
}

function existuje($a, $b, $c){
  $a = array($a, $b, $c);
  sort($a);
  if($a[0]+$a[1] >= $a[2]) return 1;
  else return 0;
}

function jeCele($cislo){
  if($cislo==floor($cislo)) return 1;
  else return 0;
}

function pythagorejsky($a, $b, $c){
  if(($a*$a)+($b*$b)==$c*$c) return 1;
  else return 0;
}

function babylonsky($a, $b, $c){
  if(($a*$a)+($b*$b)==2*$c*$c){
    if($a==$b and $b==$c) return 2;
    else return 1;
  }
  else return 0;
}

function heronuv($a, $b, $c){
  $s = ($a + $b + $c)/2;
  $obsah = sqrt($s*($s-$a)*($s-$b)*($s-$c));
  if(jeCele($obsah)) return $obsah;
  else return 0;
}

$konec = 250;
$start = 200;

require "timer.class.php";
$timer = new timer(1);

echo "<table border='0' bordercolor='red' cellpadding='5' cellspacing='0'>\n";
echo "<tr><th>a</th><th>b</th><th>c</th>
<th>Primitivní <span>(základ)</span></th>
<th>Pythagorejský</th>
<th>Heronův <span>(obsah)</span></th>
<th>Babylonský <span>(rovnostranný?)</span></th>
</tr>";


$radek = 1;
$kombinace = 1;
for($i=$start; $i<=$konec; $i++){

  for($j=1; $j<=$i; $j++){
    for($l=1; $l<=$j; $l++){
      $strany = array($i, $j, $l);
      sort($strany);
      $pytha = pythagorejsky($l, $j, $i);
      $heron = heronuv($l, $j, $i);
      $bab = babylonsky($l, $i, $j);
      $nsd = soudelne($i, $j, $l);
      $existuje = existuje($i, $j, $l);
      $p_cisla = $l/$nsd.", ".$j/$nsd.", ".$i/$nsd;
      if($bab==2) $rovnostranny = 0;
      else $rovnostranny = 0;
      if($bab==2) $bab = 1;
      if($nsd==1) $prim = 1;
      else $prim = 0;

      mysql_query("INSERT INTO `trojuhelniky` 
      (`a`, `b`, `c`, `sestrojit`, `rovnostranny`, `primitivni`, `primitivni-cisla`, `pythagorejsky`, `heronuv`, `babylonsky`) VALUES
      ('".$strany[0]."', '".$strany[1]."', '".$strany[2]."', '".$existuje."', '".$rovnostranny."', '".$prim."', '".$p_cisla."', '".$pytha."', '".$heron."', '".$bab."' )");
/*     
      if(existuje($i, $j, $l)) $obr = "<img src='/checkmark_blue.png' width=32 />";
      else $obr = "<img src='/cross_blue.png' width=32 />";
      
      if(($pytha or $heron or $bab)){#} and $nasobky==1){  
      echo "<tr>";
      
      echo "<td>".$strany[0]."</td>";
      echo "<td>".$strany[1]."</td>";
      echo "<td>".$strany[2]."</td>";

        if($nsd>1) echo "<td><span>(".$l/$nsd.", ".$j/$nsd.", ".$i/$nsd.")</span></td>";
        else echo "<td>$obr</td>";

        if($pytha) echo "<td>$obr</td>";
        else echo "<td></td>";
        
        if($heron) echo "<td>$obr <span>({$heron})</span></td>";
        else echo "<td></td>";
        
        if($bab==1)     echo "<td>$obr <span>(ne)</span></td>";
        elseif($bab==2) echo "<td>$obr <span>(ano)</span></td>";
        else echo "<td></td>";

#       echo "<td style='background: red;'>ANO</td>";
#      else echo "<td> </td>";
      
      echo "</tr>\n";
    
      $radek++;
      }*/  
    $kombinace++;
    }
  }


}
echo '</table>';
#echo $radek;
#echo "/";
#echo $kombinace;
echo $timer->get();
?>