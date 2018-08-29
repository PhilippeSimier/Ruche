<?php

  $output = shell_exec('vcgencmd measure_temp');
  echo "<pre>$output</pre><br />";

  $output = shell_exec('vcgencmd vcos version');
  echo "<pre>$output</pre><br />";

  $output = shell_exec('uname -a');
  echo "<pre>$output</pre><br />";
?>

