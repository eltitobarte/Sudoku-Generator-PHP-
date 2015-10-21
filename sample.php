<?php

require('sudoku.php');

$sudoku = new sudoku();

?>

<!DOCTYPE HTML>
<html>
  <head>
    <title>SUDOKU GENERATOR</title>
    <style type="text/css">
      .sudoku {
        margin: 0 auto;
        margin-top: 100px;
      }
      .inline {
        display: inline-block;
        padding: 15px;
      }
    </style>
  </head>
  <body>
    <div class="sudoku">
      <div class="inline">
        <h3>THE PUZZLE</h3>
        <?$sudoku->generate();?>
      </div>
      <div class="inline">
        <h3>THE SOLUTION</h3>
        <?$sudoku->solution();?>
      </div>
    </div>
  </body>
</html>
