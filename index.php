<?php

function createForm(): string
{

	$form = '
	<div>
        <form method="post" action="' . $_SERVER['PHP_SELF'] . '">
			<input name="cnp" type="text">
			<input type="submit" name="Validate" value="Validate"><br>
        </form>
    </div>';

	return $form;
}

function isCnpValid(string $cnp): bool
{

	if (!$cnp) {
		return false;
	}

	if (strlen($cnp) != 13) {
		return false;
	}

	if (!is_numeric($cnp)) {
		return false;
	}

	if ($cnp[0] == 0) {
		return false;
	}

	if (($cnp[3] * 10 + $cnp[5]) > 12 || ($cnp[3] * 10 + $cnp[5]) == 0) {
		return false;
	}

	if (($cnp[5] * 10 + $cnp[6]) > 31 || ($cnp[5] * 10 + $cnp[6]) == 0) {
		return false;
	}

	if (($cnp[5] * 10 + $cnp[6]) > 52 || ($cnp[5] * 10 + $cnp[6]) == 52) {
		return false;
	}

	$control_num = "279146358279";
	$control_sum = 0;

	for ($i = 0; $i < 12; $i++) {
		$control_sum += $cnp[$i] * $control_num[$i];
	}

	$control_check = $control_sum % 11;

	if ($control_check == 10 && $cnp[12] != 1) {
		return false;
	}

	if ($control_check != $cnp[12]) {
		return false;
	}

	return true;

}

if (isset($_SERVER['argv'][1])) {
	echo (isCnpValid($_SERVER['argv'][1])) ? "cnp is valid \n" : "cnp is not valid \n";
} elseif (isset($_POST['cnp'])) {
	echo (isCnpValid(trim($_POST['cnp']))) ? "cnp is valid \n" : "cnp is not valid \n";
} else {
	echo createForm();
}

