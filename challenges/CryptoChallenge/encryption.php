  <?php

function encrypt($input) {
    //set output to stop errors from showing
    $output = "";
    
    //get the length of the string once to aid in efficency
    $str_len = strlen($input);
    
    //encryption loop
    for($i=0;$i<$str_len;$i++) {
        //get the ascii value of the current character
        $cur_char = ord(substr($input,$i,1));

        if($cur_char > 33 && $cur_char < 122) {
  
            $cur_char = $cur_char - 34;
  
            $cur_char = ($cur_char + $i)%88 + 34;
            
        }
        
        $output .= chr($cur_char);
    } //end for
    return $output;
}
	echo "<html>";
	echo "<head>";
	echo "</head>";
	echo "<center>";
	echo "<body bgcolor='black'>";
	echo "<br>";
	echo "<p style='color:white'>The encrypted text is: " . encrypt($_POST["text"]) . "</p>";
	echo "</center>";
	echo "</body>";
	echo "</html>";

    ?> 
