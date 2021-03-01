<?php
    function h($str) {
      return htmlspecialchars($str, ENT_QUOTES, "UTF-8mb4");
    }

    function filter($str){
      return filter_input(INPUT_POST, $str);
    }
?>