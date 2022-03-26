<?php
session_start();
echo "Welcome ".$_SESSION['stf_name'];

if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>บุคลากร</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>


    <div  align =center class="container">
    <h1 align =left><b>บุคลากร&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&emsp;&emsp;&nbsp;&nbsp;
</b><a href='document.php'><span class='glyphicon glyphicon-th-large' ></span></a></h1>
    <h2 align =left><b>รายชื่อบุคลากร</b> &nbsp;</h2>
    <h3 align =left>เพิ่มรายชื่อ | <a href='newstaff.php'><span class='glyphicon glyphicon-plus' ></span></a></h3>
        <form  align =center action="#" method="post">
            <input type="text" name="kw" placeholder="Enter staff name" value="" size=140 style="background-color:#DFF6FF">
            <button type="submit" class="glyphicon glyphicon-search btn btn-info"></button>
        </form>

        <?php
        require_once("dbconfig.php");

        @$kw = "%{$_POST['kw']}%";

        $sql = "SELECT *
                FROM staff
                WHERE concat(stf_code, stf_name) LIKE ? 
                ORDER BY stf_code";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s)."; 
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>รหัสพนักงาน</th>
                                <th scope='col'>ชื่อ-นามสกุล</th>
                                <th scope='col'></th>
                            </tr>
                        </thead>
                        <tbody>";
                        
            
            $i = 1; 

            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td>" . $i++ . "</td>";
                $table.= "<td>$row->stf_code</td>";
                $table.= "<td>$row->stf_name</td>";
                $table.= "<td>";
                $table.= "<a style='color:#548CFF;' href='editstaff.php?id=$row->id'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                $table.= " | ";
                $table.= "<a style='color:#548CFF;' href='deletestaff.php?id=$row->id'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                $table.= "</td>";
                $table.= "</tr>";
            }

            $table.= "</tbody>";
            $table.= "</table>";
            
            echo $table;
        }
        ?>
    </div>
    
</body>

</html>