1) Descargar XAMPP
	https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/8.2.12/xampp-windows-x64-8.2.12-0-VS16-installer.exe 
2) Configurar puerto SQL si es necesario
	https://www.youtube.com/watch?v=8GG9Y1cEPyk
3) Agregar el proyecto como ALIAS en XAMPP
	C:\xampp\apache\conf\httpd.conf

	Agregar un ALIAS hacia la carpeta del proyecto

	Alias /apacheco "D:/SOFTNOW/CLASSGAP/alumnos/A_FIREBASE_ALEJANDRO_PACHECO/apacheco"

	<Directory "D:/SOFTNOW/CLASSGAP/alumnos/A_FIREBASE_ALEJANDRO_PACHECO/apacheco">
    		Options Indexes FollowSymLinks
    		AllowOverride All
    		Require all granted
	</Directory>
4) Ejecutar Apache y Mysql
5) Visitar
	http://localhost/apacheco