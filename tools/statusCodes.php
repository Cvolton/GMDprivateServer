<html><body><h1>STATUS CODES INFO</h1>
<form action="statusCodes.php" method="get">Status code: <input type="text" name="status"><input type="submit" value="Go"></form>
<a href="https://msdn.microsoft.com/en-us/library/windows/desktop/ms681381(v=vs.85).aspx">Click here for error codes on launchers 1.2 to 1.5 BETA</a>

<?php

if (!empty($_GET['status']))
{
	$status = (int)($_GET['status']);
	if ($status & 1)
	{
		echo "<p>ERR_BAD_CREDENTIALS - Failed to make session.</p>";
	}
	if ($status & 2)
	{
		echo "<p>ERR_ACCESS_DENIED - Error changing texture pack, try running as admin.</p>";
	}
	
	switch (($status >> 2) - 1)
	{
	case 0:
		echo "<p>0 - The operating system is out of memory or resources. (Close other applications & processes on your computer).</p>";
		break;
	case 1:
		echo "<p>ERROR_FILE_NOT_FOUND - The specified file was not found. (Try changing launch path).</p>";
		break;
	case 2:
		echo "<p>ERROR_PATH_NOT_FOUND - The specified path was not found. (Try changing launch path).</p>";
		break;
	case 3:
		echo "<p>ERROR_BAD_FORMAT - The .exe file is invalid (non-Win32 .exe or error in .exe image). (Try reinstalling w/ antivirus software turned off).</p>";
		break;
	case 4:
		echo "<p>SE_ERR_ACCESSDENIED - The operating system denied access to the specified file. (Try running as admin).</p>";
		break;
	case 5:
		echo "<p>SE_ERR_ASSOCINCOMPLETE - The file name association is incomplete or invalid.</p>";
		break;
	case 6:
		echo "<p>SE_ERR_DDEBUSY - The DDE transaction could not be completed because other DDE transactions were being processed.</p>";
		break;
	case 7:
		echo "<p>SE_ERR_DDEFAIL - The DDE transaction failed.</p>";
		break;
	case 8:
		echo "<p>SE_ERR_DDETIMEOUT - The DDE transaction could not be completed because the request timed out.</p>";
		break;
	case 9:
		echo "<p>SE_ERR_DLLNOTFOUND - The specified DLL was not found. (Try reinstalling w/ antivirus software turned off).</p>";
		break;
	case 10:
		echo "<p>SE_ERR_FNF - The specified file was not found. (Try changing launch path).</p>";
		break;
	case 11:
		echo "<p>SE_ERR_NOASSOC - There is no application associated with the given file name extension. This error will also be returned if you attempt to print a file that is not printable. (Your PC is unable to support EXE files?).</p>";
		break;
	case 12:
		echo "<p>SE_ERR_OOM - There was not enough memory to complete the operation. (Close other applications & processes on your computer).</p>";
		break;
	case 13:
		echo "<p>SE_ERR_PNF - The specified path was not found. (Try running as admin or changing launch path).</p>";
		break;
	case 14:
		echo "<p>SE_ERR_SHARE - A sharing violation occurred. (Try running as admin).</p>";
		break;
	}
}

?>

</body></html>