<?php

/** SUDOKU GENERATOR
 *  Simple sudoku class generator.
 *  
 *  You can set to 9 level difficulty.
 *  You can display the solution.
 * 
 *  Copyright Bartosz Karallus 2015.
 *  Contact info@eltitobarte.com.
 * 
 *  ========================================================
 * 
 *  Instructions:
 * 
 *  include the file sudoku.php on your PHP code,
 *  create variable and declare the class ( $sudoku = new sudoku( $level ); ),
 *  type in $level variable the level that you want to use, if you leave empty the
 *  default level will be 0.
 * 
 *  then generate the puzzle using ( $sudoku->generate(); ).
 * 
 *  if you want to show solution include ( $sudoku->solution(); )
 * 
 *  that's all. Thanks.
 * 
 *  ========================================================
 */

class sudoku {
    
    private $block = array();
    private $mask = array();
    private $rand = "";
    private $coli = 0;
    
    private $Reg = array();
    private $Lgn = array();
    private $col = array();
    
    private $dif = 0;
    private $dif_max = 10;
    
    public function sudoku($level = 0){
        
        $this->dif = $level;
        
        $this->ini();
        while(strlen($this->rand) > 0 && $this->dif < $this->dif_max){
            $this->dif++;
            $this->ini();
            $iter = 0;
            $itermax = 82;
            while($this->rand <> "" && $iter < $itermax){
                $iter++;
                
                $bingo = 0;
                for($n = 0; $n <= 8; $n++){
                    for($m = 0; $m <= 8; $m++){
                        if(strlen($this->Reg[$n][$m]) == 1){
                            $p = ord($this->Reg[$n][$m]) - 48;
                            $i = floor($n/3) * 3 + floor($p/3);
                            $j = ($n - floor($n/3) * 3) * 3 + ($p - floor($p/3) * 3);
                            $this->affectation($i, $j, $m, "1");
                            $bingo = 1;
                            break;
                        }
                        
                        if(strlen($this->Lgn[$n][$m]) == 1){
                            $p = ord($this->Lgn[$n][$m]) - 48;
                            $i = $n;
                            $j = $p;
                            $this->affectation($i, $j, $m, "1");
                            $bingo = 1;
                            break;
                        }
                        
                        if(strlen($this->col[$n][$m]) == 1){
                            $p = ord($this->col[$n][$m]) - 48;
                            $i = $p;
                            $j = $n;
                            $this->affectation($i, $j, $m, "1");
                            $bingo = 1;
                            break;
                        }
                    }
                    
                    if($bingo == 1){ break; }
                    
                }

                if($bingo == 0){
                    $ncase2 = strlen($this->rand);
                    $ncase = strlen($this->rand) / 2;
                    $index = rand(0, $ncase - 1) * 2;
                    $posi = substr($this->rand, $index, 2);
                    
                    $i = ord(substr($posi,0)) - 97;
                    $j = ord(substr($posi,1)) - 48;
                    
                    $liste = "";
                    for($m = 0; $m <= 8; $m++){
                        $free = 1;
                        
                        $n = floor($i/3) * 3 + floor($j/3);
                        if($this->Reg[$n][$m] == ""){ $free = 0; }
                        
                        $n = $i;
                        if($this->Lgn[$n][$m] == ""){ $free = 0; }
                        
                        $n = $j;
                        if($this->col[$n][$m] == ""){ $free = 0; }
                        
                        if($free == 1){ $liste = $liste.chr(48 + $m); }
                    }
                    
                    if(strlen($liste) > 0){
                        $m = ord(substr($liste, floor(rand(0, strlen($liste) - 1)))) - 48;
                        $this->affectation($i, $j, $m, "0");
                    }
                    
                }

            }
        }
        
    }

    public function generate(){
        
        $puzzle = $this->puzzle();
        
        echo "<table style='border-collapse:collapse;border-spacing:0;border:3px solid #000;'>";
        
        for($i = 0; $i < 9;$i++){
            if($i == 2 || $i == 5){ $ts = 'style="border-bottom:3px solid #000;"'; }else{ $ts = ''; }
            echo "<tr $ts>";
            for($j = 0; $j < 9; $j++){
                if($j == 2 || $j == 5){ $td = 'border-right:3px solid #000;';}else{ $td = ''; }
                echo "<td style='width:40px;height:40px;text-align:center;border:1px solid #000;font-size: 30px;$td'>".$puzzle[$i][$j]."</td>";
            }
            echo "</tr>";
        }
        
        echo "</table>";
        
    }
    
    public function solution(){
        
        $puzzle = $this->block;
        
        echo "<table style='border-collapse:collapse;border-spacing:0;border:3px solid #000;'>";
        
        for($i = 0; $i < 9;$i++){
            if($i == 2 || $i == 5){ $ts = 'style="border-bottom:3px solid #000;"'; }else{ $ts = ''; }
            echo "<tr $ts>";
            for($j = 0; $j < 9; $j++){
                if($j == 2 || $j == 5){ $td = 'border-right:3px solid #000;';}else{ $td = ''; }
                echo "<td style='width:40px;height:40px;text-align:center;border:1px solid #000;font-size: 30px;$td'>".$puzzle[$i][$j]."</td>";
            }
            echo "</tr>";
        }
        
        echo "</table>";
        
    }
    
    private function ini(){
        
        $this->rand = "";
        $this->coli = 0;
        
        for($i = 0; $i <= 8; $i++){
            for($j = 0; $j <= 8; $j++){
                $this->block[$i][$j] = "0";
                $this->mask[$i][$j] = 0;
                $this->rand = $this->rand.chr(97+$i).chr(48+$j);
            }
        }
        
        for($n = 0; $n <= 8; $n++){
            for($m = 0; $m <= 8; $m++){
                $this->Reg[$n][$m] = "012345678";
                $this->Lgn[$n][$m] = "012345678";
                $this->col[$n][$m] = "012345678";
            }
        }
        
    }
    
    private function elimination($i,$j,$m){
        $n = floor($i/3) * 3 + floor($j/3);
        $this->Reg[$n][$m] = "";
        $n = $i;
        $this->Lgn[$n][$m] = "";
        $n = $j;
        $this->col[$n][$m] = "";
        
        for($n = 0; $n <= 8; $n++){
            for($p = 0; $p <= 8; $p++){
                $ic = floor($n/3) * 3 + floor($p/3);
                $jc = ($n - floor($n/3) * 3) * 3 + ($p - floor($p/3) * 3);
                if($ic == $i || $jc == $j){
                    $posi = chr(48 + $p);
                    $this->Reg[$n][$m] = str_replace($posi, "", $this->Reg[$n][$m]);
                }
            }
        }
        
        $posi = chr(48 + $j);
        for($n = 0; $n <= 8; $n++){
            $this->Lgn[$n][$m] = str_replace($posi,"", $this->Lgn[$n][$m]);
        }
        
        $posi = chr(48 + $i);
        for($n = 0; $n <= 8; $n++){
            $this->col[$n][$m] = str_replace($posi, "", $this->col[$n][$m]);
        }
        
        $n = floor($i/3) * 3 + floor($j/3);
        for($p = 0; $p <= 8; $p++){
            $ic = floor($n/3) * 3 + floor($p/3);
            $jc = ($n - floor($n/3) * 3) * 3 + ($j - floor($j/3) * 3);
            $posi = chr(48 + $jc);
            $this->Lgn[$ic][$m] = str_replace($posi, "", $this->Lgn[$ic][$m]);
            $posi = chr(48 + $ic);
            $this->col[$jc][$m] = str_replace($posi, "", $this->col[$jc][$m]);
        }
        
        for($mc = 0; $mc <= 8; $mc++){
            $n = floor($i/3) * 3 + floor($j/3);
            $p = ($i - floor($i/3) * 3) * 3 + ($j - floor($j/3) * 3);
            $posi = chr(48 + $p);
            $this->Reg[$n][$mc] = str_replace($posi, "", $this->Reg[$n][$mc]);
            
            $posi = chr(48 + $j);
            $this->Lgn[$i][$mc] = str_replace($posi, "", $this->Lgn[$i][$mc]);
            
            $posi = chr(48 + $i);
            $this->col[$j][$mc] = str_replace($posi, "", $this->col[$j][$mc]);
        }
    }
    
    private function affectation($i, $j, $m, $D){
        if($this->block[$i][$j] == "0"){
            $this->block[$i][$j] = chr(48 + $m + 1);
            $posi = chr(97 + $i).chr(48 + $j);
            $this->rand = str_replace($posi, "", $this->rand);
            $this->elimination($i,$j,$m);
            if($D == "1"){ $this->mask[$i][$j] = 1; }
        }else{
            $this->coli++;
        }
    }
    
    private function puzzle(){
        
        $cut = $this->mask;
        $puzzle = array();
        
        for($i = 0; $i < 9; $i++){
            for($j = 0; $j < 9; $j++){
                if($cut[$i][$j] == 0){
                    $puzzle[$i][$j] = "";
                }else{
                    $puzzle[$i][$j] = $this->block[$i][$j];
                }
            }
        }
        
        return $puzzle;
        
    }
    
}
