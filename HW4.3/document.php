<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header("location: login.php");
}
echo "Welcome ".$_SESSION['stf_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title> คำสั่งแต่งตั้ง</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>


    <div align =center class="container">
    <h1 align =left >คำสั่งแต่งตั้ง &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
        <a href='logout.php'><span class='glyphicon glyphicon-off' style='color:#FF0000;'></span></a>
    </h1>
    <h2 align =left >รายการคำสั่งแต่งตั้ง | 
    <a href='newdocument.php'><span class='glyphicon glyphicon-cog' ></span></a>
    <a href='staff.php'><span class='glyphicon glyphicon-user' ></span></a>
    <a href='selectdocument.php'><span class='glyphicon glyphicon-search' style='color:#00B4D8;'></span></a></h2>
        <form align =center action="#" method="post">
            <input type="text" name="kw" placeholder="Enter document name" value="" size=140 style="background-color:#DFF6FF">
            <button type="submit" class="glyphicon glyphicon-search btn btn-info"></button>
        </form>
        
        <?php
        require_once("dbconfig.php");

        @$kw = "%{$_POST['kw']}%";


        $sql = "SELECT *
                FROM documents
                WHERE concat(doc_num, doc_title) LIKE ? 
                ORDER BY doc_num";

        

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $kw);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            echo  "Not found!";
        } else {
            echo "Found " . $result->num_rows . " record(s).";
            $table = "<table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>เลขที่คำสั่ง</th>
                                <th scope='col'>ชื่อคำสั่ง</th>
                                <th scope='col'>วันที่เริ่มต้นคำสั่ง</th>
                                <th scope='col'>วันที่สิ้นสุด</th>
                                <th scope='col'>สถานะ</th>
                                <th scope='col'>ชื่อไฟล์เอกสาร</th>
                                <th scope='col'>จัดการข้อมูลคำสั่งแต่งตั้ง</th>
                                <th scope='col'>จัดการข้อมุลบุคลากร</th>
                            </tr>
                        </thead>
                        <tbody>";
                        
             
            $i = 1; 

            while($row = $result->fetch_object()){ 
                $table.= "<tr>";
                $table.= "<td>" . $i++ . "</td>";
                $table.= "<td>$row->doc_num &emsp;</td>";
                $table.= "<td>$row->doc_title</td>";
                $table.= "<td>$row->doc_start_date</td>";
                $table.= "<td>$row->doc_to_date</td>";
                $table.= "<td>$row->doc_status</td>";
                $table.= "<td><a style='color:#1134A6;' href='uploads/$row->doc_file_name'>$row->doc_file_name</a></td>";
                $table.= "<td>";
                $table.= "<a style='color:#548CFF;' href='editdocument.php?id=$row->id'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a>";
                $table.= " | ";
                $table.= "<a style='color:#548CFF;' href='deletedocument.php?id=$row->id'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>";
                $table.= "</td>";
                $table.= "<td>";
                $table.= "<a style='color:#548CFF;' href='addstafftodocument.php?id=$row->id'><span class='glyphicon glyphicon-user' aria-hidden='true' ></span></a>";
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