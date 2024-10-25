<?php
include 'verificar_rol.php'; 
verificarPermiso(['admin']);

// Generar un archivo de respaldo
$backup_file = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
$command = "mysqldump --user=tu_usuario --password=tu_password PuntoVentaContabilidad > $backup_file";

system($command);

echo "Respaldo generado: " . $backup_file;
?>
