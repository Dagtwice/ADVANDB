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
        <b>Aquatic Animals Record Per Household</b>

        <div class="container-fluid">
            <form action="MarRecAquani.php" method="POST">
                <?php
                if (isset($_POST["type"])){
                    echo "<p>Select Animal Type: ";
                    $selected ="";
                    $sql2 = "SELECT type
                        FROM val_aquani";
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
                    echo "<p>Select Animal Type: ";
                    $sql2 = "SELECT type
                        FROM val_aquani";
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
            //            $sql = "SELECT v.type, count(h.aquanitype) as sum
            //                FROM hpq_aquani h, val_aquani v
            //                WHERE h.aquanitype = v.aquanitype
            //                GROUP BY h.aquanitype"; 

            $sql = "SELECT v.type, count(h.aquanitype) as sum
                    FROM hpq_aquani h RIGHT JOIN val_aquani v
                    ON h.aquanitype = v.aquanitype
                    GROUP BY h.aquanitype";

            $starttime = microtime(true);
            $result = $conn->query($sql);
            $endtime = microtime(true);
            $duration = $endtime - $starttime; //calculates total time taken
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
            echo 'Time to retrieve summary table: '.$duration;
            ?>
        </table>

        <table>
            <tr>
                <th>Household ID</th>
                <th>Animal ID</th>
                <th>Animal Line</th>                
                <th>Animal Type</th>
                <th>Other Animal Type</th>
                <th>Animal Volume</th>
            </tr>
            <?php
            /*echo "Connected successfully";*/
            if(isset($_POST["type"])){
                $starttime = microtime(true);
                $sql = "SELECT mainid, hpq_aquaniid, aquani_line, aquanitype_o, aquani_vol, type
                    FROM hpq_aquani h, val_aquani v
                    where h.aquanitype = v.aquanitype AND v.type LIKE '".$_POST["type"]."'";   
//                $sql = "SELECT mainid, hpq_aquaniid, aquani_line, aquanitype_o, aquani_vol, type
//                        FROM  hpq_aquani h RIGHT JOIN val_aquani v
//                        ON h.aquanitype = v.aquanitype
//                        WHERE v.type LIKE '".$_POST["type"]."'";  
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
                        echo "<td>" . $row["hpq_aquaniid"]  . "</td>";
                        echo "<td>" . $row["aquani_line"]  . "</td>";                      
                        echo "<td>" . $row["type"]  . "</td>";
                        echo "<td>" . $row["aquanitype_o"]  . "</td>";
                        echo "<td>" . $row["aquani_vol"]  . "</td>";
                        echo '</tr>';
                    }
                } else {
                    echo "0 results";
                }

            }else{
                $starttime = microtime(true);
                $sql = "SELECT mainid, hpq_aquaniid, aquani_line, aquanitype_o, aquani_vol, type
                    FROM hpq_aquani h, val_aquani v
                    where h.aquanitype = v.aquanitype";   

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
                        echo "<td>" . $row["hpq_aquaniid"]  . "</td>";
                        echo "<td>" . $row["aquani_line"]  . "</td>";                      
                        echo "<td>" . $row["type"]  . "</td>";
                        echo "<td>" . $row["aquanitype_o"]  . "</td>";
                        echo "<td>" . $row["aquani_vol"]  . "</td>";
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