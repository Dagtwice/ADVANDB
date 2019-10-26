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
        <div class="container-fluid">
            <form action="index.php" method="POST">
                <?php
                if (isset($_POST["group"])){
                    switch($_POST["group"]){
                        case 'Children': 
                            echo "<p>Age Group: 
                                 <select name="."group"." onchange='this.form.submit()'>";
                            echo "<option value='Children' selected>Children (0-14)</option>";
                            echo "<option value='Youth'>Youth (15-24)</option>";
                            echo "<option value='Adults'>Adults (25-59)</option>";
                            echo "<option value='Seniors'>Seniors (>59)</option>";
                            echo "<option value='all'>All Ages</option>";
                            break;
                        case 'Youth': 
                            echo "<p>Age Group: 
                                <select name="."group"." onchange='this.form.submit()'>";
                            echo "<option value='Children'>Children (0-14)</option>";
                            echo "<option value='Youth' selected>Youth (15-24)</option>";
                            echo "<option value='Adults'>Adults (25-59)</option>";
                            echo "<option value='Seniors'>Seniors (>59)</option>";
                            echo "<option value='all'>All Ages</option>";
                            break;
                        case 'Adults': 
                            echo "<p>Age Group: 
                                 <select name="."group"." onchange='this.form.submit()'>";
                            echo "<option value='Children'>Children (0-14)</option>";
                            echo "<option value='Youth'>Youth (15-24)</option>";
                            echo "<option value='Adults' selected>Adults (25-59)</option>";
                            echo "<option value='Seniors'>Seniors (>59)</option>";
                            echo "<option value='all'>All Ages</option>";
                            break;
                        case 'Seniors': 
                            echo "<p>Age Group: 
                                 <select name="."group"." onchange='this.form.submit()'>";
                            echo "<option value='Children'>Children (0-14)</option>";
                            echo "<option value='Youth'>Youth (15-24)</option>";
                            echo "<option value='Adults'>Adults (25-59)</option>";
                            echo "<option value='Seniors' selected>Seniors (>59)</option>";
                            echo "<option value='all'>All Ages</option>";
                            break;
                        case 'all': 
                            echo "<p>Age Group: 
                                 <select name="."group"." onchange='this.form.submit()'>";
                            echo "<option value='Children'>Children (0-14)</option>";
                            echo "<option value='Youth'>Youth (15-24)</option>";
                            echo "<option value='Adults'>Adults (25-59)</option>";
                            echo "<option value='Seniors' >Seniors (>59)</option>";
                            echo "<option value='all' selected>All Ages</option>";
                            break;
                    }
                }else{
                    echo "<p>Age Group: 
                    <select name="."group"." onchange='this.form.submit()'>";
                    echo "<option value='Children'>Children (0-14)</option>";
                    echo "<option value='Youth'>Youth (15-24)</option>";
                    echo "<option value='Adults' selected>Adults (25-59)</option>";
                    echo "<option value='Seniors'>Seniors (>59)</option>";
                    echo "<option value='all'>All Ages</option>";

                }
                echo "</select>";
                ?>
            </form>
        </div>
        <table>
            <?php
            if(isset($_POST["group"])){
                $filter="";
                switch($_POST["group"]){
                    case 'Children': 
                        $filter= "WHERE age_yr<=14";
                        break;
                    case 'Youth': 
                        $filter= "WHERE age_yr>=15 AND age_yr<=24";
                        break;
                    case 'Adults': 
                        $filter= "WHERE age_yr>=25 AND age_yr<=59";
                        break;
                    case 'Seniors': 
                        $filter= "WHERE age_yr>=60";
                        break;
                }
                $sql = "SELECT v.type, count(v.type) as sum
                    FROM marinduque.hpq_mem m
                    LEFT JOIN val_educal v ON v.educal = m.educal
                    ".$filter."
                    GROUP BY v.type
                    ORDER BY v.educal DESC
                    ";   
                $starttime = microtime(true);
                $result = $conn->query($sql);
                $endtime = microtime(true);
                $duration = $endtime - $starttime; //calculates total time taken
            }else{
                $sql = "SELECT v.type, count(v.type) as sum
                    FROM marinduque.hpq_mem m
                    LEFT JOIN val_educal v ON v.educal = m.educal
                    WHERE age_yr>=25 AND age_yr<=59
                    GROUP BY v.type
                    ORDER BY v.educal DESC
                    ";   
                $starttime = microtime(true);
                $result = $conn->query($sql);
                $endtime = microtime(true);
                $duration = $endtime - $starttime; //calculates total time taken
            }

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
                <th>Member Number</th>
                <th>Sex</th>
                <th>Age</th>
                <th>In School</th>
                <th>Grade Level</th>
                <th>Reason Not in School</th>
                <th>Other Reason</th>
                <th>Educational Attainment</th>
                <th>Has Job</th>
                <th>Has Business</th>
            </tr>
            <?php
            if(isset($_POST["group"])){
                $filter="";
                switch($_POST["group"]){
                    case 'Children': 
                        $filter= "WHERE age_yr<=14";
                        break;
                    case 'Youth': 
                        $filter= "WHERE age_yr>=15 AND age_yr<=24";
                        break;
                    case 'Adults': 
                        $filter= "WHERE age_yr>=25 AND age_yr<=59";
                        break;
                    case 'Seniors': 
                        $filter= "WHERE age_yr>=60";
                        break;
                }
                $starttime = microtime(true);
                /*echo "Connected successfully";*/
                $sql = "SELECT mainid, memno, sex, age_yr, educind, v2.type AS gradel, v1.type AS ynotsch, ynotsch_o, v.type AS educal, jobind, entrepind
                    FROM hpq_mem m
                    LEFT JOIN val_educal v ON v.educal = m.educal
                    LEFT JOIN val_ynotsch v1 ON v1.ynotsch = m.ynotsch
                    LEFT JOIN val_gradel v2 ON v2.gradel = m.gradel
                    ".$filter."
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
            }else{
                $starttime = microtime(true);
                /*echo "Connected successfully";*/
                $sql = "SELECT mainid, memno, sex, age_yr, educind, v2.type AS gradel, v1.type AS ynotsch, ynotsch_o, v.type AS educal, jobind, entrepind
                    FROM hpq_mem m
                    LEFT JOIN val_educal v ON v.educal = m.educal
                    LEFT JOIN val_ynotsch v1 ON v1.ynotsch = m.ynotsch
                    LEFT JOIN val_gradel v2 ON v2.gradel = m.gradel
                    WHERE age_yr>=25 AND age_yr<=59
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
            }

            $conn->close();
            echo 'Time to retrieve: '.$duration;
            echo '<br>';
            echo 'Number of rows: '.$ctr;
            ?>
        </table>
    </body>
</html>