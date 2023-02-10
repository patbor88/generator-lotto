<?php
function extractLowest(&$numsArr){
	$l = count($numsArr);
	$min = $numsArr[0];
	$index = 0;
	$newArr = array();
	if($l > 1){
		for($i = 1; $i < $l; $i +=1){
			if($numsArr[$i] < $min){
				$index = $i;
				$min = $numsArr[$i];
			}
		}
		for($i = 0; $i < $l; $i +=1){
					
			if($i != $index){
				$newArr[] = $numsArr[$i];
			}
		}
	}
	$numsArr = $newArr;
	
	return $min;
}
function pickLottoNumbers($qty, $minRange, $maxRange){
	$sortedNumsArr = array();
	$unsortedNumsArr = array();
	for($i = 0; $i < $qty; $i +=1 ){
		$isFound;
		do{
			$rand = rand($minRange, $maxRange);
			$isFound = in_array($rand, $unsortedNumsArr);
		}while($isFound);									
															
		$unsortedNumsArr[] = $rand;			
	}
	do{
		$sortedNumsArr[] = extractLowest($unsortedNumsArr);
	}while( count($unsortedNumsArr));

	$l = count($sortedNumsArr);
	$sNums = "";
	for($i = 0; $i < $l; $i +=1){
		$sNums .= $sortedNumsArr[$i];
		if($i+1 < $l){
			$sNums .= ", ";
		}
	}
	$spc = "                                                                 ";
	$l = strlen($sNums);
	if($l < 80){
		$sNums .= substr($spc, 0, 80 - $l);
	}
	return $sNums;
}
?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Lotto</title>
	<style type="text/css" title="text/css" media="all">
		label {
			font-weight: bold;
			color: #300ACC;
		}
	</style>
</head>
<body>
<?php
		if (isset($_REQUEST['min'])) {
			$min = $_REQUEST['min'];
		} else {
			$min = 1;
		}

		if (isset($_REQUEST['max'])) {
			$max = $_REQUEST['max'];
		} else {
			$max = 49;
		}
		if (isset($_REQUEST['qty'])) {
			$qty = $_REQUEST['qty'];
		} else {
			$qty = 6;
		}

?>
	<div align="center">
	<table border="0" width="56%">
		<tr>
			<td>
				<form action="lotto.php" method="post" accept-charset="utf-8">
					<fieldset>
						<legend>Generator Lotto: </legend>
						
						<p><label>
							Cyfry z zakresu od: <input type="number" name="min" size="20" maxlength="40" value =<?php echo $min; ?> autofocus />
						</label></p>
						<p><label>
							Do: <input type="number" name="max" size="40" maxlength="40" value = <?php echo $max; ?> />
						</label></p>
						<p><label>
							Ilosc pilek z numerami: <input type="number" name="qty" size="40" maxlength="40" value = <?php echo $qty; ?> />
						</label></p>

					</fieldset>
					<p align="center">
						<input type="submit" name="submit" value="Losuj numery lotto" />
					</p>
				</form>
			</td>
		</tr>
		<tr><td>
		<?php
			if ($min && $max && $qty) {
				echo "<p align=\"center\">";
				echo "Wylosowano:<br><b>". pickLottoNumbers($qty, $min, $max)."</b>";
			} else {
				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					echo '<p><b>Musisz wypelnic 3 pola by generator zadzialal.</b></p>';
				}
			}
		?>
		</td>

	</table>
</div>
</body>
</html>