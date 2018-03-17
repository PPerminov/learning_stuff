<?php
function re_recurse ($list_of_items) {
  $new_list=[];
  $next_part=[];
  $last_pos=0;
  foreach ($list_of_items as $key=>$value){
    $max_pos=$new_list[$key];
    if ($max_pos){
      foreach ($value as $subval){
        if (! $new_list[$subval]){
          foreach ($new_list as $new_key=>$new_value){
            if ($new_value >= $max_pos) {
              $next_part[$new_key] = $new_value + 1;
            } else {
              $next_part[$new_key] = $new_value;
            }
          }
          $new_list = $next_part;
          $next_part = [];
          $new_list[$subval]=$max_pos;
          $last_pos+=1;
        }
      }
    } else {
      foreach ($value as $sub_value) {
        $exp = $new_list[$sub_value];
        if ( $exp === null ){
          $new_list[$sub_value]=$last_pos;
          $last_pos+=1;
        }
      }
      $new_list[$key]=$last_pos;
      $last_pos+=1;
    }
}
  return $new_list;
}

$deps1 = [
  'mongo'=> [],
  'tzinfo'=> ['thread_safe'],
  'uglifier'=> ['execjs'],
  'execjs'=> ['thread_safe', 'json'],
  'redis'=> []
];
$deps1_test=[
'mongo' => 0,
'thread_safe' => 1,
'tzinfo' => 2,
'json' => 3,
'execjs' => 4,
'uglifier' => 5,
'redis' => 6
];
$flat_result = re_recurse($deps1);
var_dump($flat_result == $deps1_test);
?>
