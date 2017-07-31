<?php

function checkForUpdate($filePath)
{
	if(!isset($_POST['location']))
	{
		mkdir("test");

		if(!file_exists("test"))
		{
			header('Location: '."../templateFiles/error.php?error=550&page=".$filePath, TRUE, 302); /* Redirect browser */
			exit();
		}
		else
		{
			rmdir("test");
		}
	}
}
?>