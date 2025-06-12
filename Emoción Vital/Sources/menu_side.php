<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <link rel="stylesheet" href="../Style/style_menu_side.css">

    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
</head>
<body id="body">
    
    <header>
        <div class="icon__menu">
            <i class="fas fa-bars" id="btn_open"></i>
        </div>

        <div class="container">
            <div class="search_container">
                <input type="text" class="search_input" placeholder="Buscar...">
                <div class="search_icon">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
    </header>

    <div class="menu__side" id="menu_side">

        <div class="name__page">
            <i class="fab fa-t"></i>
            <h4>TwiFa</h4>
        </div>

        <div class="options__menu">	

            <a href="#" class="selected">
                <div class="option">
                    <i class="fas fa-home" title="Inicio"></i>
                    <h4>Inicio</h4>
                </div>
            </a>

            <a href="#">
                <div class="option">
                    <i class="far fa-bell" title="Notificaciones"></i>
                    <h4>Notificaciones</h4>
                </div>
            </a>
            
            <a href="../Sources/chat.html">
                <div class="option">
                    <i class="fas fa-message" title="Mensajes"></i>
                    <h4>Mensajería</h4>
                </div>
            </a>

            <a href="#">
                <div class="option">
                    <i class="fas fa-microphone" title="Reunión"></i>
                    <h4>Reunión</h4>
                </div>
            </a>

            <a href="../Sources/perfil_usuario.html">
                <div class="option">
                    <i class="fas fa-person" title="Perfil"></i>
                    <h4>Perfil</h4>
                </div>
            </a>

            <a href="../php/cerrar_sesion.php">
                <div class="option">
                    <i class="fas fa-close" title="Cerrar sesión"></i>
                    <h4>Cerrar sesión</h4>
                </div>
            </a>

        </div>

    </div>

    <main>


    <div class="main">

       <!------------center---------------------->

        <div class="center">
          
            <div class="my_post">

                <div class="post_top">

                    <img src="../images/profile.png">
                    <input type="text" placeholder="¿Qué estas pensando?">

                </div>

                <hr>

                <div class="post_bottom">

                    <div class="post_icon">
                        <i class="fa-solid fa-video red"></i>
                        <p>Vídeo</p>
                    </div>

                    <div class="post_icon">
                        <i class="fa-solid fa-images green"></i>
                        <p>Foto</p>
                    </div>

                    <div class="post_icon">
                        <i class="fa-regular fa-face-grin yellow"></i>
                        <p>Emoción</p>
                    </div>

                </div>

            </div>


            <div class="room">
                
                <div class="room_image">

                    <img src="../images/live_video.png">
                    <p class="room_tag">Crear Reunión</p>

                </div>

                <div class="room_profile">

                    <img src="../images/profile_1.jpg">
                    <img src="../images/profile_2.jpg">
                    <img src="../images/profile_3.jpg">
                    <img src="../images/profile_4.png">
                    <img src="../images/profile_5.png">
                    <img src="../images/profile_6.png">
                    <img src="../images/profile_7.png">
                    <img src="../images/profile_8.png">

                </div>

            </div>


            <div class="friends_post">

                <div class="friend_post_top">

                    <div class="img_and_name">

                        <img src="../images/contact_2.jpg">

                        <div class="friends_name">
                            <p class="friends_name">
                                Paco de la Cruz
                            </p>
                            <p class="time">16h.<i class="fa-solid fa-user-group"></i></p>
                        </div>
                        

                    </div>

                    <div class="menu">

                        <i class="fa-solid fa-ellipsis"></i>

                    </div>

                </div>

                <img src="../images/post_1.jpg">

                <div class="info">

                    <div class="emoji_img">
                        <img src="../images/like.png">
                        <img src="../images/haha.png">
                        <img src="../images/heart.png">
                        <p>Tú, Carlos Perez y 25K personas mas</p>
                    </div>

                    <div class="comment">
                        <p>421 Comentarios</p>
                        <p>1.3K Compartido</p>
                    </div>

                </div>

                <hr>

                <div class="like">

                    <div class="like_icon">
                        <i class="fa-solid fa-thumbs-up activi"></i>
                        <p>Like</p>
                    </div>

                    <div class="like_icon">
                        <i class="fa-solid fa-message"></i>
                        <p>Comentarios</p>
                    </div>

                    <div class="like_icon">
                        <i class="fa-solid fa-share"></i>
                        <p>Compartir</p>
                    </div>

                </div>

                <hr>

                <div class="comment_warpper">

                    <img src="../images/profile.png">
                    <div class="circle"></div>

                    <div class="comment_search">

                        <input type="text" placeholder="Escribir comentario">
                        <i class="fa-regular fa-face-smile"></i>
                        <i class="fa-solid fa-camera"></i>
                        <i class="fa-regular fa-note-sticky"></i>

                    </div>

                </div>

            </div>

            <div class="friends_post">

                <div class="friend_post_top">

                    <div class="img_and_name">

                        <img src="../images/profile_9.png">

                        <div class="friends_name">
                            <p class="friends_name">
                                Pedro Calles
                            </p>
                            <p class="time">16h.<i class="fa-solid fa-user-group"></i></p>
                        </div>
                        

                    </div>

                    <div class="menu">

                        <i class="fa-solid fa-ellipsis"></i>

                    </div>

                </div>

                <img src="../images/post_2.jpg">

                <div class="info">

                    <div class="emoji_img">
                        <img src="../images/like.png">
                        <img src="../images/haha.png">
                        <img src="../images/heart.png">
                        <p>Tu, Paco de la Cruz y 25K personas mas</p>
                    </div>

                    <div class="comment">
                        <p>421 Comentarios</p>
                        <p>1.3K Compartido</p>
                    </div>

                </div>

                <hr>

                <div class="like">

                    <div class="like_icon">
                        <i class="fa-solid fa-thumbs-up activi"></i>
                        <p>Like</p>
                    </div>

                    <div class="like_icon">
                        <i class="fa-solid fa-message"></i>
                        <p>Comentarios</p>
                    </div>

                    <div class="like_icon">
                        <i class="fa-solid fa-share"></i>
                        <p>Compartir</p>
                    </div>

                </div>

                <hr>

                <div class="comment_warpper">

                    <img src="../images/profile.png">
                    <div class="circle"></div>

                    <div class="comment_search">

                        <input type="text" placeholder="Ecribir comentario">
                        <i class="fa-regular fa-face-smile"></i>
                        <i class="fa-solid fa-camera"></i>
                        <i class="fa-regular fa-note-sticky"></i>

                    </div>

                </div>

            </div>

            <div class="friends_post">

                <div class="friend_post_top">

                    <div class="img_and_name">

                        <img src="../images/profile_10.png">

                        <div class="friends_name">
                            <p class="friends_name">
                                Emilia Gómez
                            </p>
                            <p class="time">16h.<i class="fa-solid fa-user-group"></i></p>
                        </div>
                        

                    </div>

                    <div class="menu">

                        <i class="fa-solid fa-ellipsis"></i>

                    </div>

                </div>

                <img src="../images/post_3.png">

                <div class="info">

                    <div class="emoji_img">
                        <img src="../images/like.png">
                        <img src="../images/haha.png">
                        <img src="../images/heart.png">
                        <p>Tú, Carlos Perez y 10K personas más</p>
                    </div>

                    <div class="comment">
                        <p>421 Comentarios</p>
                        <p>1.3K Compartido</p>
                    </div>

                </div>

                <hr>

                <div class="like">

                    <div class="like_icon">
                        <i class="fa-solid fa-thumbs-up activi"></i>
                        <p>Like</p>
                    </div>

                    <div class="like_icon">
                        <i class="fa-solid fa-message"></i>
                        <p>Comentarios</p>
                    </div>

                    <div class="like_icon">
                        <i class="fa-solid fa-share"></i>
                        <p>Compartir</p>
                    </div>

                </div>

                <hr>

                <div class="comment_warpper">

                    <img src="../images/profile.png">
                    <div class="circle"></div>

                    <div class="comment_search">

                        <input type="text" placeholder="Escribir comentario">
                        <i class="fa-regular fa-face-smile"></i>
                        <i class="fa-solid fa-camera"></i>
                        <i class="fa-regular fa-note-sticky"></i>

                    </div>

                </div>

            </div>

            <div class="friends_post">

                <div class="friend_post_top">

                    <div class="img_and_name">

                        <img src="../images/profile_11.png">

                        <div class="friends_name">
                            <p class="friends_name">
                                Karla Jimenez
                            </p>
                            <p class="time">16h.<i class="fa-solid fa-user-group"></i></p>
                        </div>
                        

                    </div>

                    <div class="menu">

                        <i class="fa-solid fa-ellipsis"></i>

                    </div>

                </div>

                <img src="../images/post_4.jpg">

                <div class="info">

                    <div class="emoji_img">
                        <img src="../images/like.png">
                        <img src="../images/haha.png">
                        <img src="../images/heart.png">
                        <p>Tu, Emilia Gómez y 5K personas mas</p>
                    </div>

                    <div class="comment">
                        <p>421 Comentarios</p>
                        <p>1.3K Compartido</p>
                    </div>

                </div>

                <hr>

                <div class="like">

                    <div class="like_icon">
                        <i class="fa-solid fa-thumbs-up activi"></i>
                        <p>Like</p>
                    </div>

                    <div class="like_icon">
                        <i class="fa-solid fa-message"></i>
                        <p>Comentarios</p>
                    </div>

                    <div class="like_icon">
                        <i class="fa-solid fa-share"></i>
                        <p>Compartir</p>
                    </div>

                </div>

                <hr>

                <div class="comment_warpper">

                    <img src="../images/profile.png">
                    <div class="circle"></div>

                    <div class="comment_search">

                        <input type="text" placeholder="Escribir comentario">
                        <i class="fa-regular fa-face-smile"></i>
                        <i class="fa-solid fa-camera"></i>
                        <i class="fa-regular fa-note-sticky"></i>

                    </div>

                </div>

            </div>

            <div class="friends_post">

                <div class="friend_post_top">

                    <div class="img_and_name">

                        <img src="../images/profile_12.jpg">

                        <div class="friends_name">
                            <p class="friends_name">
                                Dulce de Piña
                            </p>
                            <p class="time">16h.<i class="fa-solid fa-user-group"></i></p>
                        </div>
                        

                    </div>

                    <div class="menu">

                        <i class="fa-solid fa-ellipsis"></i>

                    </div>

                </div>

                <img src="../images/post_5.jpg">

                <div class="info">

                    <div class="emoji_img">
                        <img src="../images/like.png">
                        <img src="../images/haha.png">
                        <img src="../images/heart.png">
                        <p>You, Charith Disanayaka and 25K others</p>
                    </div>

                    <div class="comment">
                        <p>421 Comentarios</p>
                        <p>1.3K Compartido</p>
                    </div>

                </div>

                <hr>

                <div class="like">

                    <div class="like_icon">
                        <i class="fa-solid fa-thumbs-up activi"></i>
                        <p>Like</p>
                    </div>

                    <div class="like_icon">
                        <i class="fa-solid fa-message"></i>
                        <p>Comentarios</p>
                    </div>

                    <div class="like_icon">
                        <i class="fa-solid fa-share"></i>
                        <p>Compartir</p>
                    </div>

                </div>

                <hr>

                <div class="comment_warpper">

                    <img src="../images/profile.png">
                    <div class="circle"></div>

                    <div class="comment_search">

                        <input type="text" placeholder="Escribir comentario">
                        <i class="fa-regular fa-face-smile"></i>
                        <i class="fa-solid fa-camera"></i>
                        <i class="fa-regular fa-note-sticky"></i>

                    </div>

                </div>

            </div>

            <div class="loard">
                <button>Loard More</button>
            </div>
        </div>

        </div>

            </div>

        </div>

    </div>

    
    </main>

    <script src="../Js/script_menu_side.js"></script>
</body>
</html>