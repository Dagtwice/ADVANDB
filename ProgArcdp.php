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
        <b>ARCDP Benificiaries</b>
        <div class="container-fluid">
            <form action="ProgArcdp.php" method="POST">
                <?php
                if (isset($_POST["brgy"])){
                    echo "<p>Barangay: 
                    <select name="."brgy"." onchange='this.form.submit()'>";
                    echo "<option value='%'>All BRGY</option>";
                    $selected ="";
                    $sql2 = "SELECT distinct(brgy), prog_arcdp
                             FROM marinduque.hpq_hh
                             WHERE prog_arcdp = 1
                             ORDER BY 1";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows >= 0) {
                        // output data of each row  
                        while($row2 = $result2->fetch_assoc()) {
                            if($row2["brgy"] == $_POST["brgy"])
                                $selected = "selected";
                            echo "<option value='".$row2["brgy"]."' ".$selected.">".$row2["brgy"]."</option>";
                            $selected = "";
                        }
                    }
                }else{
                    echo "<p>Barangay: 
                    <select name="."brgy"." onchange='this.form.submit()'>";
                    echo "<option value='%'>All BRGY</option>";
                    $sql2 = "SELECT distinct(brgy), prog_arcdp
                             FROM marinduque.hpq_hh
                             WHERE prog_arcdp = 1
                             ORDER BY 1";
                    $result2 = $conn->query($sql2);
                    if ($result2->num_rows >= 0) {
                        // output data of each row  
                        while($row2 = $result2->fetch_assoc()) {
                            echo "<option value='".$row2["brgy"]."'  >".$row2["brgy"]."</option>";
                        }
                    }

                }
                echo "</select>";
                ?>
            </form>
        </div>

        <table>
            <tr>
                <th>Main ID</th> 
                <th>Number of Members</th>
            </tr>
            <?php
            include './Include/marConn.php';
            /*echo "Connected successfully";*/
            $totalBeneficiaries=0;
            if(isset($_POST["brgy"])){
                $starttime = microtime(true);
                $sql = "SELECT mainid, brgy, prog_arcdp, prog_arcdp_nmem
                        FROM marinduque.hpq_hh
                        WHERE prog_arcdp = 1 && brgy LIKE '".$_POST["brgy"]."'
                        ORDER BY 1, 3";

                $result = $conn->query($sql);
                $ctr=0;
                if ($result->num_rows >= 0) {
                    // output data of each row  
                    while($row = $result->fetch_assoc()) {
                        $ctr++;
                        echo '<tr>';
                        echo "<td>" . $row["mainid"]  . "</td>";       
                        echo "<td>" . $row["prog_arcdp_nmem"]  . "</td>";
                        echo '</tr>';
                        $totalBeneficiaries +=  $row["prog_arcdp_nmem"];
                    }
                } else {
                    echo "0 results";
                }
                $endtime = microtime(true);
                $duration = $endtime - $starttime; //calculates total time taken
                echo 'Total Number of Beneficiaries in Barangay '.$_POST["brgy"].': '.$totalBeneficiaries;
            }else{
                $starttime = microtime(true);
//                $sql = "SELECT h.mainid, h.brgy, h.prog_arcdp, h.prog_arcdp_nmem, a.aquaequiptype, v.type AS aquaequiptype, c.croptype, v1.type AS croptype
//                        FROM marinduque.hpq_hh h 
//                        LEFT JOIN hpq_aquaequip a ON h.mainid = a.mainid 
//                        LEFT JOIN val_aquaequiptype v ON a.aquaequiptype = v.aquaequiptype
//                        LEFT JOIN hpq_crop c ON h.mainid = c.mainid 
//                        LEFT JOIN val_crop v1 ON c.croptype = v1.croptype
//                        WHERE prog_arcdp = 1 
//                        ORDER BY 1, 3";   
                $sql = "SELECT mainid, brgy, prog_arcdp, prog_arcdp_nmem 
                        FROM marinduque.hpq_hh
                        WHERE prog_arcdp = 1
                        ORDER BY 1, 3";   
                $result = $conn->query($sql);
                $ctr=0;
                if ($result->num_rows >= 0) {
                    // output data of each row  
                    while($row = $result->fetch_assoc()) {
                        include './Include/modal.php';
                        $ctr++;
                        echo '<tr>';
                        echo '<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#' . $row["mainid"]  . '">' . $row["mainid"]  . '</button></td>';
                        echo "<td>" . $row["prog_arcdp_nmem"]  . "</td>";
                        echo '</tr>';
                        $totalBeneficiaries +=  $row["prog_arcdp_nmem"];
                    }
                } else {
                    echo "0 results";
                }
                $endtime = microtime(true);
                $duration = $endtime - $starttime; //calculates total time taken
                echo 'Total Number of Beneficiaries: '.$totalBeneficiaries;
            }
            $conn->close();
            echo '<br>';

            echo '<br>';
            echo 'Time to retrieve: '.$duration;
            echo '<br>';
            echo 'Number of rows returned: '.$ctr;
            ?>

        </table>
    </body>
    <script src="viewMainModal.js"></script>
</html>