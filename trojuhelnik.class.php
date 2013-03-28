<?
class trojuhelnik {

  public $strany = array();
  public $sestrojit = false;
  public $primitivni = true;
  public $primitivni_strany = array();
  public $pythagorejsky = false;
  public $heronuv = false;
  public $babylonsky = false;
  public $specialni = false;

  function __construct($a, $b, $c){
  
    // jsou délky strany čísla? když ne, vyhoď vyjímku
    if(!is_numeric($a) or !is_numeric($b) or !is_numeric($c)) throw new Exception ("A, B nebo C není číslo!");

    // vytvoř pole stran a seřaď od nejmenšího
    $this->strany = array($a, $b, $c);
    sort($this->strany);
    
    // Je trojúhelník PRIMITIVNÍ? Když ne, pokrať strany
    if(($nsd = $this->soudelne($this->strany[0], $this->strany[1], $this->strany[2]))>1){
      $this->primitivni = false;
      $this->primitivni_strany[0] = $this->strany[0]/$nsd;
      $this->primitivni_strany[1] = $this->strany[1]/$nsd;
      $this->primitivni_strany[2] = $this->strany[2]/$nsd;
    }
    
    // Lze trojúhelník SESTROJIT?
    if($this->jdeSestrojit($this->strany[0], $this->strany[1], $this->strany[2]))
      $this->sestrojit = true;

    // Je trojúhelník PYTHAGOREJSKÝ?
    if($this->pythagorejsky($this->strany[0], $this->strany[1], $this->strany[2]))
      $this->pythagorejsky = true;

    // Je trojúhelník HERONŮV?
    if(($obsah = $this->heronuv($this->strany[0], $this->strany[1], $this->strany[2]))!=false)
      $this->heronuv = $obsah;

    // Je trojúhelník BABYLONSKÝ?
    if(($typ = $this->babylonsky($this->strany[0], $this->strany[1], $this->strany[2]))!=false)
      $this->babylonsky = $typ;

    if($this->babylonsky or $this->heronuv or $this->pythagorejsky)
      $this->specialni = true;
  }

  private function soudelne($a, $b, $c){
    $values = array($a, $b, $c);
    $num_values = count($values);
    $x = current($values);
    $y = next($values);  
    for ($i = 1; $i < $num_values; $i ++){
        $a = max( $x, $y );
        $b = min( $x, $y );
        $c = 1;
        do{
            $c = $a % $b;
            $gcf = $b;
            $a = $b;
            $b = $c;     
        }
        while ($c != 0);
        $x = $gcf;
        $y = next($values);
    }
    return $gcf;
  }
  
  private function jdeSestrojit($a, $b, $c){
    $a = array($a, $b, $c);
    sort($a);
    if($a[0]+$a[1] >= $a[2]) return true;
    else return false;
  }

  private function jeCele($cislo){
    if($cislo==floor($cislo)) return true;
    else return false;
  }

  private function pythagorejsky($a, $b, $c){
    if(($a*$a)+($b*$b)==$c*$c) return true;
    else return false;
  }

  private function heronuv($a, $b, $c){
    $s = ($a + $b + $c)/2;
    $obsah = sqrt($s*($s-$a)*($s-$b)*($s-$c));
    if($this->jeCele($obsah)) return $obsah;
    else return false;
  }

  private function babylonsky($a, $b, $c){
    if(($a*$a)+($b*$b)==2*$c*$c){
      if($a==$b and $b==$c) return 2;
      else return 1;
    }
    else return false;
  }
}
?>