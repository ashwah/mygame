<?php
define('BOARD_COLS', 16);
define('BOARD_ROWS', 16);
define('CIRCLE_RADIUS', 50);
define('COLOR1', '#FFE680');
define('COLOR2', '#0066FF');
define('COLOR3', 'fuchsia');

function render_circle($row_num, $col_num) {
  $class = ($row_num + $col_num & 1 ? 'color1' : 'color2');
  $class .= ' circle';
  $left = $col_num * CIRCLE_RADIUS;
  $top  = $row_num * CIRCLE_RADIUS;
  $style = "left:${left}px;top:${top}px;";
  $markup = "<div class=\"$class\" style=\"$style\"></div>\n\r";
  return $markup;
}

function render_square($row_num, $col_num) {
  // A 'square' consists of two div one in front which is clickable
  // and one behind with the colour.
  $left = $col_num * CIRCLE_RADIUS + (CIRCLE_RADIUS / 2);
  $top  = $row_num * CIRCLE_RADIUS + (CIRCLE_RADIUS / 2);
  
  // In front div
  $class = 'squaref';
  $style = "left:${left}px;top:${top}px;";
  $id = 'square' . $row_num . "-" . $col_num;
  $markup = "<div id=\"$id\"class=\"$class\" style=\"$style\"></div>\n\r";
  
  // Behind div
  $class = 'squareb color3';
  $style = "left:${left}px;top:${top}px;";
  $id = 'square' . $row_num . "-" . $col_num . "b";
  $markup .= "<div id=\"$id\"class=\"$class\" style=\"$style\"></div>\n\r";
  return $markup;
}

function render_board() {
 for ($row = 1; $row <= BOARD_ROWS; $row++){
   for ($col = 1; $col <= BOARD_COLS; $col++){
     print render_circle($row, $col);
     if($col != BOARD_COLS && $row != BOARD_ROWS){
       print render_square($row, $col);
     }
   }
 } 
}

?>
<html>
  <head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
      $(document).ready(function(){
          
        $("div").click(function(){
          var behind_id;
        	behind_id = "#" + this.id + "b";
          if($(behind_id).hasClass('color3')) {
        	  $(behind_id).removeClass('color3');
        	  $(behind_id).addClass('color1');
          }    
          else if($(behind_id).hasClass('color1')) {
        	  $(behind_id).removeClass('color1');
        	  $(behind_id).addClass('color2');
          }          
          else if($(behind_id).hasClass('color2')) {
        	  $(behind_id).removeClass('color2');
        	  $(behind_id).addClass('color3');
          }
        });
      });
    </script>
    <style>
      div, html{
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .circle{
        position: absolute;
        width: <?=CIRCLE_RADIUS?>px;
        height: <?=CIRCLE_RADIUS?>px;
        border-radius: 50%;
      }
      .squareb{
        position: absolute;
        z-index: -1;
        width: <?=CIRCLE_RADIUS?>px;
        height: <?=CIRCLE_RADIUS?>px;
      }
      .squaref{
        position: absolute;
        z-index: 1;
        width: <?=CIRCLE_RADIUS?>px;
        height: <?=CIRCLE_RADIUS?>px;
      }      
      .color1{
        background-color: <?=COLOR1?>;
      }
      .color2{
        background-color: <?=COLOR2?>;
      }
      .color3{
        background-color: <?=COLOR3?>;
      }
      </style>
  </head>
  <body>
    <?php print render_board(); ?>
  </body>
</html>
