prueba de Konecta PHP
POR FAVOR LEER.
INSTRUCCIONES.
1.dentro del repositorio existe una carpeta con el nombre BD.    
2.dirijase a su phpMyAdmin y crea una nueva base de datos con el nombre bdkonecta.
3.una vez creada la BD importe el archivo bdkonecta.sql que se encuentra en este repositorio dentro de la carpeta BD.
4.para ejecutar el proyecto descargue este contenido y descomprimalo, posteriormente copie la carpeta descomprimida en su servidor local, si usa wamserver la ruta sera C:\wamp64\www si usa XAMPP la ruta sera C:\xampp\htdocs

Nota: para las categorias se creo una tabla diferente y se relaciono con la tabla productos por una llave forranea, el borrado de un producto se hace de forma logica es decir no se elimina directamente de la BD sino que su estado pasa a ser cero, si su estado es cero no se muestra en el listado de productos.
