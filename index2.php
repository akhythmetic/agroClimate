<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Impact du Changement Climatique sur l'Agriculture</title>
   <link rel="stylesheet" href="style2.css">
   <link rel="icon" href="photos/logosite.png" type="image/png">
</head>
<body>
   <header>
    <form id="search-form">
       <input type="text" id="searchInput" placeholder="Search..." aria-label="Barre de recherche">
    </form>
       <h1>L'IMPACT DU CHANGEMENT CLIMATIQUE SUR L'AGRICULTURE</h1>
   </header>

   <section class="main-content">
    <p class="intro-text">"Analyse des effets des variations climatiques sur les cultures et les économies agricoles mondiales."</p>

    <div class="aligned-section">
        <div class="buttons-section">
            <a class="button">Pourquoi c'est important ?</a>
            <a class="button" href = "illustrations.html">Visualisations</a>
            <a class="button" href = "ourteam.html">Assistance</a>
        </div>

        <p class="main-paragraph">
            "Le changement climatique modifie profondément les conditions agricoles à travers le monde. C'est pourquoi l'impact est significatif sur la production agricole, la biodiversité et l'économie."
        </p>

        <img src="photos/histpage1.png" alt="Nouvelle image" class="additional-image">
    </div>


        <div class="aligned-section"> 
           <img src="photos/climate-change.jpeg" alt="Effets du changement climatique sur l'agriculture" class="content-image">
           <p class="main-paragraph">
            "À travers des statistiques descriptives et des visualisations interactives, nous montrons comment l'augmentation des températures et les événements climatiques extrêmes ont perturbé la production agricole dans plusieurs régions du globe.
            Ces graphiques illustrent clairement les liens entre changement climatique et rendement agricole, soulignant les menaces que cela pose pour la sécurité alimentaire."
        </p>
        </div>


        <div class="aligned-section"> 
            
            <p class="main-paragraph">
                "Ce projet explore comment le changement climatique affecte les cultures agricoles à travers le monde de 1990 à 2024, en fournissant des recommandations pour une agriculture plus durable."
         </p>
         <img src="photos/graphe-page1.png" alt="Effets du changement climatique sur l'agriculture" class="actualites2-image">
         </div>


           <p class="conclusion-text">
               "Analyse des Impacts du Changement Climatique sur l'Agriculture : Comprendre les Tendances de 1990 à 2024 pour Informer des Stratégies d'Adaptation et Garantir la Sécurité Alimentaire à Long Terme"
           </p>

           <p class="final-paragraph">
               "Avec une population mondiale en constante croissance, la demande alimentaire ne cesse d'augmenter. Pourtant, les événements climatiques extrêmes réduisent les rendements agricoles et fragilisent les terres cultivables. Comprendre l'impact de ces changements climatiques est crucial pour développer des stratégies d'adaptation et assurer un avenir alimentaire durable."
           </p>
       </div>
   </section>

   <aside class="sidebar top-sidebar">
        <a href="#">Why trust us</a>
        <a href="ourteam.html">Our team</a>
        <a href="faq.html">FAQ</a>
    </aside>

    <aside class="sidebar bottom-sidebar">
        <a href="connexion.php">Se connecter</a>
        <a href="inscription.php">S'inscrire</a>
    </aside>



   <footer>
       <p>© 2024 - Tous droits réservés</p>
   </footer>

   <script>
    // Script JavaScript pour gérer la recherche
    document.getElementById('search-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page

        // Récupère la valeur de l'entrée utilisateur
        const query = document.getElementById('searchInput').value.trim().toLowerCase();

        // page d'actualité
        if (query === "actualité" || query === "actualités" || query === "actualites"|| query === "actualite") {
            window.location.href = "actualites.html"; 
        } 

        //page d'equipe
        if (query === "équipe" || query === "equipe" || query === "team" || query === "our team") {
            window.location.href = "ourteam.html"; 
        } 
        //page d'analyses
        if (query === "analyse" || query === "analyses") {
            window.location.href = "analyse.html"; 
        } 

        //page d'illustrations
        if (query === "illustrations" || query === "illustration" || query === "visualisations" || query === "visualisation") {
            window.location.href = "illustrations.html";
        } 

        //page de connexion
        if (query === "connexion" || query === "client" || query === "inscription") {
            window.location.href = "connexion.php"; 
        } 

        //page d'interviews
        if (query === "interview" || query === "interviews") {
            window.location.href = "interviews.html"; 
        } else {
            alert("Aucune page correspondante trouvée !"); 
        }

        
    });

</script>

</body>
</html>