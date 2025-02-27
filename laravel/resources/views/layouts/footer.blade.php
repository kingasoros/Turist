<footer>
    <div class="footer__div">
        <div class="footer__container">
            <ul>
                <li>Ecotrips Kft.</li>
                <li>Minta utca 12.,</li>
                <li>1101 Budapest,</li>
                <li>Magyarország</li>
                <li>+36 30 123 4567</li>
                <li>ugyfelszolgalat@mintaceg.hu</li>
            </ul>   
        </div>
        <div class="footer__container footer__app">
            <?php
               $userAgent = $_SERVER['HTTP_USER_AGENT'];
               
               if (preg_match('/mobile/i', $userAgent)) {
                   echo '<a class="app__text" href="https://192.168.1.6:8081">Töltsd le az applikációt!</a>';
               } else {
                   echo '';
               }
               
            ?>
            <p>&copy; {{ date('Y') }} My Application. All rights reserved.</p>
        </div>
    </div>
</footer>    
</body>
</html>
