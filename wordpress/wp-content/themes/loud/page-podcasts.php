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
    main {
        background-color: #FFD8E2;
    }

    #filtrering {
        background-color: #232323;
    }

    #podcastcontainer {
        margin: 0;
        padding: 30px;
        background-color: #232323;

    }


    .container_2 {
        position: relative;
    }

    main {
        padding-top: 100px;
    }

    img {
        width: 100%;
    }

    .antal {
        margin-top: 0;
    }

    .navn {
        margin-bottom: 10px;
        margin-top: 15px;
        font-family: "Roboto", Sans-serif;

    }

    .container {
        cursor: pointer;
        color: white;
        text-align: center;
    }


    button.filter {
        background-color: #232323;
        color: white;
        padding: 16px 20px 16px 20px;
        margin-right: 10px;
        margin-left: 10px;
        font-family: "Roboto", Sans-serif;
        margin-top: 70px;
        border-radius: 7px;

    }

    button.filter:hover {
        background-color: #fcd535;
        border-radius: 7px;

    }

    .elementor-kit-4 button:hover,
    .elementor-kit-4 button:focus,
    .elementor-kit-4 input[type="button"]:hover,
    .elementor-kit-4 input[type="button"]:focus,
    .elementor-kit-4 input[type="submit"]:hover,
    .elementor-kit-4 input[type="submit"]:focus,
    .elementor-kit-4 .elementor-button:hover,
    .elementor-kit-4 .elementor-button:focus {
        background-color: #fcd535;
    }

    .main-navigation ul li a,
    article,
    aside,
    details,
    figcaption,
    figure,
    footer,
    header,
    main,
    nav,
    section {
        text-align: center;
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

    .container_2:hover img {
        opacity: 0.3;
    }

    .container_2:hover .middle {
        opacity: 1;
    }

    button.active {
        background-color: #fcd535;
        padding: 16px 20px 16px 20px;
        border-radius: 7px;
    }

    p {

        font-family: "Libre Franklin", Sans-serif;
        font-weight: 400;
        font-size: 1.1rem;
        line-height: 30px;

    }

    .kort {
        font-size: 0.9rem;
    }

    @media (min-width: 490px) {

        .kort {


            font-size: 1.1rem;


        }
    }


    @media (min-width: 800px) {

        #podcastcontainer {
            margin: 0;
            padding: 60px;


        }


        /*---------------grid i desktop----------------*/

        #podcastcontainer {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-auto-flow: dense;
            grid-gap: 40px;
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
                <div class="middle">
                    <p class="kort"></p>
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

        <?php
			/**
			 * lalita_before_main_content hook.
			 *
			 */
			do_action( 'lalita_before_main_content' );

			while ( have_posts() ) : the_post();

				get_template_part( 'content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || '0' != get_comments_number() ) : ?>

        <div class="comments-area">
            <?php comments_template(); ?>
        </div>

        <?php endif;

			endwhile;

			/**
			 * lalita_after_main_content hook.
			 *
			 */
			do_action( 'lalita_after_main_content' );
			?>


        <nav id="filtrering">
        </nav>


        <section id="podcastcontainer"></section>



    </main><!-- #main -->

    <script>
        let podcasts;
        let categories;
        let filterPodcast = "alle";

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

        function opretknapper() {
            categories.forEach(cat => {
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-podcast="${cat.id}">${cat.name}</button>`
            })

            addEventListenerToButtons();
        }


        function addEventListenerToButtons() {
            document.querySelectorAll("#filtrering button").forEach(elm => {
                elm.addEventListener("click", filtrering);

            })

        }

        function filtrering() {
            filterPodcast = this.dataset.podcast;
            console.log(filterPodcast);
            visPodcasts();
            this.classList.add("active");

            document.querySelectorAll("#filtrering button").forEach(elm => {
                elm.classList.remove("active")
            });

            filterPodcast = this.dataset.podcast;
            console.log(filterPodcast);

            this.classList.add("active");
            visPodcasts();
        }


        function visPodcasts() {
            let temp = document.querySelector("template");
            let container = document.querySelector("#podcastcontainer");
            container.innerHTML = "";
            podcasts.forEach(podcast => {
                if (filterPodcast == "alle" || podcast.categories.includes(parseInt(filterPodcast))) {
                    let klon = temp.cloneNode(true).content;
                    klon.querySelector("h3").textContent = podcast.title.rendered;
                    klon.querySelector("img").src = podcast.billede.guid;
                    klon.querySelector(".antal").textContent = podcast.antal;
                    klon.querySelector(".kort").textContent = podcast.kort;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = podcast.link;
                    })
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
