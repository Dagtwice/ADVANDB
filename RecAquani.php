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
        <b>Aquatic Animals Record</b>

        <div class="container-fluid">
            <form action="RecAquani.php" method="POST">
                <?php
                include './Include/marConn.php';
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
                $conn->close();
                ?>
            </form>
        </div>
        <table>
            <?php
            include './Include/marConn.php';

            $sql = "SELECT type, count(aquanitype) as sum
                FROM hpq_aquani, val_aquani
                WHERE aquanitype = idval_aquani
                GROUP BY aquanitype";   

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
                <th>hpq_aquaniid</th>
                <th>aquani_line</th>                
                <th>Animal Type</th>
                <th>aquanitype_o</th>
                <th>aquani_vol?</th>
            </tr>
            <?php
            include './Include/marConn.php';
            /*echo "Connected successfully";*/
            if(isset($_POST["type"])){
                $starttime = microtime(true);
                $sql = "SELECT mainid, hpq_aquaniid, aquani_line, aquanitype_o, aquani_vol, type
                    FROM marinduque.hpq_aquani h, val_aquani v
                    where h.aquanitype = v.idval_aquani && v.type LIKE '".$_POST["type"]."'";   
                $result = $conn->query($sql);
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
                $endtime = microtime(true);
                $duration = $endtime - $starttime; //calculates total time taken
            }else{
                $starttime = microtime(true);
                $sql = "SELECT mainid, hpq_aquaniid, aquani_line, aquanitype_o, aquani_vol, type
                    FROM marinduque.hpq_aquani h, val_aquani v
                    where h.aquanitype = v.idval_aquani";   

                $result = $conn->query($sql);
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