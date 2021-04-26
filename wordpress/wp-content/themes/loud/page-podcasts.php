<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<style>

    .container_2 {
  position: relative;
}

    img {
        width: 100%;
    }

    .antal {
        margin-top: 0;
    }

    .navn {
        margin-bottom: 10px;
        margin-top: 10px;
    }

    .container {
        cursor: pointer;
        color: white;
        text-align: center;
    }

    button.filter {
        background-color: #232323;
        color: white;

    }

    .valgt {
         background-color: #DB083A;
    }

    button.valgt {
            background-color: #232323;
         color: white;
        text-align: center;
        }

     button.valgt:hover {
        background-color: #DB083A;
        color: white;

    }

    .main-navigation ul li a, article, aside, details, figcaption, figure, footer, header, main, nav, section {
    text-align: center;
}


     button.filter:hover {
        background-color: #DB083A;
        color: white;
         text-align: center;

    }


     button.filter:active {
        background-color: #DB083A;
        color: white;

    }


    #podcastcontainer {
            margin: 60px;
        }

    img {
        border-radius: 17px;
  opacity: 1;
  display: block;
  width: 100%;
  height: auto;
  transition: .5s ease;
  backface-visibility: hidden;
    }

    .middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

    .container_2:hover img{
        opacity: 0.3;
    }

        .container_2:hover .middle {
  opacity: 1;
}

    @media (min-width: 800px) {


        /*---------------grid i desktop----------------*/

        #podcastcontainer {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-auto-flow: dense;
            grid-gap: 20px;
        }

        /*Billederne som ikke tilhører de nedstående grid spans strækker sig kun 2 spans og fylder derfor mindre*/
        .menu {
            grid-column: span 2;
        }

</style>


<template>
    <article class="menu">
        <div class="container">
           <div class="container_2">
            <img src="" alt="" class="billede">
            <div class="middle"><p class="kort"></p>
            </div>
            </div>

            <h3 class="navn">
            </h3>
            <p class="antal"></p>
        </div>

    </article>
</template>

<div id="primary" <?php lalita_content_class();?>>
    <main id="main" <?php lalita_main_class(); ?>>


        <nav id="filtrering" class="filter">
        <button data-podcast="alle" class="valgt">Alle</button>
        </nav>




        <section id="podcastcontainer"></section>

    </main><!-- #main -->

    <script>
        let podcasts;
        let categories;
        let filterPodcast = "alle";


        function start() {
            const filterKnapper = document.querySelectorAll(".filter button");
            filterKnapper.forEach(knap => knap.addEventListener("click", filtrerMenu));
            loadJSON();
        }

        function filtrerMenu() {
            filter = this.dataset.podcast; //sæt variabel "filter" til værdien af data-troende på den knap der er klikket på
            console.log("filter", filter);
            document.querySelector(".valgt").classList.remove("valgt");
            this.classList.add("valgt");
        }


        const dbUrl = "http://indiamillward.dk/radioloud/wp-json/wp/v2/podcast?per_page=100";

        const catURL = "http://indiamillward.dk/radioloud/wp-json/wp/v2/categories";


        async function getJson() {
            const data = await fetch(dbUrl);
            const catdata = await fetch(catURL);
            podcasts = await data.json();
             categories = await catdata.json();
            console.log(categories);
            visPodcasts();
            opretknapper();
        }

             function opretknapper(){
            categories.forEach(cat =>{
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-podcast="${cat.id}">${cat.name}</button>`
            })

            addEventListenerToButtons();
        }


        function addEventListenerToButtons(){
            document.querySelectorAll("#filtrering button").forEach(elm =>{
                elm.addEventListener("click", filtrering);

            })

        }

        function filtrering(){
            filterPodcast = this.dataset.podcast;
            console.log(filterPodcast);
            visPodcasts();
        }



        function visPodcasts() {
            let temp = document.querySelector("template");
            let container = document.querySelector("#podcastcontainer");
             container.innerHTML = "";
            podcasts.forEach(podcast => {
                if( filterPodcast == "alle" || podcast.categories.includes(parseInt(filterPodcast))){
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h3").textContent = podcast.title.rendered;
                klon.querySelector("img").src = podcast.billede.guid;
                klon.querySelector(".antal").textContent = podcast.antal;
                klon.querySelector(".kort").textContent = podcast.kort;
                klon.querySelector("article").addEventListener("click", ()=> {location.href = podcast.link;})
                container.appendChild(klon);
                }
            })

        }



        getJson();

    </script>

</div><!-- #primary -->

<?php
	/**
	 * lalita_after_primary_content_area hook.
	 *
	 */
	 do_action( 'lalita_after_primary_content_area' );

	 lalita_construct_sidebars();

get_footer();
