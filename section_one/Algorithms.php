<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>playFair algo 'الجوريثم يعنى'</title>
    <!-- Bootstrap core CSS -->
    <link href="bootstrap.min.css" rel="stylesheet">
  </head>
  <body>

<?php

define ('alphas' , range('A', 'Z')); // create alphabit array
if ($_POST['type'] == 'encrypt') {
    switch ($_POST['algorithm']) {
        case 'autokey':
            autoEncryption($_POST['msg'],$_POST['Key']);
            break;
        case 'caesar':
            caesarEncrypt($_POST['msg'],$_POST['Key']);
            break;
        case 'vigenere':
            vigenereEncryption($_POST['msg'],$_POST['Key']);
            break;
        default:
        echo '<h4 class ="text-center"> please choose an Algorithm</h4>';
            break;
    }
} elseif($_POST['type'] == 'decrypt') {
    switch ($_POST['algorithm']) {
        case 'autokey':
            autoDecryption($_POST['msg'],$_POST['Key']);
            break;
        case 'caesar':
            caesarDecrypt($_POST['msg'],$_POST['Key']);
            break;
        case 'vigenere':
            vigenereDecryption($_POST['msg'],$_POST['Key']);
            break;
        default:
        echo '<h4 class ="text-center"> please choose an Algorithm</h4>';
            break;
    }
} else echo '<h4 class ="text-center"> please choose an operation type</h4>';

//-------------------------------------autokey Encryption ---------------------------------
 function autoEncryption(string $msg, string $key) 
 { 
   
    $len = strlen( $msg );

    // generating the keystream 
    $newkey;
    if (strlen($msg) > strlen($key))
        $newkey=$key.substr($msg,0, strlen($msg) - strlen($key));
    $newKey = str_split($newkey,1);
    $encryptMsg = ""; 

    // applying encryption algorithm 
    for ($x = 0; $x < $len; $x++) { 
        $first = array_search(strtoupper($msg[$x]), alphas); 
        $second= array_search(strtoupper($newKey[$x]), alphas);
        $total = ($first + $second) % 26; 
        $encryptMsg .= alphas[$total]; 
    } 
    encryptionResult($msg,$key,$newKey,$encryptMsg);
 }
 
 
 //-------------------------------------autokey Decryption ---------------------------------
function autoDecryption($msg, $key)
{
     $currentKey = $key;
     $decryptMsg = ""; 

    // applying decryption algorithm 
    for ($x = 0; $x < strlen($msg); $x++) { 
        $get1 =  array_search(strtoupper($msg[$x]), alphas); 
        $get2 =  array_search(strtoupper($currentKey[$x]), alphas); 
        $total = ($get1 - $get2) % 26; 
        $total = ($total < 0) ? $total + 26 : $total; 
        $decryptMsg .= alphas[$total];
        $currentKey = ($x >= strlen($msg)-strlen($key)) ? $currentKey : $currentKey .= alphas[$total];  ; 
        
    } 
    decryptionResult($msg,$key,$currentKey,$decryptMsg);
}


//------------------------------------- prepare vigenere Key ---------------------------------
function VigenereKey($msg, $key)
{
    $newkey= $key;
    do{
        if (strlen($msg) > strlen($newkey))
        $newkey .= $key;
        else
         break;
    } while(strlen($newkey) < strlen($msg));
    $newkey = substr($newkey,0,strlen($msg));
    return $newkey;
}


 //-------------------------------------vigenere Encryption ---------------------------------
 function VigenereEncryption(string $msg, string $key) 
 { 
    // echo 'key: '.$key.'    MSG: '.$msg.'<br>';
    $len = strlen( $msg );
    
    // generating the keystream 
    $newkey= VigenereKey($msg, $key);
    $newKey = str_split($newkey);
    $encryptMsg = ""; 

    // applying encryption algorithm 
    for ($x = 0; $x < $len; $x++) { 
        $first = array_search(strtoupper($msg[$x]), alphas); 
        $second= array_search(strtoupper($newKey[$x]), alphas);
        $total = ($first + $second) % 26; 
        $encryptMsg .= alphas[$total]; 
    } 
    encryptionResult($msg,$key,$newKey,$encryptMsg);
 } 


 //-------------------------------------vigenere Decryption ---------------------------------
function vigenereDecryption($msg, $key)
{
    $currentKey = VigenereKey($msg,$key);
    $decryptMsg = ""; 

   // applying decryption algorithm 
   for ($x = 0; $x < strlen($msg); $x++) { 
       $get1 =  array_search(strtoupper($msg[$x]), alphas); 
       $get2 =  array_search(strtoupper($currentKey[$x]), alphas); 
       $total = ($get1 - $get2) % 26; 
       $total = ($total < 0) ? $total + 26 : $total; 
       $decryptMsg .= alphas[$total];
       
   } 
   decryptionResult($msg,$key,$currentKey,$decryptMsg);
}


//-------------------------------- Cipher Technique--------------------------------------
function caesarEncrypt($msg, $s) 
{ 
	$result = ""; 
	for ($i = 0; $i < strlen($msg); $i++) 
	{ 
		if (ctype_upper($msg[$i])) 
			$result = $result.chr((ord($msg[$i]) + $s - 65) % 26 + 65); 
	// Encrypt Lowercase letters 
	else
		$result = $result.chr((ord($msg[$i]) + 
						$s - 97) % 26 + 97); 
	} 
	echo'<h4 class ="text-center"> Encrypt Message:   '.$result.'</h4>'; 
}


function caesarDecrypt($msg, $s) 
{ 
	$result = ""; 
	for ($i = 0; $i < strlen($msg); $i++) 
	{ 
		if (ctype_upper($msg[$i])) 
			$result = $result.chr((ord($msg[$i]) - $s - 65) % 26 + 65); 
	// Encrypt Lowercase letters 
	else
		$result = $result.chr((ord($msg[$i]) - $s - 97) % 26 + 97); 
	} 
	echo'<h4 class ="text-center"> Decrypt Message:   '.$result.'</h4>'; 
}


function encryptionResult($msg,$key,$currentKeys,$encryptMsg)
{
    echo'
    <div class ="row text-center">
    <div class="col-lg-3"></div>
    <div class="col-lg-6 ">
        <table class="table">
        <tbody>
            <tr> <td>Input Message </td>
            <td><i>'.$msg.'</i></td></tr>
            <tr><td>Input Key </td>
            <td><i>'.$key.'</i></td></tr>
            <tr><td>Used Key</td>
            <td><i>';foreach($currentKeys as $currentKey)echo $currentKey;echo'</i></td></tr>
            <tr> <td>Encrypted Message </td> 
            <td><i>'.$encryptMsg.'</i></td></tr>
        </tbody>
        </table>
    </div>
    </div>';

}




function decryptionResult($msg,$key,$currentKeys,$decryptMsg)
{
    echo'
    <div class ="row text-center">
    <div class="col-lg-3"></div>
    <div class="col-lg-6 text-center">
        <table class="table">
        <tbody>
            <tr> <td>Input Message </td>
            <td><i>'.$msg.'</i></td></tr>
            <tr><td>Input Key </td>
            <td><i>'.$key.'</i></td></tr>
            <tr><td>Used Key</td>
            <td><i>'.$currentKeys.'</i></td></tr>
            <tr> <td>Decrypted Message </td> 
            <td><i>'.$decryptMsg.'</i></td></tr>
        </tbody>
        </table>
    </div>
    </div>';

}
?> 
