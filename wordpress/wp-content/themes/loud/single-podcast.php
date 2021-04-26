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
    #main {
        margin: 60px;
    }

    h3,
    p {
        color: white
    }

    button.knap {
        background-color: #232323;
        color: white;
    }

    button.knap:hover {
        background-color: #DB083A;
        color: white;

    }

    img {
        border-radius: 17px;
    }

    h3 {
        font-size: 2.5rem;

    }

    p {
        font-size: 1rem;
        line-height: 30px;
    }

    @media (min-width: 850px) {

        /*---------------grid på desktop--------------------*/

        #pods {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 25px;
        }

    }

</style>

<div id="primary" <?php lalita_content_class();?>>
    <main id="main" <?php lalita_main_class(); ?>>


        <div class="knap">
            <button class="knap">Tilbage til menu</button>
        </div>

        <article id="pods">

            <img src="" alt="" class="billede">
            <div class="container">

                <h3 class="navn">
                </h3>
                <p class="beskrivelse"></p>
                <p class="spotify"></p>
            </div>

        </article>


        <section id="episoder">
            <template>
                <article>
                    <img src="" alt="">
                    <div>
                        <h2></h2>
                        <p class="beskrivelse"></p>
                        <a href="">læs mere</a>
                    </div>
                </article>
            </template>
        </section>
    </main><!-- #main -->



    <script>
        let podcast;
        let episoder;
        let aktuelpodcast = <?php echo get_the_ID()?>;

        const dbURL = "http://indiamillward.dk/radioloud/wp-json/wp/v2/podcast/" + aktuelpodcast;

        const episodeUrl = "http://indiamillward.dk/radioloud/wp-json/wp/v2/episode?per_page=100";

        const container = document.querySelector("#episoder");


        async function getJson() {
            const data = await fetch(dbURL);
            podcast = await data.json();

            const data2 = await fetch(episodeUrl);
            episoder = await data2.json();
            console.log("episoder: ", episoder)

            visPodcasts();
            visEpisoder();
        }


        function visPodcasts() {

            document.querySelector("h3").textContent = podcast.title.rendered;
            document.querySelector(".billede").src = podcast.billede.guid
            document.querySelector(".beskrivelse").textContent = podcast.beskrivelse;
            document.querySelector(".spotify").textContent = podcast.spotify;
            //eventlistener på tilbageknappen
            document.querySelector("button").addEventListener("click", tilbageTilPodcasts);
        }


        function visEpisoder() {
            console.log("visEpisoder")
            let temp = document.querySelector("template");
            episoder.forEach(episode => {
                console.log("loop id :", aktuelpodcast);
                if (episode.horer_til_podcast == aktuelpodcast) {
                    console.log("loop kører id:", aktuelpodcast);
                    let klon = temp.cloneNode(true).content;
                    klon.querySelector("h2").textContent = episode.title.rendered;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = episode.link;
                    })
                    klon.querySelector("a").href = episode.link;
                    console.log("episode", episode.link);
                    container.appendChild(klon);

                }
            })
        }


        //eventhandler på knappen
        function tilbageTilPodcasts() {
            //history = webapi for at komme baglængs, hvis vi kalder back kommer vi et hak tilbage i browserhistorien (dermed tilbage til 01-kald.html)
            history.back();
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
