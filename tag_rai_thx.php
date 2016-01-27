<?php

include "./connect.php";
include "./resources.php";


echo "Enter table ";
$cli = fopen("php://stdin", "r");
$tblname = fgets($cli);
$tblname = trim($tblname);

$q = "select id,patientID,count(*) from winn_rai group by CAN_TC_ID having count(*) > 1";
$res = mysqli_query($conn,$q) or die("Cannot query winn_rai -- ".mysqli_error($conn));
$num_rows = mysqli_num_rows($res);
echo "The number of rows is: ".$num_rows."\n";
$i = 0;
while($row = mysqli_fetch_row($res)){
	$ptarr[$i] = $row[1];
	$i++;
}

//for($i = 0; $i < count($ptarr); $i++)
//{
//	$q = "select patientID from winn_rai where patientID = '$ptarr[$i]' order by TxDate ASC";
//	$r = mysqli_query($conn,$q) or die("Cannot get patient records -- ".mysqli_error($conn));
//	$row = mysqli_fetch_row($r);
//	echo "\nPatient is: ".$ptarr[$i]."\n";
//	echo "id of the first therapy is: ".$row[0]."\n";
//	mysqli_query($conn,
//		"update winn_rai set multiple_thx = 'yes' where patientID = '$ptarr[$i]'") or die("Cannot update -- ".mysqli_error($conn));
//}

for($i = 0; $i < count($ptarr); $i++)
{
	$q = "select TxDate from winn_rai where patientID = '$ptarr[$i]' order by TxDate ASC";
	$r = mysqli_query($conn,$q) or die("Cannot get patient records -- ".mysqli_error($conn));
	$j = 0;
    while($row = mysqli_fetch_row($r)){
        if($j < 2){
            $date_arr[$j] = $row[0];
            $j++;   
        }
    }
    $diff = date_create($date_arr[1])->diff(date_create($date_arr[0]));
    if($diff->days < 10)
        echo "Difference in dates for patient $ptarr[$i] is -- ".$diff->days."\n";
    
}