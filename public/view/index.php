<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Architecture</title>
<!--
Strip
http://www.templatemo.com/tm-482-strip
-->
    <!-- load stylesheets -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400">   <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="public/css/bootstrap.min.css">                                      <!-- Bootstrap style -->
    <link rel="stylesheet" href="public/css/templatemo-style.css">                                   <!-- Templatemo style -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
    <style>
        #exitButton:hover {
            background-color: #9a6600;
            transition: all 0.3s ease;
        }
    </style>
</head>

    <body>
        <div class="container tm-container">
            <div class="row navbar-row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 navbar-container">

                    <a href="javascript:void(0)" class="navbar-brand" id="go-to-top">ARCH</a>

                    <nav class="navbar navbar-full">

                        <div class="collapse navbar-toggleable-md" id="tmNavbar">

                            <ul class="nav navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="#tm-section-1">Введение</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tm-section-2">Сервисы</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tm-section-3">О нас</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tm-section-4">Контакты</a>
                                </li>
                                <?php if(!$_SESSION['user']) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="" data-toggle="modal" data-target="#exampleModal">Аккаунт</a>
                                    </li>
                                <?php }
                                else { ?>
                                    <li class="nav-item" id="exitButton">
                                        <form method="post" >
                                            <button  type="submit" class="nav-link" name="exit" value="1"
                                                     style="background: none; border: none;">
                                                Выход
                                            </button>
                                        </form>
                                    </li>
                                <?php } ?>

                            </ul>

                        </div>

                    </nav>

                    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#tmNavbar">
                        &#9776;
                    </button>

                </div>

            </div>
            
            <div class="tm-page-content">
                <!-- #home -->
                <div style="color: black">
                <?php
                $auth = new App\Jobs\Auth\Auth();
                $status = $auth->status->status;
                //var_dump($status);
                if(isset($status['message']) || $status['required']) {?>
                    <div class="row navbar-row" style="background-color: black; margin-top: 80px;">
                        <div class="navbar-container col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-12" style="z-index: 100;background-color: #ff0000;">
                            <div>
                                <?php
                                echo($status['message']);
                                ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </div>

                <section id="tm-section-1" class="row tm-section">


                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="post" style="color: black;">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h5>Вход</h5>
                                    </div>
                                    <div class="modal-body">
                                        <label style="color: black; width: 100%;">
                                            Логин:
                                            <input type="text" name="login" class="form-control">
                                        </label>
                                        <br>
                                        <label style="color: black; width: 100%;">
                                            Пароль:
                                            <input type="password" name="password" class="form-control">
                                        </label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" style="float: left;" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">Регистрация</button>
                                        <button type="submit" class="btn btn-primary" name="auth" value="1">Вход</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="post" style="color: black;">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h5>Регистрация</h5>
                                    </div>
                                    <div class="modal-body">
                                        <label style="color: black; width: 100%;">
                                            Логин:
                                            <input type="text" name="login" class="form-control">
                                        </label>
                                        <br>
                                        <label style="color: black; width: 100%;">
                                            Пароль:
                                            <input type="password" name="password" class="form-control">
                                        </label>
                                        <label style="color: black; width: 100%;">
                                            Повторите пароль:
                                            <input type="password" name="confirm_password" class="form-control">
                                        </label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" style="float: left;" data-toggle="modal" data-target="#exampleModal" data-dismiss="modal">Вход</button>
                                        <button type="submit" class="btn btn-primary" name="register" value="1">Регистрация</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tm-white-curve-left col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-6">
                        <div class="tm-white-curve-left-rec"></div>
                        <div class="tm-white-curve-left-circle"></div>
                        <div class="tm-white-curve-text">
                            <h2 class="tm-section-header blue-text">Введение</h2>
                            <p>
                                Архитекту́ра, или зо́дчество — искусство и наука строить, проектировать здания и сооружения (включая их комплексы), а также сама совокупность зданий и сооружений, создающих пространственную среду для жизни и деятельности человека.
                            </p>
                            <p>
                                Архитектура создаёт материально организованную среду, необходимую людям для их жизни и деятельности.
                            </p>
                        </div>                        
                    </div>

                    <div class="tm-home-right col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-6">
                        <h2 class="tm-section-header">Наша цель</h2>
                        <p class="thin-font">
                            Заставить людей начать видеть и чувствовать исскуство, в своём истинном проявлении, находящиеся лишь за обезличенными зданиями большого города.
                        </p>
                    </div>
                    
                </section> <!-- #home -->

                <!-- #services -->
                <section id="tm-section-2" class="row tm-section">
                    <div class="tm-flex-center col-xs-12 col-sm-6 col-md-6 col-lg-5 col-xl-6">
                        <img src="public/img/strip-01.jpg" alt="Image" class="img-fluid tm-img">
                    </div>

                    <div class="tm-white-curve-right col-xs-12 col-sm-6 col-md-6 col-lg-7 col-xl-6">
                        
                        <div class="tm-white-curve-right-circle"></div>
                        <div class="tm-white-curve-right-rec"></div>
                        
                        <div class="tm-white-curve-text">
                            <h2 class="tm-section-header red-text">Мы предлагаем</h2>
                            <p><b>Красивые вещи</b>. Красота — наверное, самая сложная категория для архитектуры.</p>
                            <p><b>Историю</b>. Архитектура в большей степени, чем любое другое искусство, является живым свидетелем истории.</p>
                            <p><b>Знания</b>. Если архитектура помогает узнать о прошлом, то и о настоящем она говорит не меньше. </p>
                        </div>
                        
                    </div>
                </section> <!-- #services -->

                <!-- #about -->
                <section id="tm-section-3" class="row tm-section">
                    <div class="tm-white-curve-left col-xs-12 col-sm-6 col-md-6 col-lg-7 col-xl-6">
                        <div class="tm-white-curve-left-rec">
                            
                        </div>
                        <div class="tm-white-curve-left-circle">
                            
                        </div>
                        <div class="tm-white-curve-text">
                            <h2 class="tm-section-header gray-text">О нашей компании</h2>
                            <p class="thin-font">Мы молодая развивающаяся компания, занимающаяся архитектурой городов, домов, памятников и некоторых объектов исскуства.</p>
                            <p>В нашем коллективе собрались самые талантливые и творческие люди страны. Не верите,проверьте сами.</p>
                            <p>Мы не просто работаем. Мы работаем от души.</p>
                        </div>
                        
                    </div>
                    <div class="tm-flex-center col-xs-12 col-sm-6 col-md-6 col-lg-5 col-xl-6">
                        <img src="public/img/strip-02.jpg" alt="Image" class="img-fluid tm-img">
                    </div>
                </section> <!-- #about -->

                <!-- #contact -->
                <section id="tm-section-4" class="row tm-section">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-5 col-xl-6 tm-contact-left">
                        <h2 class="tm-section-header thin-font col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">Отправьте нам письмо</h2>
                        <form action="index.php" method="post" class="contact-form">

                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12 col-xl-6 tm-contact-form-left">
                                <div class="form-group">
                                    <input type="text" id="contact_name" name="contact_name" class="form-control" placeholder="Имя"  required/>
                                </div>
                                <div class="form-group">
                                    <input type="email" id="contact_email" name="contact_email" class="form-control" placeholder="Email"  required/>
                                </div>
                                <div class="form-group">
                                    <input type="text" id="contact_subject" name="contact_subject" class="form-control" placeholder="Тема"  required/>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-12 col-xl-6 tm-contact-form-right">
                                <div class="form-group">
                                    <textarea id="contact_message" name="contact_message" class="form-control" rows="6" placeholder="Сообщение" required></textarea>
                                </div>
                                
                                <button type="submit" class="btn submit-btn">Отправьте сейчас</button>
                            </div>

                        </form>   
                    </div>

                    <div class="tm-white-curve-right col-xs-12 col-sm-6 col-md-6 col-lg-7 col-xl-6">
                        
                        <div class="tm-white-curve-right-circle"></div>
                        <div class="tm-white-curve-right-rec"></div>
                        
                        <div class="tm-white-curve-text">
                            
                            <h2 class="tm-section-header green-text">Свяжитесь с нами</h2>
                            <p>Свяжитесь с нами!</p>
                            <p>Мы отвечаем на все ваши вопросы. В кратчайшие сроки.</p>

                            <h3 class="tm-section-subheader green-text">Наш адрес</h3>
                            <address>
                                110-220 Praesent consectetur, Dictum massa 10550
                            </address>
                            
                            <div class="contact-info-links-container">
                                <span class="green-text contact-info">
                                	Tel: <a href="tel:0100200340" class="contact-info-link">010-020-0340</a></span>
                                <span class="green-text contact-info">
                                	Email: <a href="mailto:info@company.com" class="contact-info-link">info@company.com</a></span>    
                            </div>
                            
                        </div>                        

                    </div>
                </section> <!-- #contact -->

                <!-- footer -->
                <footer class="row tm-footer">
                    
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                        <p class="text-xs-center tm-footer-text">
                            Copyright &copy; 2020 Rikz
                        </p>
                        
                    </div>
                    
                </footer>                      

            </div>
             
        </div> <!-- .container -->
        
        <!-- load JS files -->
        
        <script src="public/js/jquery-1.11.3.min.js"></script>             <!-- jQuery (https://jquery.com/download/) -->
        <script src="https://www.atlasestateagents.co.uk/javascript/tether.min.js"></script><!-- Tether for Bootstrap, http://stackoverflow.com/questions/34567939/how-to-fix-the-error-error-bootstrap-tooltips-require-tether-http-github-h --> 
        <script src="public/js/bootstrap.min.js"></script>                 <!-- Bootstrap (http://v4-alpha.getbootstrap.com/) -->
        <script src="public/js/jquery.singlePageNav.min.js"></script>      <!-- Single Page Nav (https://github.com/ChrisWojcik/single-page-nav) -->
        
        <!-- Templatemo scripts -->
        <script>     

        var bigNavbarHeight = 90;
        var smallNavbarHeight = 68;
        var navbarHeight = bigNavbarHeight;                 
    
        $(document).ready(function(){

            var topOffset = 180;

            $(window).scroll(function(){

                if($(this).scrollTop() > topOffset) {
                    $(".navbar-container").addClass("sticky");
                }
                else {
                    $(".navbar-container").removeClass("sticky");
                }

            });

            /* Single page nav
            -----------------------------------------*/

            if($(window).width() < 992) {
                navbarHeight = smallNavbarHeight;
            }

            $('#tmNavbar').singlePageNav({
               'currentClass' : "active",
                offset : navbarHeight
            });


            /* Collapse menu after click 
               http://stackoverflow.com/questions/14203279/bootstrap-close-responsive-menu-on-click
            ----------------------------------------------------------------------------------------*/

            $('#tmNavbar').on("click", "a", null, function () {
                $('#tmNavbar').collapse('hide');               
            });

            // Handle nav offset upon window resize
            $(window).resize(function(){
                if($(window).width() < 992) {
                    navbarHeight = smallNavbarHeight;
                } else {
                    navbarHeight = bigNavbarHeight;
                }

                $('#tmNavbar').singlePageNav({
                    'currentClass' : "active",
                    offset : navbarHeight
                });
            });
            

            /*  Scroll to top
                http://stackoverflow.com/questions/5580350/jquery-cross-browser-scroll-to-top-with-animation
            --------------------------------------------------------------------------------------------------*/
            $('#go-to-top').each(function(){
                $(this).click(function(){ 
                    $('html,body').animate({ scrollTop: 0 }, 'slow');
                    return false; 
                });
            });
            
        });
    
        </script>             

    </body>
    </html>