<?php function accountdropdown($where,$which,&$accounts,&$page){

	echo "<select name=\"" . $where . "account\">\n";
	$i=1;
	while($accounts[$i]){
		echo "\t<option value=\"".$i."\"";
		selected($i,$page,$which);
		echo ">".$accounts[$i++]."</option>\n";
	}
	echo "</select>\n";
}
?>