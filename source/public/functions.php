<?php

    function h($str) {
      return htmlspecialchars($str, ENT_QUOTES, "UTF-8mb4");
    }

    function filter($str){
      return filter_input(INPUT_POST, $str);
    }

    // 新規投稿画面のセレクトボックス作成
    function selectOption($tableName) {
      
      global $dbs;
      $sql = 'select * from ' . $tableName;
      $stmt = $dbs->query($sql);
      $select_values = $stmt->fetchAll();
      
      foreach($select_values as $select_value) {
        $select_tags .= '<option value="' . $select_value['cook_id'] .  '">' . $select_value['cook_name'] . '</option>';
      }
      return $select_tags;
    }
?>