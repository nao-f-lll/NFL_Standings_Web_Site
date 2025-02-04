<?php
$xmlPath = "./XmlXsl/csleague.xml";

// Load the XML file if exists
if (file_exists($xmlPath)) {
    $xml = simplexml_load_file($xmlPath);
    $temporadaNum = "0";
    $temporadaActiva = $xml->xpath("//Temporada[Estado='ACTIVA']");

    if ($temporadaActiva) {
        $temporadaNum = $temporadaActiva[0]->Numero;
    } else {
        $temporadaActiva = $xml->xpath("//Temporada[Estado='FINALIZADA']");
        if ($temporadaActiva) {
            $lastIndex = count($temporadaActiva) - 1;
            $temporadaNum = $temporadaActiva[$lastIndex]->Numero;
        } else {
            $temporadaActiva = $xml->xpath("//Temporada[Estado='PROXIMAMENTE']");
            if ($temporadaActiva) {
                $temporadaNum = $temporadaActiva[0]->Numero;
            } else {
                exit('No hay temporadas disponibles');
            }
        }
    }



    $equiposTemporada = $xml->xpath("//Temporada[Numero='$temporadaNum']/Equipos/Equipo");
} else {
    exit('No se ha encontrado el archivo XML');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script> <!-- tailwindcss CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" href="img/logo.png" type="image/x-icon">
    <title>Inicio</title>
</head>

<!--
    Colores:
    amarillo: #ffff09
    bg navbar: #1d1d1b
-->

<body class="w-screen h-full m-0 p-0 md:flex md:flex-row">
    <!-- ANIMACION DE CARGA -->
    <div id="loading" class="w-screen h-screen absolute z-50 bg-black">
        <div class="flex justify-center w-full h-full ">
            <div class="flex flex-col items-center justify-center animate-pulse">
                <h1 class="text-lg sm:text-2xl font-bold text-[#ffff09]">
                    CARGANDO...
                </h1>
                <img src="img/scope-yellow.svg" alt="" class="w-20 md:w-60 animate-spin">
            </div>



        </div>
    </div>

    <div id="header-container"></div>
    <div id="login-container"></div>

    <div class="w-full h-screen m-0 p-0  overflow-y-auto bg-cover bg-scroll bg-bottom bg-no-repeat shadow-lg" style="background-image:url('img/fondo2.jpg');">
        <div class="w-full h-auto backdrop-blur-sm bg-cover  bg-no-repeat flex flex-col items-center">

            <section class="">
                <div class="grid max-w-screen-xl px-4 py-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12">
                    <div class="mr-auto place-self-center lg:col-span-7">
                        <h1 class="max-w-2xl mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl xl:text-6xl dark:text-white">Conoce las Últimas Noticias</h1>
                        <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">Mantente al tanto de todas las novedades de la CSL, conoce los últimos fichajes de tu equipo favorito.</p>
                        <a href="#" class="inline-flex items-center justify-center px-5 py-3 mr-3 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-primary-900">
                            <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="noticias.php" class="inline-flex bg-[#ffff09] items-center justify-center px-5 py-3 text-base font-medium text-center text-gray-900 border border-gray-900 rounded-lg hover:bg-red-600">
                            Ver Noticias
                        </a>
                    </div>
                    <div class="hidden lg:mt-0 lg:col-span-5 lg:flex">
                        <img src="img/imagen1.jpg" alt="mockup" class="rounded-2xl border-2 rounded-lg border-sky-200 shadow-[0_0_2px_#fff,inset_0_0_2px_#fff,0_0_5px_#ff0,0_0_15px_#ff0,0_0_30px_#ff0]">
                    </div>
                </div>
            </section>

            <!-- Sección lista de equipos de la temporada actual -->
            <!--Sección lista de equipos de la temporada actual-->
            <section class="w-full h-full  flex flex-col items-center bg-[url('img/estadio.jpg')] bg-cover bg-no-repeat bg-local  bg-opacity-10 md:w-10/12 overflow-hidden">
                <div class="w-full h-auto sm:h-auto bg-[#ffff09]  flex flex-nowrap flex-col sm:flex-row">
                    <img src="img/scope.svg" alt="" class="hidden w-8 md:block">
                    <div class="w-full md:w-3/4 h-full ml-1">
                        <h1 class="text-3xl font-extrabold">EQUIPOS TEMPORADA ACTUAL</h1>
                    </div>

                </div>

                <div class="flex flex-row backdrop-blur-lg">
                    <div class="">
                        <button type="button" id="carruselBefore" class="relative top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#ffff09]/80 group-hover:bg-[#ffff09]/50">
                                <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="#000000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                    </div>

                    <div id="contenedorCarrusel" class="w-full h-96 mt-16 flex justify-center">
                        <div class="">
                            <a href="javascript:void(0);" onclick="submitForm('<?php echo $equiposTemporada[0]->Nombre; ?>')">
                                <img src="XmlXsl/<?php echo $equiposTemporada[0]->Escudo; ?>" alt="<?php echo $equiposTemporada[0]->Nombre; ?>" class="w-60">
                            </a>
                            <?php
                            foreach ($equiposTemporada as $index => $equipo) {
                                if ($index > 0) { // Si ya se mostró el primer equipo
                            ?>
                                    <a href="javascript:void(0);" onclick="submitForm('<?php echo $equipo->Nombre; ?>')" class="">
                                        <img src="XmlXsl/<?php echo $equipo->Escudo; ?>" alt="<?php echo $equipo->Nombre; ?>" class="w-60 hidden">
                                    </a>
                            <?php
                                }
                            }
                            ?>

                        </div>

                    </div>
                    <div>
                        <button type="button" id="carruselNext" class="relative top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#ffff09]/80 group-hover:bg-[#ffff09]/50">
                                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>

                </div>
            </section>
            <iframe src="https://laurita19.github.io/cubitomalito/" width="800" height="400" frameborder="0" scrolling="no"></iframe>
        </div>
        <div id="footer-container"></div>

    </div>
    <form id="postForm" action="club.php" method="post" style="display: none;">
                                <input type="hidden" id="clubIDInput" name="clubID">
                            </form>
    <script>
        function submitForm(clubID) {
            document.getElementById('clubIDInput').value = clubID;
            document.getElementById('postForm').submit();
        }
    </script>
    <script src="js/loading.js"></script>
    <script src="js/carruselEquipos.js"></script>
</body>

</html>