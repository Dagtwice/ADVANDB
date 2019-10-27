<?php
$sql = "SELECT v.type, count(h.aquaequiptype) as sum
            FROM hpq_aquaequip h RIGHT JOIN val_aquaequiptype v
            ON h.aquaequiptype = v.aquaequiptype
            GROUP BY h.aquaequiptype"; 
?>