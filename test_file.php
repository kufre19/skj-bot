<?php

$data = "admin update status:S02345,Ready";
$data = preg_split('/:/',$data);
$new_data = preg_split('/,/',$data[1]);



print_r($data);
print_r($new_data);
// $f = 'just holder';
// $data = urlencode("way matter be \n $f fin as big $f \n cookies");
// echo $data;

