<?php
/**
 * The Template for displaying all single WPKoi events.
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




    @media (min-width: 850px) {

        /*---------------grid på desktop--------------------*/

        #grid {
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
            <div id="grid">

                <img src="" alt="" class="billede">
                <div class="container">

                    <h3 class="navn">
                    </h3>
                    <p class="beskrivelse"></p>
                </div>
            </div>

        </article>


    </main><!-- #main -->

    <script>
        let episode;
        let aktuelpodcast = <?php echo get_the_ID()?>;

        const dbURL = "http://indiamillward.dk/radioloud/wp-json/wp/v2/episode/" + aktuelpodcast;

        async function getJson() {
            const data = await fetch(dbURL);
            episode = await data.json();
            visEpisode();
        }


        function visEpisode() {
            document.querySelector("h3").textContent = episode.title.rendered;
            document.querySelector(".billede").src = episode.billede.guid
            document.querySelector(".beskrivelse").textContent = episode.beskrivelse;
            //eventlistener på tilbageknappen
            document.querySelector("button").addEventListener("click", tilbageTilPodcasts);
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
