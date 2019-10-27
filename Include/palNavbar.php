<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-success">
    <a class="navbar-brand" href="#">CBMS-APP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="palawan.php">Palawan <span class="sr-only"></span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Records
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="PalRecFishEquip.php">Fishing Equipments</a>
                    <a class="dropdown-item" href="PalRecCrop.php">Crops</a>
                    <a class="dropdown-item" href="PalRecAquani.php">Aquatic Animals</a>
<!--                    <a class="dropdown-item" href="RecLandPar.php">Land Parcels</a>-->
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Program
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="PalProgArcdp.php">ARCDP</a>
<!--                    <a class="dropdown-item" href="PHOFW.php">OFW Members</a>-->
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Province
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="index.php">Marinduque</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="palawan.php">Palawan</a>
                </div>
            </li>
        </ul>
        
    </div>
</nav>
<?php include './Include/palConn.php'; ?>