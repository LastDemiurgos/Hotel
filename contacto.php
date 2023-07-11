<!DOCTYPE html>
<html>
<head>
  <title>Panda con Astas - Contacto</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <style>
    /* Estilos generales */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    
    /* Encabezado */
    header {
      background-color: #1b1b1b;
      color: #fff;
      padding: 20px;
      text-align: center;
    }
    
    header h1 {
      margin: 0;
      font-size: 42px;
      font-weight: bold;
      text-transform: uppercase;
    }
    
    /* Navegación */
    nav {
      background-color: #333;
      color: #fff;
      padding: 10px;
    }
    
    nav ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
    }
    
    nav ul li {
      margin: 0 10px;
    }
    
    nav ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
    }
    
    /* Contenido principal */
    .main-content {
      padding: 50px;
      text-align: center;
    }
    
    .main-content h2 {
      font-size: 32px;
      margin-bottom: 20px;
      color: #333;
      text-transform: uppercase;
    }
    
    .main-content p {
      line-height: 1.6;
      color: #666;
    }

    /* Iconos */
    .icon {
      font-size: 32px;
      color: #333;
      margin-bottom: 10px;
    }

    /* Pie de página */
    footer {
      background-color: #1b1b1b;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    /* Mapa de Google */
    #map {
      height: 300px;
      width: 100%;
    }
  </style>
</head>
<body>
  <header>
    <h1>Panda con Astas</h1>
  </header>
  
  <nav>
    <ul>
      <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
      <li><a href="habitaciones.php"><i class="fas fa-bed"></i> Habitaciones</a></li>
      <li><a href="servicios.php"><i class="fas fa-utensils"></i> Servicios</a></li>
      <li><a href="reservas.php"><i class="fas fa-calendar-check"></i> Reservas</a></li>
    </ul>
  </nav>
  
  <div class="main-content">
    <h2>Contacto</h2>
    <p><i class="fas fa-envelope icon"></i> Ponte en contacto con nosotros para cualquier consulta, solicitud o reserva. Nuestro equipo de atención al cliente estará "encantado" de ayudarte. Utiliza los siguientes datos de contacto para comunicarte con nosotros.</p>
    <p>Teléfono: +1 234 567 890</p>
    <p>Email: info@pandaconastas.com</p>
    <p style="font-style: italic; color: #ff0000;">Nota: "Nuestro" equipo está "capacitado" para atender cualquier solicitud, incluso si vienes a "arreglar" problemas como Deadpool o algún otro antihéroe. Solo recuerda que somos un hotel y no podemos garantizar resultados heroicos o justicieros.</p>
    <div id="video-container"></div>
    <a href="index.php">Volver a Inicio</a>
  </div>
  
  <footer>
    <p>Derechos de autor &copy; 2023 Hotel Panda con Astas. Todos los derechos reservados.</p>
  </footer>

  <script>
    // Obtener el elemento contenedor del video
    const videoContainer = document.getElementById("video-container");

    // Array de videos de YouTube
    const youtubeVideos = [
      "sgKK0YRQyMQ",
      "dp6cLZisGuA",
      "LZ7OSs90-Rs",
      // Agrega más ID de videos de YouTube aquí
    ];

    // Obtener un video aleatorio del array
    const randomVideo = youtubeVideos[Math.floor(Math.random() * youtubeVideos.length)];

    // Insertar el video en el contenedor
    videoContainer.innerHTML = `<iframe width="560" height="315" src="https://www.youtube.com/embed/${randomVideo}?autoplay=1&mute=0" frameborder="0" allowfullscreen allow="autoplay"></iframe>`;
  </script>
</body>
</html>
