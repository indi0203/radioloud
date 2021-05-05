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
    #primary {
        margin: 0;
        padding-top: 100px;
        padding-left: 30px;
        padding-right: 30px;
        background-color: #FCDE61;
        padding-bottom: 50px;
    }

    img {
        width: 100%;
    }


    h3,
    h2 {
        color: #232323;
        font-family: "Roboto", Sans-serif;
    }

    h3.navn {
        padding-top: 31px;
    }

    h4 {
        color: #232323;
        font-family: "Roboto", Sans-serif;
        font-size: 1.5rem;
        font-weight: 400;
    }

    body {
        font-family: "Roboto", Sans-serif;
    }

    p {
        font-family: "Libre Franklin", Sans-serif;
        color: #232323;
        font-weight: 400;
    }

    #pods h2 {
        text-align: center;
        padding-top: 65px;
        font-weight: 400;
    }

    button.knap {
        background-color: #232323;
        color: white;
        border-radius: 7px;
        font-family: "Roboto", Sans-serif;
        font-size: 20px;
        font-weight: 500;
        padding: 16px 20px 16px 20px;
    }

    button.knap:hover {
        background-color: #232323;
        color: white;
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

    .center {
        position: relative;
        text-align: center;
        cursor: pointer;
    }

    .center img {
        opacity: 0.5;
        background-color: #232323;
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


    h4 {
        color: #232323;
        text-align: center;
        padding-top: 40px;
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





    @media (min-width: 950px) {

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

        .stream {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            grid-gap: 35px;
        }

        #primary {
            margin: 0;
            padding-top: 100px;
            padding-left: 60px;
            padding-right: 60px;
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

                    <h4>Lyt med her:</h4>
                    <div class="stream">


                        <a href="" class="spotify">
                            <img src="" alt="" class="logos">
                        </a>
                        <a href="" class="apple">
                            <img src="" alt="" class="logoa">
                        </a>
                        <a href="" class="google">
                            <img src="" alt="" class="logog">
                        </a>
                        <a href="" class="podimo">
                            <img src="" alt="" class="logop">
                        </a>
                    </div>


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
        //definerer podcast og episoder som lokale variabler
        let podcast;
        let episoder;

        //aktuelpodcast henter ID'et (som er et tal) fra den valgte podcasts slug
        let aktuelpodcast = <?php echo get_the_ID()?>;

        //definerer konstant som peget på den relevante podcast, altså URL'en til alle podcasts + det ID som den enkle podcast har.
        const dbURL = "http://indiamillward.dk/radioloud/wp-json/wp/v2/podcast/" + aktuelpodcast;

        //henter alle episoder ned
        const episodeUrl = "http://indiamillward.dk/radioloud/wp-json/wp/v2/episode?per_page=100";

        //episoderne bliver puttet ind i en container
        const container = document.querySelector("#episoder");


        //funktion der henter alle Json dataen, både for podcast og episoder.
        async function getJson() {
            //podcasts bliver hentet
            const data = await fetch(dbURL);
            podcast = await data.json();

            //episoder bliver hentet
            const data2 = await fetch(episodeUrl);
            episoder = await data2.json();
            console.log("episoder: ", episoder)

            //kalder funktionerne for at vise podcasts og episoder
            visPodcasts();
            visEpisoder();
        }

        //kalder funktionen for at få den enkelte podcasts data ind.
        function visPodcasts() {
            document.querySelector("h3").textContent = podcast.title.rendered;
            document.querySelector(".billede").src = podcast.billede.guid;
            document.querySelector(".beskrivelse").textContent = podcast.beskrivelse;
            document.querySelector("h2").innerHTML = `Andre podcasts fra ${podcast.title.rendered} `;

            //Logo
            document.querySelector(".logos").src = podcast.spotify_logo.guid;
            document.querySelector(".spotify").href = podcast.spotify;

            document.querySelector(".logoa").src = podcast.apple_logo.guid;
            document.querySelector(".apple").href = podcast.apple;

            document.querySelector(".logog").src = podcast.google_logo.guid;
            document.querySelector(".google").href = podcast.google;

            document.querySelector(".logop").src = podcast.podimo_logo.guid;
            document.querySelector(".podimo").href = podcast.podimo;

            //eventlistener på tilbageknappen
            document.querySelector("button").addEventListener("click", tilbageTilPodcasts);
        }


        //kalder funktionen for at få vist episoderne på siden.
        function visEpisoder() {
            console.log("visEpisoder")
            let temp = document.querySelector("template");
            episoder.forEach(episode => {
                console.log("loop id :", aktuelpodcast);
                //filtrer det sådan at den kun viser de episoder som hører til den aktuelle podcast, så det vil sige at hvis ID'et til "hører til podcast" er det samme som ID'et fra den valgte podcast så bliver resten af dataen vist, og ellers springer den det andet over.
                if (episode.horer_til_podcast == aktuelpodcast) {
                    console.log("loop kører id:", aktuelpodcast);
                    let klon = temp.cloneNode(true).content;
                    //sætter titlen ind fra min skabelon i HTML'en.
                    klon.querySelector("h2").textContent = episode.title.rendered;
                    klon.querySelector("img").src = episode.billede.guid;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = episode.link;
                    })
                    console.log("episode", episode.link);
                    //når man klikker på den enkelte episode kommer man ind på dens singleview
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = episode.link;
                    })

                    //kloner html template og lægger indholdet fra data ind i de relevante html elementer og tilføjer indhold.
                    container.appendChild(klon);

                }
            })
        }


        //eventhandler på knappen
        function tilbageTilPodcasts() {
            //history = webapi for at komme baglængs, hvis vi kalder back kommer vi et hak tilbage i browserhistorien
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
