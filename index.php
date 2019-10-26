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
        <b>Education Profiles</b><br>
        <table >
            <tr>
                <th>Household ID</th>
                <th>Member Number</th>
                <th>Sex</th>
                <th>Age</th>
                <th>In School</th>
                <th>Grade Level</th>
                <th>Why Not in School</th>
                <th>Other Reason</th>
                <th>Educational Attainment</th>
                <th>Has Job</th>
                <th>Has Business</th>
            </tr>
            <?php
            $starttime = microtime(true);
            /*echo "Connected successfully";*/
            $sql = "SELECT mainid, memno, sex, age_yr, educind, v2.type AS gradel, v1.type AS ynotsch, ynotsch_o, v.type AS educal, jobind, entrepind
                    FROM hpq_mem m
                    LEFT JOIN val_educal v ON v.educal = m.educal
                    LEFT JOIN val_ynotsch v1 ON v1.ynotsch = m.ynotsch
                    LEFT JOIN val_gradel v2 ON v2.gradel = m.gradel
                    ORDER BY 1, 4 DESC";   

            $result = $conn->query($sql);
            $endtime = microtime(true);
            $duration = $endtime - $starttime; //calculates total time taken
            $mainid=0;
            $color="#e3e3e3";
            $ctr=0;
            if ($result->num_rows >= 0) {
                // output data of each row  
                while($row = $result->fetch_assoc()) {
                    if($mainid==$row["mainid"]){
                        if($color=="#e3e3e3"){
                            $color="#e3e3e3";
                        }else{
                            $color="white";
                        }
                    }else{
                        if($color=="#e3e3e3"){
                            $color="white";
                        }else{
                            $color="#e3e3e3";
                        }
                    }
                    $ctr++;
                    echo '<tr style="background-color:'.$color.';">';
                    echo "<td>" . $row["mainid"]  . "</td>";
                    echo "<td>" . $row["memno"]  . "</td>";
                    echo "<td>" . $row["sex"]  . "</td>";
                    echo "<td>" . $row["age_yr"]  . "</td>";
                    echo "<td>" . $row["educind"]  . "</td>";
                    echo "<td>" . $row["gradel"]  . "</td>";
                    echo "<td>" . $row["ynotsch"]  . "</td>";
                    echo "<td>" . $row["ynotsch_o"]  . "</td>";
                    echo "<td>" . $row["educal"]  . "</td>";
                    echo "<td>" . $row["jobind"]  . "</td>";
                    echo "<td>" . $row["entrepind"]  . "</td>";
                    echo '</tr>';
                    $mainid = $row["mainid"];
                }
            } else {
                echo "0 results";
            }

            $conn->close();
            echo 'Time to retrieve: '.$duration;
            echo '<br>';
            echo 'Number of rows: '.$ctr;
            ?>
        </table>
    </body>
</html>