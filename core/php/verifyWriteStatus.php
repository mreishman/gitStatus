<?php

function checkForUpdate($filePath)
{
	mkdir("test");

	if(!file_exists("test"))
	{
		if(!isset($_POST['location']))
		{
			header('Location: '."../templateFiles/error.php?error=550&page=".$filePath, TRUE, 302); /* Redirect browser */
			exit();
		}
	}
	if(is_dir("test"))
	{
		try 
		{
			rmdir("test");
		}
		catch (Exception $e) 
		{
			
		}
		
	}
}
?>