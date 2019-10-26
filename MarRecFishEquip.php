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
        <b>Fishing Equipment Records Per Household</b>

        <div class="container-fluid">
            <form action="MarRecFishEquip.php" method="POST">
                <?php
                if (isset($_POST["type"])){
                    echo "<p>Select Equipment Type: ";
                    $selected ="";
                    $sql2 = "SELECT type
                        FROM val_aquaequiptype";
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
                    echo "<p>Select Equipment Type: ";
                    $sql2 = "SELECT type
                        FROM val_aquaequiptype";
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
            $sql = "SELECT v.type, count(h.aquaequiptype) as sum
                FROM hpq_aquaequip h, val_aquaequiptype v
                WHERE h.aquaequiptype = v.aquaequiptype
                GROUP BY h.aquaequiptype";   

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
                <th>Equipment ID</th>
                <th>Equipment Line</th>                
                <th>Equipment Type</th>
                <th>Other Equipment Type</th>
                <th>Own</th>
            </tr>
            <?php
            /*echo "Connected successfully";*/
            if(isset($_POST["type"])){ //GOES HERE WHEN A FILTER IS SELECTED
                $starttime = microtime(true);
                $sql = "SELECT mainid, hpq_aquaequipid, aquaequip_line, aquaequiptype_o, aquaequiptype_own, type
                    FROM hpq_aquaequip h, val_aquaequiptype v
                    where h.aquaequiptype = v.aquaequiptype && v.type LIKE '".$_POST["type"]."'";   
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
                        echo "<td>" . $row["hpq_aquaequipid"]  . "</td>";
                        echo "<td>" . $row["aquaequip_line"]  . "</td>";                      
                        echo "<td>" . $row["type"]  . "</td>";
                        echo "<td>" . $row["aquaequiptype_o"]  . "</td>";
                        if($row["aquaequiptype_own"] ==1){
                            echo "<td>Yes</td>";
                        }else{
                            echo "<td>No</td>";
                        }

                        echo '</tr>';
                    }
                } else {
                    echo "0 results";
                }

            }else{ //GOES HERE WHEN NO FILTER IS SET
                $starttime = microtime(true);
                $sql = "SELECT mainid, hpq_aquaequipid, aquaequip_line, aquaequiptype_o, aquaequiptype_own, type
                    FROM hpq_aquaequip h, val_aquaequiptype v
                    where h.aquaequiptype = v.aquaequiptype;";   

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
                        echo "<td>" . $row["hpq_aquaequipid"]  . "</td>";
                        echo "<td>" . $row["aquaequip_line"]  . "</td>";                      
                        echo "<td>" . $row["type"]  . "</td>";
                        echo "<td>" . $row["aquaequiptype_o"]  . "</td>";
                        if($row["aquaequiptype_own"] ==1){
                            echo "<td>Yes</td>";
                        }else{
                            echo "<td>No</td>";
                        }
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