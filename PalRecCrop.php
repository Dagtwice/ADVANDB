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
        <?php include './Include/palNavbar.php'; ?>
        <b>Crop Records Per Household</b>

        <div class="container-fluid">
            <form action="PalRecCrop.php" method="POST">
                <?php
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
                ?>
            </form>
        </div>
        <table>
            <?php
            $sql = "SELECT v.type, count(h.croptype) as sum
                FROM hpq_crop h, val_crop v
                WHERE h.croptype = v.croptype
                GROUP BY h.croptype";   

         
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
            ?>
        </table>

        <table>
            <tr>
                <th>Household ID</th>
                <th>Crop ID</th>
                <th>Crop Line</th>                
                <th>Crop Type</th>
                <th>Other Crop Type</th>
                <th>Crop Volume</th>
            </tr>
            <?php
            /*echo "Connected successfully";*/
            if(isset($_POST["type"])){
                $starttime = microtime(true);
                $sql = "SELECT mainid, hpq_cropid, crop_line, type, croptype_o, crop_vol
                        FROM hpq_crop h, val_crop v
                        where h.croptype = v.croptype && v.type LIKE '".$_POST["type"]."'";

                $result = $conn->query($sql);
                $endtime = microtime(true);
                $duration = $endtime - $starttime; //calculates total time taken
                $ctr=0;
                if ($result->num_rows >= 0) {
                    // output data of each row  
                    while($row = $result->fetch_assoc()) {
                        $ctr++;
                        echo '<tr>';
                        echo "<td>" . $row["mainid"]  . "</td>";
                        echo "<td>" . $row["hpq_cropid"]  . "</td>";
                        echo "<td>" . $row["crop_line"]  . "</td>";                      
                        echo "<td>" . $row["type"]  . "</td>";
                        echo "<td>" . $row["croptype_o"]  . "</td>";
                        echo "<td>" . $row["crop_vol"]  . "</td>";
                        echo '</tr>';
                    }
                } else {
                    echo "0 results";
                }                
            }else{
                $starttime = microtime(true);
                $sql = "SELECT mainid, hpq_cropid, crop_line, type, croptype_o, crop_vol
                        FROM hpq_crop h, val_crop v
                        where h.croptype = v.croptype";   
                $result = $conn->query($sql);
                $endtime = microtime(true);
                $duration = $endtime - $starttime; //calculates total time taken
                $ctr=0;
                if ($result->num_rows >= 0) {
                    // output data of each row  
                    while($row = $result->fetch_assoc()) {
                        $ctr++;
                        echo '<tr>';
                        echo "<td>" . $row["mainid"]  . "</td>";
                        echo "<td>" . $row["hpq_cropid"]  . "</td>";
                        echo "<td>" . $row["crop_line"]  . "</td>";                      
                        echo "<td>" . $row["type"]  . "</td>";
                        echo "<td>" . $row["croptype_o"]  . "</td>";
                        echo "<td>" . $row["crop_vol"]  . "</td>";
                        echo '</tr>';
                    }
                } else {
                    echo "0 results";
                }
                
            }
            $conn->close();
            echo '<br>';
            echo 'Time to retrieve table: '.$duration;
            echo '<br>';
            echo 'Number of rows returned: '.$ctr;
            ?>
        </table>
    </body>
</html>