C:\xampp\apache\conf\httpd.conf

Agregar un ALIAS hacia la carpeta del proyecto

Alias /apacheco "D:/SOFTNOW/CLASSGAP/alumnos/A_FIREBASE_ALEJANDRO_PACHECO/apacheco"

<Directory "D:/SOFTNOW/CLASSGAP/alumnos/A_FIREBASE_ALEJANDRO_PACHECO/apacheco">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>