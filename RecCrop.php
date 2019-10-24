<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/ADVANDB/CSS/bootstrap.min.css">
        <link rel="stylesheet" href="/ADVANDB/CSS/styles.css">

        <title>CBMS-APP</title>
    </head>
    <body>
        <?php include './Include/bootstrap.php'; ?>
        <?php include './Include/marNavbar.php'; ?>
        <?php include './Include/marConn.php'; ?>
        <b>Crop Records</b>

        <div class="container-fluid">
            <form action="RecCrop.php" method="POST">
                <?php
                include './Include/marConn.php';
                if (isset($_POST["type"])){
                    echo "<p>Select Crop Type: ";
                    $selected ="";
                    $sql2 = "SELECT type
                        FROM val_crop";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows >= 0) {
                        // output data of each row  
                        while($row2 = $result2->fetch_assoc()) {
                            if($row2["type"] == $_POST["type"])
                                $selected = "checked='checked'";
                            echo "<input type='radio' name='type' value= '".$row2["type"]."' ".$selected." onchange='this.form.submit()' >".$row2["type"] ."&nbsp&nbsp";
                            $selected = "";
                        }
                    }
                }else{
                    echo "<p>Select Crop Type: ";
                    $sql2 = "SELECT type
                        FROM val_crop";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows >= 0) {
                        // output data of each row  
                        while($row2 = $result2->fetch_assoc()) {
                            echo "<input type='radio' name='type' value= '".$row2["type"]."' onchange='this.form.submit()'>".$row2["type"] ."&nbsp&nbsp";
                        }
                    }
                }
                $conn->close();
                ?>
            </form>
        </div>
        <table>
            <?php
            include './Include/marConn.php';

            $sql = "SELECT type, count(croptype) as sum
                FROM hpq_crop, val_crop
                WHERE croptype = idval_crop
                GROUP BY croptype";   

            $result = $conn->query($sql);
            if ($result->num_rows >= 0) {
                // output data of each row  

                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo "<th>" . $row["type"]  . "</th>";
                    echo "<td>" . $row["sum"]  . "</td>";
                    echo '</tr>';
                }

            } else {
                echo "0 results";
            }

            $conn->close();
            ?>
        </table>

        <table>
            <tr>
                <th>main.id</th>
                <th>hpq_cropid</th>
                <th>crop_line</th>                
                <th>croptype</th>
                <th>type</th>
                <th>croptype_o</th>
                <th>crop_vol</th>
            </tr>
            <?php
            include './Include/marConn.php';
            /*echo "Connected successfully";*/
            if(isset($_POST["type"])){
                $starttime = microtime(true);
                $sql = "SELECT mainid, hpq_cropid, crop_line,croptype, type, croptype_o, crop_vol
                        FROM hpq_crop h, val_crop v
                        where h.croptype = v.idval_crop && v.type LIKE '".$_POST["type"]."'";

                $result = $conn->query($sql);
                $ctr=0;
                if ($result->num_rows >= 0) {
                    // output data of each row  
                    while($row = $result->fetch_assoc()) {
                        $ctr++;
                        echo '<tr>';
                        echo "<td>" . $row["mainid"]  . "</td>";
                        echo "<td>" . $row["hpq_cropid"]  . "</td>";
                        echo "<td>" . $row["crop_line"]  . "</td>";                      
                        echo "<td>" . $row["croptype"]  . "</td>";
                        echo "<td>" . $row["type"]  . "</td>";
                        echo "<td>" . $row["croptype_o"]  . "</td>";
                        echo "<td>" . $row["crop_vol"]  . "</td>";
                        echo '</tr>';
                    }
                } else {
                    echo "0 results";
                }
                $endtime = microtime(true);
                $duration = $endtime - $starttime; //calculates total time taken
            }else{
                $starttime = microtime(true);
                $sql = "SELECT mainid, hpq_cropid, crop_line,croptype, type, croptype_o, crop_vol
                        FROM hpq_crop h, val_crop v
                        where h.croptype = v.idval_crop ";   

                $result = $conn->query($sql);
                $ctr=0;
                if ($result->num_rows >= 0) {
                    // output data of each row  
                    while($row = $result->fetch_assoc()) {
                        $ctr++;
                        echo '<tr>';
                        echo "<td>" . $row["mainid"]  . "</td>";
                        echo "<td>" . $row["hpq_cropid"]  . "</td>";
                        echo "<td>" . $row["crop_line"]  . "</td>";                      
                        echo "<td>" . $row["croptype"]  . "</td>";
                        echo "<td>" . $row["type"]  . "</td>";
                        echo "<td>" . $row["croptype_o"]  . "</td>";
                        echo "<td>" . $row["crop_vol"]  . "</td>";
                        echo '</tr>';
                    }
                } else {
                    echo "0 results";
                }
                $endtime = microtime(true);
                $duration = $endtime - $starttime; //calculates total time taken
            }
            $conn->close();
            echo '<br>';
            echo 'Time to retrieve: '.$duration;
            echo '<br>';
            echo 'Number of rows returned: '.$ctr;
            ?>
        </table>
    </body>
</html>