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
    #primary {

        padding-top: 140px;
        padding-left: 30px;
        padding-right: 30px;
        background-color: #fdf4ce;
        padding-bottom: 50px;
        margin-top: -90px;
    }

    img {
        width: 100%;
    }

    h3.navn {
        padding-top: 31px;
    }


    h3,
    h2 {
        color: #232323;
        font-family: "Roboto", Sans-serif;
    }

    p {
        font-family: "Libre Franklin", Sans-serif;
        color: #232323;
        font-weight: 400;
    }



    #pods h2 {
        text-align: center;
        padding-top: 50px;
        font-weight: 400;
    }

    button.knap {
        background-color: #fcde61;
        color: white;
        border-radius: 7px;
        font-family: "Roboto", Sans-serif;
        font-size: 20px;
        font-weight: 500;
        padding: 16px 20px 16px 20px;
    }

    button.knap:hover {
        transform: scale(1.1);
    }

    .knap {
        padding-bottom: 30px;
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

    h4 {
        color: #232323;
        text-align: center;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .stream a:hover {
        margin-top: -5px;
    }

    @media (max-width: 950px) {

        .logoa,
        .logop,
        .logos,
        .logog {
            width: 50%;
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding-bottom: 27px;


        }

    }




    @media (min-width: 850px) {

        /*---------------grid på desktop--------------------*/

        #grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 25px;
        }

        .stream {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            grid-gap: 35px;
        }

        #primary {

            padding-left: 60px;
            padding-right: 60px;
        }


    }

</style>

<div id="primary" <?php lalita_content_class();?>>
    <main id="main" <?php lalita_main_class(); ?>>


        <div class="knap">
            <button class="knap">Tilbage</button>
        </div>

        <article id="pods">
            <div id="grid">

                <img src="" alt="" class="billede">
                <div class="container">

                    <h3 class="navn">
                    </h3>

                    <p class="længde"></p>
                    <p class="beskrivelse"></p>

                    <h4>Lyt med her:</h4>
                    <div class="stream">

                        <img src="" alt="" class="logos">
                        <img src="" alt="" class="logoa">
                        <img src="" alt="" class="logog">
                        <img src="" alt="" class="logop">

                    </div>
                </div>


            </div>

        </article>




    </main><!-- #main -->

    <script>
        let episode;
        let flere;
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


            document.querySelector(".længde").innerHTML = `<b>Varighed: </b> ${episode.lngde} `


            //Logo

            document.querySelector(".logos").src = episode.spotify_logo.guid;

            document.querySelector(".logoa").src = episode.apple_logo.guid;

            document.querySelector(".logog").src = episode.google_logo.guid;

            document.querySelector(".logop").src = episode.podimo_logo.guid;

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
