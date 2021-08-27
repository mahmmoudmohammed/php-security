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
// if (isset($_POST['type'])) 
// {
   $_POST['type'] == 'decrypt' ? decrypt($_POST['msg'],$_POST['Key']) : encrypt($_POST['msg'],$_POST['Key']);
    function encrypt($msg,$key)
    {
        $cipherText = '';
        $matrex = matrexGenerator($key);
        // echo(json_encode($matrex));
        $msg = strtoupper($msg);
        $msg = str_replace('J','I',$msg);
        $msg = str_replace(' ','',$msg);
        
        echo'
        <div class="row">';
            echo'<div class="col-lg-8">
                <table class="table">
                <thead><th> Input Message </th><td><i>'.$msg.'</i></td></thead>';

        for ($i = 0; $i <strlen($msg) ; $i++) { 
            # iff duplicated char insert X between 
            if ($msg[$i] == $msg[$i-1]) {
                # code
                $msg = substr_replace($msg,'X',$i,0);
            }
        }
        // to make sure mesage is even number -->> helping on pair
        if (strlen($msg)%2 != 0)
             $msg .= 'X';
        # create Message as a pair of two char
        echo "<tbody><td><b>Modified message: </b></td> <td><i>".$msg."</i></td></tr>";
        echo "<td><b> Pair: </b></td> <td><b>Encrypted Pair</b></td></tr>";
        $pairs = str_split($msg,2);
        // print_r($pairs);

        foreach ($pairs as $pair) {
        echo "<tr><td>".$pair."</td>";
            # get all coulum or row of pair 
            $encrypted_pair = '';
            $rows = array();
            $colums = array();
            for ($i = 0; $i < 2; $i++) { 
                for ($j = 0; $j < 5; $j++) { 
                    # code..
                    // echo' i->'.$i.'  j->'.$j;
                    if (in_array($pair[$i],$matrex[$j])) {
                        # code...
                        // echo' i->'.$i.'  j->'.$j;
                        $rows[$i] = $j;
                        // echo $rows[$i];
                        $colums[$i] = array_search($pair[$i],$matrex[$j]);
                        // echo $colums[$i];
                        break;
                    }
                }
            }
            if (isset($colums[0])&& isset($colums[1]) && $colums[0] == $colums[1] ) 
            {
                $encrypted_pair = $matrex[($rows[0]+1)%5][$colums[0]] . $matrex[($rows[1]+1)%5][$colums[1]];
            } else if (isset($rows[0])&& isset($rows[1]) && $rows[0] == $rows[1] ) 
            {
                $encrypted_pair = $matrex[$rows[0]][($colums[0]+1)%5] . $matrex[$rows[1]][($colums[1]+1)%5];
            } else if (isset($rows[0]) && isset($rows[1]) && isset($colums[0]) && isset($colums[1]))
            {
                $encrypted_pair = $matrex[$rows[0]][$colums[1]] . $matrex[$rows[1]][$colums[0]];
            }
            $cipherText .= $encrypted_pair;
            echo "<td>".$encrypted_pair."</td></tr></tbody>";

        }

        echo '<tr><td><b>Encrypted Message</b></td><td><i>'.$cipherText.'</i></td></tr></table></div>';
        echo'<div class="col-lg-4">
                <h3> Encription Matrex  </h3>';
        displayMatrex($matrex);
        echo'</div></div>';
    }

    
    function matrexGenerator($key)
    {
        $key = strtoupper($key);
        $key = str_replace('J','I',$key);
        $key = str_replace(' ','',$key);
        $matrex = array();
        for ($i=0; $i <strlen($key) ; $i++) { 
            # looping into key
            if (ord($key[$i]) >= 65 && ord($key[$i] <= 90)) {
                # chick code asci
                $found = false;
                for ($j=0; $j <count($matrex) ; $j++) { 
                    # search about char on matrex 
                    if (in_array($key[$i],$matrex[$j])) {
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    #if not found add them at empty index on matrex
                    $added = false;
                    for ($x=0; $x <5 ; $x++) {
                        for ($y=0; $y <5 ; $y++) { 
                            # code...
                            if (empty($matrex[$x][$y])) {
                                # code...
                                $matrex[$x][$y] = $key[$i];
                                $added = true;
                                break;
                            }
                        } 
                        # code...
                        if ($added) 
                            break;
                    }
                }
            }
        }
        for ($x=0; $x < 5 ; $x++) { 
            # looping on row
            for ($y=0; $y < 5 ; $y++) { 
                # looping on colums
                if (empty($matrex[$x][$y])) {
                    # code...
                    for ($charCode=65; $charCode <=90 ; $charCode++) { 
                        # looping check asci 
                        if ($charCode == 74) 
                            continue;

                        $found = false;
                        for ($j=0; $j < count($matrex) ; $j++) { 
                            # code...
                            if (in_array(chr($charCode),$matrex[$j])) {
                                $found = true;
                                break;
                            }
                        }
                        if (!$found) {
                            # code...
                            $matrex[$x][$y]= chr($charCode);
                            break;
                        }
                    }
                }
            }
        }
        return $matrex;
    } 
    function displayMatrex($matrex)
    {
        echo'<table class="table"><tbody>';
        for ($i = 0; $i <5 ; $i++) { 
            echo'<tr>';
            for ($j = 0; $j < 5 ; $j++) { 
                # code...
                echo'<td>'.$matrex[$i][$j].'</td>';
            }
            echo'</tr>';
        }
    echo'</tbody></table>';
    }


    
    function decrypt($msg,$key)
    {
        $matrex = matrexGenerator($key);
        $plainText = '';
        $msg = strtoupper($msg);
        $msg = str_replace('J','I',$msg);
        $msg = str_replace(' ','',$msg);
        
        echo'
        <div class="row">';
            echo'<div class="col-lg-8">
                <table class="table">
                <thead><th> Cipher Text </th><th>'.$msg.'</th></thead>';
        // to make sure mesage is even number -->> helping on pair but this case never occur
        if (strlen($msg)%2 != 0)
            $msg .= 'X';
        echo "<tbody><tr><td><b>Encrypted Pair: </b></td> <td><b>Decrypted Pair</b></td></tr>";
        $pairs = str_split($msg,2);
        foreach ($pairs as $pair) {
            echo "<tr><td>".$pair."</td>";
            $decrypted_pair = '';
            $rows = array();
            $colums = array();
            for ($i=0; $i < 2; $i++) { 
                for ($j=0; $j < 5; $j++) { 
                    # code...
                    if (in_array($pair[$i],$matrex[$j])) {
                        # code...
                        $rows[$i] = $j;
                        $colums[$i] = array_search($pair[$i],$matrex[$j]);
                        break;
                    }
                }
            }
            if ($colums[0] == $colums[1]) 
            {
                $decrypted_pair = $matrex[($rows[0]-1) < 0 ?($rows[0]+4):($rows[0]-1)][$colums[0]]
                . $matrex[($rows[1]-1) < 0 ?($rows[1]+4):($rows[1]-1)][$colums[1]];
            } else if ($rows[0] == $rows[1]) 
            {
                $decrypted_pair = $matrex[$rows[0]][($colums[0]-1) < 0 ?($colums[0]+4):($colums[0]-1)]
                . $matrex[$rows[1]][($colums[1]-1) < 0 ?($colums[1]+4):($colums[1]-1)];
            } else 
            {
                $decrypted_pair = $matrex[$rows[0]][$colums[1]] . $matrex[$rows[1]][$colums[0]];
            }

            $plainText .= $decrypted_pair;
            echo "<td>".$decrypted_pair."</td></tr></tbody>";
        }
    // for ($i = 2; $i <strlen($plainText) ; $i++) { 
    //     if ($plainText[$i] == $plainText[$i-2] && $plainText[$i-1]=='X') {
    //         $plainText = str_replace('X','',$plainText);
    //     }
    // }

    echo '<tr><td><b>Plain Text</b></td><td><b>'.$plainText.'</b></td></tr></table></div>';
    echo'<div class="col-lg-4" style="position: static;">
            <h3> Decription Matrex  </h3>';
    displayMatrex($matrex);
    echo'</div></div>';

    }
    
//  }
?>
</body>
</html>