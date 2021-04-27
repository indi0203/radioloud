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

    img {
        width: 100%;
    }

    h3,
    p,
    h2 {
        color: white
    }

    #pods h2 {
        text-align: center;
        padding-top: 50px;
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

    .center {
        position: relative;
        text-align: center;
        cursor: pointer;
    }

    .center img {
        opacity: 0.3;
    }

    .center:hover {
        margin-top: -5px;
    }

    .center h2 {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 1.8rem;

    }


    @media (min-width: 850px) {

        /*---------------grid på desktop--------------------*/

        #grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 25px;
        }

        #episoder {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-gap: 40px;

        }

    }

</style>

<div id="primary" <?php lalita_content_class();?>>
    <main id="main" <?php lalita_main_class(); ?>>


        <div class="knap">
            <button class="knap">Tilbage til podcasts</button>
        </div>

        <article id="pods">
            <div id="grid">

                <img src="" alt="" class="billede">
                <div class="container">

                    <h3 class="navn">
                    </h3>
                    <p class="beskrivelse"></p>
                    <p class="spotify"></p>
                </div>
            </div>

            <h2>Andre episoder fra:</h2>

        </article>


        <section id="episoder">
            <template>
                <article class="center">
                    <img src="" alt="">
                    <div>
                        <h2></h2>
                        <p class="beskrivelse"></p>
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
            document.querySelector("h2").innerHTML = `Andre podcasts fra ${podcast.title.rendered} `;
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
                    klon.querySelector("img").src = episode.billede.guid;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = episode.link;
                    })
                    console.log("episode", episode.link);
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = episode.link;
                    })
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
