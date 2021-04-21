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
    img {
        width: 100%;
    }

    @media (min-width: 800px) {

        /*---------------grid i desktop----------------*/

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
        }
    }

</style>


<template>
    <article class="grid">
        <div class="container">
            <img src="" alt="" class="billede">

            <h3 class="navn">
            </h3>
            <p class="antal"></p>
        </div>

    </article>
</template>

<div id="primary" <?php lalita_content_class();?>>
    <main id="main" <?php lalita_main_class(); ?>>


        <section id="podcastcontainer"></section>

    </main><!-- #main -->

    <script>
        let podcasts;
        const dbUrl = "http://indiamillward.dk/radioloud/wp-json/wp/v2/podcast?per_page=100";

        async function getJson() {
            const data = await fetch(dbUrl);
            podcasts = await data.json();
            console.log(podcasts);
            visPodcasts();
        }

        function visPodcasts() {
            let temp = document.querySelector("template");
            let container = document.querySelector("#podcastcontainer");
            podcasts.forEach(podcast => {
                let klon = temp.cloneNode(true).content;
                klon.querySelector("h3").textContent = podcast.title.rendered;
                klon.querySelector("img").src = podcast.billede.guid;
                klon.querySelector(".antal").textContent = podcast.antal;
                container.appendChild(klon);

            })

        }


        //        function visPodcasts() {
        //
        // let temp = document.querySelector("template");
        // let container = document.querySelector("#liste");
        // podcasts.forEach(podcast => {
        // let klon = temp.cloneNode(true).content;
        // klon.querySelector("h3").textContent = podcast.title.rendered;
        // klon.querySelector("img").src = podcast.billede.guid
        // container.appendChild(klon);
        // })

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
