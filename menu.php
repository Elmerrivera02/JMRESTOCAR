
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESTOCAR - Vista Principal</title>
    <link rel="stylesheet" href="CSS/principal.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>ReservApp</h1>
            <div class="buttons">
                <a href="v_reservas.php"><button>Mis Reservas</button></a>
                <a href="reservas.php"><button>Reservar</button></a>
                <a href="menu_principal.php"><button>Cerrar Sesion</button></a>
            </div>
        </header>
        <main>
            <div class="menu">
                <div class="menu">
                    <div class="menu-item">
                        <img src="IMG/image.png" alt="Dish 1">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        <span>S/. **.**</span>
                        <button class="info-button">Más información</button>
                        <div class="popup">
                            <img src="IMG/image.png" alt="Dish 1">
                            <h3>Detalle del Platillo</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                            <span>S/. **.**</span>
                        </div>
                    </div>              
                <div class="menu-item">
                    <img src="IMG/image (1).png" alt="Dish 1">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>S/. **.**</span>
                    <button class="info-button">Más información</button>
                        <div class="popup">
                            <img src="IMG/image (1).png" alt="Dish 1">
                            <h3>Detalle del Platillo</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                            <span>S/. **.**</span>
                        </div>
                </div>
                <div class="menu-item">
                    <img src="IMG/image (2).png" alt="Dish 1">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>S/. **.**</span>
                    <button class="info-button">Más información</button>
                        <div class="popup">
                            <img src="IMG/image (2).png" alt="Dish 1">
                            <h3>Detalle del Platillo</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                            <span>S/. **.**</span>
                        </div>
                </div>
                <div class="menu-item">
                    <img src="IMG/image (3).png" alt="Dish 1">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>S/. **.**</span>
                    <button class="info-button">Más información</button>
                        <div class="popup">
                            <img src="IMG/image (3).png" alt="Dish 1">
                            <h3>Detalle del Platillo</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                            <span>S/. **.**</span>
                        </div>
                </div>
                <div class="menu-item">
                    <img src="IMG/image.png" alt="Dish 1">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>S/. **.**</span>
                    <button class="info-button">Más información</button>
                    <div class="popup">
                        <img src="IMG/image.png" alt="Dish 1">
                        <h3>Detalle del Platillo</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                        <span>S/. **.**</span>
                    </div>
                </div>              
                <div class="menu-item">
                    <img src="IMG/image (1).png" alt="Dish 1">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>S/. **.**</span>
                    <button class="info-button">Más información</button>
                        <div class="popup">
                            <img src="IMG/image (1).png" alt="Dish 1">
                            <h3>Detalle del Platillo</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                            <span>S/. **.**</span>
                        </div>
                </div>
                <div class="menu-item">
                    <img src="IMG/image (2).png" alt="Dish 1">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>S/. **.**</span>
                    <button class="info-button">Más información</button>
                        <div class="popup">
                            <img src="IMG/image (2).png" alt="Dish 1">
                            <h3>Detalle del Platillo</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                            <span>S/. **.**</span>
                        </div>
                </div>
                <div class="menu-item">
                    <img src="IMG/image (3).png" alt="Dish 1">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    <span>S/. **.**</span>
                    <button class="info-button">Más información</button>
                        <div class="popup">
                            <img src="IMG/image (3).png" alt="Dish 1">
                            <h3>Detalle del Platillo</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.</p>
                            <span>S/. **.**</span>
                        </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const infoButtons = document.querySelectorAll('.info-button');
        const closeButtons = document.querySelectorAll('.close');
        const popups = document.querySelectorAll('.popup');

        infoButtons.forEach(button => {
            button.addEventListener('click', function() {
                const popup = this.nextElementSibling;
                popup.style.display = 'block';
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const popup = this.parentElement;
                popup.style.display = 'none';
            });
        });

        // Cerrar el pop-up al hacer clic fuera de él
        document.addEventListener('click', function(event) {
            popups.forEach(popup => {
                if (popup.style.display === 'block' && !popup.contains(event.target) && !event.target.classList.contains('info-button')) {
                    popup.style.display = 'none';
                }
            });
        });
    });
</script>    
        
</body>
</html>