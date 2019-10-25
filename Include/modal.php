<!-- Modal -->
                            

<?php
echo '<div class="modal fade" id="' . $row["mainid"]  . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">' . $row["mainid"]  . '</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <b>Zone: </b>'.$row["zone"].'<br>
                <b>Barangay: </b>'.$row["brgy"].'<br>
                <b>Purok: </b>'.$row["purok"].'<br>
                <b>Interview Date: </b>'.$row["int_date"].'<br>
                <b>House Type: </b>'.$row["house_type"].'<br>
                <b>Has Electricity: </b>'.$row["welec"].'<br>
                <b>Water Source: </b>'.$row["water"].'<br>
                <b>Bathroom: </b>'.$row["toil"].'<br>
                <b>Tenur: </b>'.$row["tenur"].'<br>
                <b>Estimate Rent Price: </b>'.$row["imprnt"].'<br>
                <b>Number of Agricultural Land Owned: </b>'.$row["landagri"].'<br>
                <b>Number of Residential Land Owned: </b>'.$row["landres"].'<br>
                <b>Number of Commerical Land Owned: </b>'.$row["landcomm"].'<br>
                <b>Number of Commerical Land Owned: </b>'.$row["landcomm"].'<br>
                <b>Total Income in Cash: </b>'.$row["totincsh"].'<br>
                <b>Disaster Preparedness Kits: </b>'.$row["disas_prep"].'<br>
                <b>Food Shortage?: </b>'.$row["fshort"].'
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>';
?>