<?php

$html_base='templates/html_base.html';
$html_title="sdfdsf";

$base_template=file($html_base,FILE_SKIP_EMPTY_LINES);
$n=1;



foreach ($base_template as $val){
  echo $val;
}
