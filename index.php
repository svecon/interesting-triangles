<?
header("Content-Type: text/html; charset=UTF-8");
$mysqli = new mysqli('wm18.wedos.net', 'w8668_triangl', '5DF5UXf2', 'd8668_triangl');
//$mysqli = new mysqli('localhost', 'root', 'root', 'trojuhelniky');
if ($mysqli->connect_error) {
    die('Nepodařilo se připojit k MySQL serveru ('.$mysqli->connect_errno.') '.$mysqli->connect_error);
}

function pripravStrany($a = array()){
  $max = max($a);
  $newMax = 450;
  $pomer = $newMax/$max;

  $newT = array($a[0]*$pomer, $a[1]*$pomer, $a[2]*$pomer);
  sort($newT);
  return $newT[0]."-".$newT[1]."-".$newT[2];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-language" content="cs" />
  
  <meta name="description" content="Generátor unikátních trojúhelníků." /> 
  <meta name="keywords" content="Trojúhelník, Pythagorejský, Heronův, Babylonský, Primitivní, Generátor" /> 
  
  <title>Trojúhelníky (pro MATES vytvořil Ondřej Švec)</title>

  <link href="favicon.ico?" rel="icon" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="/style.css" />
</head>
<body>

<h1 id='head'><a href="?">Trojúhelníky</a></h1>

<div id="nastaveni"><a href="?nastaveni=true">
<img src="settings.png" width=128 />
<br /><span>Nastavení</span>
</a></div>
<?
if(@$_GET['nastaveni']=="true"){?>
  <div class="text">
    <h2>Nastavení</h2>
    <form method="GET" action="?">
      <ul>
        <li><label for="pocet">Zobrazovaný počet trojúhelníků</label><input id="pocet" name="pocet" type="text" value="158"></li>
        <li><label for="pythagorejske">Zobrazovat Pythagorejské?</label><input id="pythagorejske" name="pythagorejske" type="checkbox" checked></li>
        <li><label for="heronovy">Zobrazovat Heronovy?</label><input id="heronovy" name="heronovy" type="checkbox" checked></li>
        <li><label for="babylonske">Zobrazovat Babylonské?</label><input id="babylonske" name="babylonske" type="checkbox" checked></li>
        <li><label for="primitivni">Zobrazovat pouze primitivní?</label><input id="primitivni" name="primitivni" type="checkbox"></li>
        <li><label for="rovnostranne">Zobrazovat rovnostranné?</label><input id="rovnostranne" name="rovnostranne" type="checkbox" checked></li>
        <li><input type="submit" value="Nastavit" class="but"></li>
      </ul>
      <hr />
    </form>
    <a class="but" href="?">Původní nastavení</a>
  </div>
<?}
elseif(@!empty($_GET['trojuhelnik'])){
  $s = explode("-", $_GET['trojuhelnik']);
  if(is_numeric($s[0]) and is_numeric($s[1]) and is_numeric($s[2])){?>
    <div class="text">
      <h2>Trojúhelník <? echo $s[0].", ".$s[1].", ".$s[2]; ?> <!--(zvětšeno <? echo number_format(450/max($s), 2); ?>x)--></h2>
      <img src="/trojimg.php?trojuhelnik=<? echo pripravStrany(array($s[0], $s[1], $s[2])); ?>" />
    <a class="but" href="?">Zpět na tabulku</a>
    </div>
  <?}
}
elseif(@$_GET['primitivnitext']=="true"){?>
  <div class="text">
    <h2>Primitivní trojúhelník</h2>
    <p>Za primitivní označujeme jakýkoliv trojúhelník, jehož strany jsou nesoudělné:<br /> jejich největší společný dělitel je 1.</p>
    <p>To znamená, že když podělíme všechny strany jejich největším společným dělitelem (NSD), dostaneme délky stran, které již označujeme primitivní.</p>
    <p>NEprimitivní trojúhelníky tedy mají strany o délkách: k*a, k*b, k*c (k>1). Všechny trojúhelníky o stejných základech (a, b, c), ale různých koeficientech (k) jsou si navzájem podobné.</p>
    <a class="but" href="?">Zpět na tabulku</a>
  </div>
<?}
elseif(@$_GET['pythagorejskytext']=="true"){?>
  <div class="text">
    <h2>Pythagorejský trojúhelník</h2>
    <p>Pythagorova věta: Obsah čtverce sestrojeného nad přeponou (nejdelší stranou) pravoúhlého rovinného trojúhelníku je roven součtu obsahů čtverců nad jeho odvěsnami (dvěma kratšími stranami).</p>
    <img src="http://upload.wikimedia.org/math/8/a/d/8ad7b37b7645e84dabcca0e02b9fed6b.png" /><img src="http://upload.wikimedia.org/wikipedia/commons/thumb/d/d2/Pythagorean.svg/180px-Pythagorean.svg.png" />
    <p>Všechny tyto trojúhelníky mají pravý úhel proti přeponě.</p>
    <p>O Pythagorejských číslech mluvíme tehdy, pokud splňují výše uvedený vztah (definici) a zároveň jsou celočíselná: (3,&nbsp;4,&nbsp;5), (5,&nbsp;12,&nbsp;13), (8,&nbsp;15,&nbsp;17).</p>
    <p>Pythagorejská čísla se dají generovat z těchto vztahů: <img src="http://upload.wikimedia.org/math/4/2/d/42dd0a2f46ecd12cce4ebd491d8cfc7f.png" /></p><p>x, y jsou přirozená čísla a platí: x>y</p>
    <a class="but" href="?">Zpět na tabulku</a>
  </div>
<?}
elseif(@$_GET['heronuvtext']=="true"){?>
  <div class="text">
    <h2>Heronův trojúhelník</h2>
    <p>Za Heronovy trojúhelníky označujeme všechny trojúhelníky s celočíselným obsahem.</p>
    <p>Trojúhelníky mají název odvozený od Heronova vzorce pro obsah: <img src="http://upload.wikimedia.org/math/0/8/2/082893113f0eab4d3ad37498ee2ef06b.png" /><br /><img src="http://upload.wikimedia.org/math/2/6/d/26d0158bf0356db97190ae4e6dfa242d.png" /></p>
    <a class="but" href="?">Zpět na tabulku</a>
  </div>
<?}
elseif(@$_GET['babylonskytext']=="true"){?>
  <div class="text">
    <h2>Babylonský trojúhelník</h2>
    <p>Babylonské trojúhelníky jsou definovány vztahem: a^2 + b^2 = 2*c^2.</p>
    <p>Jsou to tedy všechny rovnostranné trojúhelníky + další náhodné: (7,&nbsp;13,&nbsp;17), (7,&nbsp;17,&nbsp;23), (17,&nbsp;25,&nbsp;31), (23,&nbsp;37,&nbsp;47)&hellip; </p>
    <a class="but" href="?">Zpět na tabulku</a>
  </div>
<?}
else{

$set_pocet = 158;
if(isset($_GET['pocet'])){
  $sql_where = "";
  
  if(isset($_GET['pocet']) and is_numeric($_GET['pocet']) and $_GET['pocet']>0){
    $set_pocet = $_GET['pocet'];
  }
  if(@$_GET['pythagorejske']!="on"){
    $sql_where .= " and (`pythagorejsky`='0')";
  }
  if(@$_GET['heronovy']!="on"){
    $sql_where .= " and (`heronuv`='0')";
  }
  if(@$_GET['babylonske']!="on"){
    $sql_where .= " and (`babylonsky`='0')";
  }
  if(@$_GET['primitivni']=="on"){
    $sql_where .= " and (`primitivni`='1')";
  }
  if(@$_GET['rovnostranne']!="on"){
    $sql_where .= " and (`a`!=`b` and `b`!=`c`)";
  }
}
else $sql_where = "";
$vysledek = $mysqli->query("SELECT * FROM `trojuhelniky` WHERE 1{$sql_where} LIMIT {$set_pocet}");

?>


<table border='0' bordercolor='red' cellpadding='0' cellspacing='0'>
<tr><th>a, b, c</th><th><a class="but" href="?primitivnitext=true">Primitivní <span>(základ)</span></a></th>
<th><a class="but" href="?pythagorejskytext=true">Pythagorejský</a></th>
<th><a class="but" href="?heronuvtext=true">Heronův <span>(obsah)</span></a></th>
<th><a class="but" href="?babylonskytext=true">Babylonský</a></th>
</tr>

<?
while ($t = $vysledek->fetch_assoc()){

  $obr = "<img src='/checkmark_blue.png' />";
/*
$class = "";
if($t['primitivni'])    $class .= " primitivni";
if($t['rovnostranny'])  $class .= " rovnostranny";
if($t['sestrojit'])     $class .= " sestrojit";
if($t['pythagorejsky']) $class .= " pythagorejsky";
if($t['heronuv'])       $class .= " heronuv";
if($t['babylonsky'])    $class .= " babylonsky";
*/
  echo "<tr>";
//echo "<tr class='{$class}'>";
    echo "<td>";
    if($t['sestrojit']) echo "<a class='but' href='?trojuhelnik={$t['a']}-{$t['b']}-{$t['c']}'>";
    echo $t['a'].", ";
    echo $t['b'].", ";
    echo $t['c'];
    if($t['sestrojit']) echo "</a>";
    echo "</td>";

    if($t['primitivni']) echo "<td>$obr</td>";
    else echo "<td><span>(".$t['primitivni-strany'].")</span></td>";

        if($t['pythagorejsky']) echo "<td>$obr</td>";
        else echo "<td></td>";
        
        if($t['heronuv']) echo "<td>$obr <span>({$t['obsah']})</span></td>";
        else echo "<td></td>";
        
        if($t['babylonsky']) echo "<td>$obr</td>";
        else echo "<td></td>";
      
  echo "</tr>\n";
}

echo '</table>';

$vysledek->free_result();

} // konec výpisu
?>

<div id="paticka">

<p>Pro <a href="http://mates.upol.cz/">MATES</a> vytvořil © Ondřej Švec 2010, Septima A, Gymnázium Uherské Hradiště</p> 

</div>

</body>
</html>