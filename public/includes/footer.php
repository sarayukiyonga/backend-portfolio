    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; <?php echo date('Y'); ?> Saray Martínez Guzmán. Todos los derechos reservados.</p>
            <p>
                <a href="mailto:info@saraymartinez.com" aria-label="Enviar email a info@saraymartinez.com">info@saraymartinez.com</a> | 
                <a href="tel:+34646220816" aria-label="Llamar al 646 220 816">646 220 816</a>
            </p>
            <!-- <div class="footer-social">
                <a href="https://wa.me/+34646220816" target="_blank" rel="noopener noreferrer" aria-label="Contactar por WhatsApp">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                </a>
                <a href="https://www.linkedin.com/in/saraymartinez" target="_blank" rel="noopener noreferrer" aria-label="Perfil de LinkedIn">
                    <i class="fab fa-linkedin" aria-hidden="true"></i>
                </a>
            </div> -->
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function w3_open() {
            document.getElementById("mySidebar").style.width = "100%";
            document.getElementById("mySidebar").style.display = "block";
            document.getElementById("menumobile").setAttribute("aria-expanded", "true");
        }
        function w3_close() {
            document.getElementById("mySidebar").style.display = "none";
            document.getElementById("menumobile").setAttribute("aria-expanded", "false");
        }
    </script>
    <!-- <?php if (isset($additionalScripts)) echo $additionalScripts; ?> -->
</body>
</html>
