<?php
function create_form()
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

function validate_cnp()
{

    $cnp = trim($_POST['cnp']);

    if (!$cnp)
    {
        return "CNP not valid - Error: Empty value";
    }

    if (strlen($cnp) != 13)
    {
        return "CNP not valid - Error: Invalid CNP lenght";
    }

    if (!is_numeric($cnp))
    {
        return "CNP not valid - Error: Invalid CNP not numeric";
    }

    if ($cnp[0] == 0)
    {
        return "CNP not valid - Error: Invalid S";
    }

    if (($cnp[3] * 10 + $cnp[5]) > 12 || ($cnp[3] * 10 + $cnp[5]) == 0)
    {
        return "CNP not valid - Error: Invalid LL";
    }

    if (($cnp[5] * 10 + $cnp[6]) > 31 || ($cnp[5] * 10 + $cnp[6]) == 0)
    {
        return "CNP not valid - Error: Invalid ZZ";
    }

    if (($cnp[5] * 10 + $cnp[6]) > 52 || ($cnp[5] * 10 + $cnp[6]) == 52)
    {
        return "CNP not valid - Error: Invalid JJ";
    }

    $control_num = "279146358279";
    $control_sum = 0;

    for ($i = 0;$i < 12;$i++)
    {
        $control_sum += $cnp[$i] * $control_num[$i];
    }

    $control_check = $control_sum % 11;

    if ($control_check == 10 && $cnp[12] != 1)
    {
        return "CNP not valid - Error: Invalid C";
    }

    if ($control_check != $cnp[12])
    {
        return "CNP not valid - Error: Invalid C";
    }

    return "CNP is valid";

}

if (!isset($_POST['cnp']))
{
    echo create_form();
}
else
{
    echo validate_cnp();
}

?>
