<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/ADVANDB/CSS/bootstrap.min.css">

        <title>CBMS-APP</title>
    </head>
    <body>
        <?php include './Include/bootstrap.php'; ?>
        <?php include './Include/marNavbar.php'; ?>
        <?php include './Include/marConn.php'; ?>

        PhilHealth Lifetime Members
        <table style="width:100%">
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Age</th>
            </tr>
            <?php
            include './Include/marConn.php';
            /*echo "Connected successfully";*/
            $sql = "SELECT * FROM hpq_alp";   

            $result = $conn->query($sql);
            if ($result->num_rows >= 0) {
                // output data of each row  
                while($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo "<td>" . $row["main.id"]  . "</td>";
                    echo '</tr>';
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </table>
    </body>
</html>