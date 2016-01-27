<?php
//Do you see this.
$t_arr = ['T1','T2','T3','T4'];
$n1 = 'N1a,N1b';
$n0x = 'N0,Nx';
$n_arr = ['n1ab','n0x'];
$tn = ['T1_n1ab','T1_n0x','T2_n1ab','T2_n0x','T3_n1ab','T3_n0x','T4_n1ab','T4_n0x','total'];
$tnrw = ['T1_n1ab_r','T1_n1ab_w','T1_n0x_r','T1_n0x_w','T2_n1ab_r','T2_n1ab_w','T2_n0x_r','T2_n0x_w','T3_n1ab_r','T3_n1ab_w','T3_n0x_r','T3_n0x_w','T4_n1ab_r','T4_n1ab_w','T4_n0x_r','T4_n0x_w' ,'total'];
$epdemo = ['M1','F1','M2','F2','M3','F3','M4','F4','M5','F5','M6','F6','total'];
$years = ['2000','2001','2002','2003','2004','2005','2006','2007','2008','2009','2010'];
$sites = ['London','Halifax','Winnipeg','Toronto','Newfoundland','Hamilton','Fredericton'];

$dose_range = array('D1.1'=>'1.1','D1.8'=>'1.8','D3.7'=>'3.7','D5.5'=>'5.5','D7.4+'=>'7.4');

function create_table($tbl,$rows_,$first_col_name,$conn)
{
    global $years,$sites;
    
    $columns = getColNames($tbl,$conn);
    echo "Create table --".$columns."\n";

    $sql = "CREATE TABLE $tbl ($columns)"; 
    $create_result = mysqli_query($conn,$sql) or die("Cannot create table --".mysqli_error($conn));
    
    for($i = 0; $i < count($rows_); $i++){
        echo "Year is :".$rows_[$i]."\n";
        $sql_insert_rows = "Insert into $tbl ($first_col_name) VALUES('$rows_[$i]')"; 
        $insert_result = mysqli_query($conn,$sql_insert_rows) or die("Cannot insert -- ".mysqli_error($conn));
    }
}


function getQuery($tbl,$conn)
{
    $getqry = "select qry_var from tbl_columns where `name` = '$tbl'";
    $qry_result = mysqli_query($conn,$getqry) or die("Cannot fetch query var -- ".mysqli_error($conn));
    $qry_row = mysqli_fetch_row($qry_result);
    $qry_index = $qry_row[0];
    return $qry_index;
}


function getColNames($tbl,$conn)
{
    $getcols = "select cols from tbl_columns where `name` like ('$tbl%')";
    $cols_result = mysqli_query($conn,$getcols) or die("Cannot fetch query var -- ".mysqli_error($conn));
    $cols_row = mysqli_fetch_row($cols_result);
    $colnames = $cols_row[0];

    return $colnames;
}

function getTableHeaders($tbl,$conn)
{
    global $tn,$dose_range,$tnrw,$epdemo;
    $cols_arr = [];
    $qry = "select headers from tbl_columns where `name` = '$tbl'";
    $res = mysqli_query($conn,$qry) or die("Cannot fetch first_col -- ".mysqli_error($conn));
    $row = mysqli_fetch_row($res);
    $hdr_title = $row[0];
    switch ($hdr_title){
        case 'tn':
            echo "tn case";
            $cols_arr = $tn;
            break;
        case 'doses':
            echo "doses case";
            $cols_arr = array_keys($dose_range);
            break;
        case 'tnrw':
            $cols_arr = $tnrw;
            break;
        case 'epdemo':
            $cols_arr = $epdemo;
            break; 
        default:
            break;  
    }
    return $cols_arr;
    
}

function getRowsArr($tbl,$conn)
{
    global $years,$sites;
    $getfirstcol = "select first_col from tbl_columns where `name` = '$tbl'";
    $firstcol_res = mysqli_query($conn,$getfirstcol) or die("Cannot fetch first_col -- ".mysqli_error($conn));
    $firstcol_row = mysqli_fetch_row($firstcol_res);
    $first_col = $firstcol_row[0];
    switch ($first_col){
        case 'years':
            $rows_arr = $years;
            break;
        case 'sites':
            $rows_arr = $sites;
            break;
        default:
            break;  
    }
    return $rows_arr;
}


function getFirstColName($tbl,$conn)
{
    global $years,$sites;
    $getfirstcol = "select first_col from tbl_columns where `name` = '$tbl'";
    $firstcol_res = mysqli_query($conn,$getfirstcol) or die("Cannot fetch first_col -- ".mysqli_error($conn));
    $firstcol_row = mysqli_fetch_row($firstcol_res);
    $first_col_name = $firstcol_row[0];
    echo " first_col_name is: ".$first_col_name."\n";
    return $first_col_name;
}

function getSite($tbl,$conn)
{
    global $years,$sites;
    $qry = "select site from tbl_columns where `name` = '$tbl'";
    $res = mysqli_query($conn,$qry) or die("Cannot fetch first_col -- ".mysqli_error($conn));
    $row = mysqli_fetch_row($res);
    $site = $row[0];
    echo "Site is: ".$site."\n";
    return $site;
}

function getTValue($colvalue)
{
    $tn_val = ['','',''];
    switch($colvalue){
        case "T1_n1ab":
            $tn_val[0] = 'T1';
            $tn_val[1] = 'N1a,N1b';
            break;
        case "T1_n0x":
            $tn_val[0] = 'T1';
            $tn_val[1] = 'N0,Nx';
            break;
        case "T2_n1ab":
            $tn_val[0] = 'T2';
            $tn_val[1] = 'N1a,N1b';
            break;
        case "T2_n0x":
            $tn_val[0] = 'T2';
            $tn_val[1] = 'N0,Nx';
            break;
        case "T3_n1ab":
            $tn_val[0] = 'T3';
            $tn_val[1] = 'N1a,N1b';
            break;
        case "T3_n0x":
            $tn_val[0] = 'T3';
            $tn_val[1] = 'N0,Nx';
            break;
        case "T4_n1ab":
            $tn_val[0] = 'T4';
            $tn_val[1] = 'N1a,N1b';
            break;
        case "T4_n0x":
            $tn_val[0] = 'T4';
            $tn_val[1] = 'N0,Nx';
            break;
        case "T1_n1ab_r":
            $tn_val[0] = 'T1';
            $tn_val[1] = 'N1a,N1b';
            $tn_val[2] = 'rhtsh';
        break;
        case "T1_n1ab_w":
            $tn_val[0] = 'T1';
            $tn_val[1] = 'N1,N1b';
            $tn_val[2] = 'withdrawal';
        break;
        case "T1_n0x_r":
            $tn_val[0] = 'T1';
            $tn_val[1] = 'N0,Nx';
            $tn_val[2] = 'rhtsh';
        break;
        case "T1_n0x_w":
            $tn_val[0] = 'T1';
            $tn_val[1] = 'N0,Nx';
            $tn_val[2] = 'withdrawal';
        break;
        case "T2_n1ab_r":
            $tn_val[0] = 'T2';
            $tn_val[1] = 'N1a,N1b';
            $tn_val[2] = 'rhtsh';
        break;
        case "T2_n1ab_w":
            $tn_val[0] = 'T2';
            $tn_val[1] = 'N1a,N1b';
            $tn_val[2] = 'withdrawal';
        break;
        case "T2_n0x_r":
            $tn_val[0] = 'T2';
            $tn_val[1] = 'N0,Nx';
            $tn_val[2] = 'rhtsh';
        break;
        case "T2_n0x_w":
            $tn_val[0] = 'T2'; 
            $tn_val[1] = 'N0,Nx';
            $tn_val[2] = 'withdrawal';
        break;
        case "T3_n1ab_r":
            $tn_val[0] = 'T3'; 
            $tn_val[1] = 'N1a,N1b';
            $tn_val[2] = 'rhtsh';
        break;
        case "T3_n1ab_w":
            $tn_val[0] = 'T3'; 
            $tn_val[1] = 'N1a,N1b';
            $tn_val[2] = 'withdrawal';
        break;
        case "T3_n0x_r":
            $tn_val[0] = 'T3'; 
            $tn_val[1] = 'N0,Nx';
            $tn_val[2] = 'rhtsh';
        break;
        case "T3_n0x_w":
            $tn_val[0] = 'T3'; 
            $tn_val[1] = 'N0,Nx';
            $tn_val[2] = 'withdrawal';
        break;
        case "T4_n1ab_r":
            $tn_val[0] = 'T4'; 
            $tn_val[1] = 'N1a,N1b';
            $tn_val[2] = 'rhtsh';
        break;
        case "T4_n1ab_w":
            $tn_val[0] = 'T4'; 
            $tn_val[1] = 'N1a,N1b';
            $tn_val[2] = 'withdrawal';
        break;
        case "T4_n0x_r":
            $tn_val[0] = 'T4'; 
            $tn_val[1] = 'N0,Nx';
            $tn_val[2] = 'rhtsh';
        break;
        case "T4_n0x_w":
            $tn_val[0] = 'T4'; 
            $tn_val[1] = 'N0,Nx';
            $tn_val[2] = 'withdrawal';
        break;
        default:
        break;
    }
    return $tn_val;

}

?>