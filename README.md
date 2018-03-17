# PHP UPDATE IP PUBLIC
Actualizar ip pública utilizando php, mysql y cron.
### Introducción
El script nace por la necesidad de actualizar la ip pública para acceder desde cualquier parte a los servicios de mi servidor de pruebas. No es una solución DNS y mucho menos la utilizaría para un sistema de producción. 
### Uso

Parametros Get:
* Route(ip,put).
* Token.

Establecer token de seguridad en la variable:
```
$token="";
```

Obtener la ip desde la url pasando parametros:
```
ip.php?route=ip&token={token}
```
Establecer ip guardando en la base de datos:
```
ip.php?route=put&token={token}
```

### ¿Cómo funciona?
Desde Cron hacemos una llamada al archivo ip.sh actualizando la ip, en mi caso llamo al ip.sh cada 5 minutos. Sólo se actualiza la ip en la base de datos si la última ip registrada es diferente a la actual en el momento de ejecutar el script. 
