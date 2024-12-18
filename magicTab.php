<?php

/* Acts as a magic tab for mods to filter rateworthy levels. This page was made using styling from the 1.3 GDPS. It may need some CSS styling added.
If it doesn't work, make sure line 6 is accurate and change the path on line 40 to the full link of your database.This tool does not include XLs as they do not exist in 1.3.*/

include "../../incl/lib/connection.php";
echo "
<form method='POST'>
    Newest <input type='radio' name='id'>&nbsp;&nbsp;&nbsp;&nbsp;
    Longest <input type='radio' name='obj'>
    <input type='submit' value='Update'>
</form>
";


if (isset($_POST['id'])) {
    $order = "levelID";
} else if (isset($_POST['obj'])) {
    $order = "levelLength";
} else {
    $order = "levelID";
}

echo "<table class='ptsTable'>
<th>ID</th><th>Name</th><th>Object count</th><th>Length</th>";
$query = $db->prepare("SELECT * FROM levels WHERE levelLength > 1 AND starStars = '0' ORDER BY $order DESC LIMIT 50");
$query->execute();
$result = $query->fetchAll();
foreach($result as &$level){
    $levelName = $level["levelName"];
    $lid = $level["levelID"];
    $levelLength = $level["levelLength"];

    if ($levelLength == 2) {
        $ll = "Medium";
    } else if ($levelLength == 3) {
        $ll = "Long";
    } else { $ll = "Error"; }

    $path = "/database/data/levels/$lid";
    $objcount = substr_count(file_get_contents($path), ";");
    $fobjcount = $objcount - 1;

    if ($fobjcount > 500) {
        echo "<tr>
        <td>$lid</td>
        <td>$levelName</td>
        <td>$fobjcount</td>
        <td>$ll</td>
        </tr>";
    }    
} 
echo "</table>";

?>
