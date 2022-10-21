function mssg(lang, id, param) {

    var typdem = ["d'absence réglementaire", "d'absence non réglementaire", "de congé", "d'acompte sur salaire", "d'avance sur salaire", "de prêt", "de mission"];
    var bug = "\nVeuillez contacter l'administrateur.";
    var cnx = "\nVeuillez verifier l'état de votre connexion internet.";
    var mssg = "";


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (id == 0)
        mssg = [1, "Impossible de charger la liste des agents :\n" + bug, ""];
    else if (id == 1)
        mssg = [1, "Erreur lors du chargement de la liste des agents :\n" + cnx, ""];
    else if (id == 2)
        mssg = [0, "Votre nom d'utilisateur et/ou votre mot de passe sont/est erroné !", ""];
    else if (id == 3)
        mssg = [0, "Votre compte utilisateur est désactivé !", ""];
    else if (id == 4)
        mssg = [0, "Votre compte est en cours d'utilisation !\n Veuillez patienter au moins " + param + " minutes puis réessayer...", ""];
    else if (id == 5) {
        // mssg=[1,"Un problème a rendu votre tentative de connexion impossible:" + bug,""];
        mssg = [2, "La facture existe et a été envoyer avec succès"];
    } else if (id == 6)
        mssg = [1, "Une erreur est survenue lors de la connexion à l'application: \n" + cnx, ""];
    else if (id == 7)
        mssg = [1, "Erreur lors du chargement de la liste des ponts :\n" + param + "\n " + cnx, ""];
    else if (id == 8)
        mssg = [1, "Un problême est survenu lors du chargement de la fenêtre ", ""];
    else if (id == 9)
        mssg = [1, "Erreur lors du chargement de la fenêtre :\n" + cnx, ""];
    else if (id == 10)
        mssg = [1, "Un problême est survenu lors de l'exécution de l'action : \n " + param + "\n " + cnx, ""];
    else if (id == 11)
        mssg = [0, "Erreur détectée lors de l'exécution de l'action: \n " + param + "\n " + bug, ""];
    else if (id == 12)
        mssg = [1, param, ""];
    else if (id == 13)
        mssg = [0, "Impossible de charger la liste des affectations :\n" + param + "\n " + bug, ""];
    else if (id == 14)
        mssg = [1, "Impossible de charger la liste :\n" + param + "\n " + cnx, ""];
    else if (id == 15)
        mssg = [0, "Impossible de charger la liste :\n" + param + "\n " + bug, ""];
    else if (id == 16)
        mssg = [0, param, ""];
    else if (id == 17)
        mssg = [2, param, ""];
    else if (id == 18)
        mssg = [1, "Erreur lors du chargement de la liste des inspecteurs :\n" + param + "\n " + bug, ""];
    else if (id == 19)
        mssg = [1, "Erreur lors du chargement de la liste des inspecteurs :\n" + param + "\n " + cnx, ""];
    else if (id == 20)
        mssg = [0, "Vos mots de passe ne sont pas identiques !", ""];
    else if (id == 21)
        mssg = [0, "Votre mot de passe doit " + ((param == 0) ? "contenir au moins 5 caractères !" : ((param == 1) ? "être différent du mot de passe par défaut !" : "être différent de votre nom d'utilisateur")), ""];
    else if (id == 22)
        mssg = [0, ((param == 0) ? "Votre numéro de téléphone" : "Au moins une de vos adresses électroniques") + " n'est pas valide!", ""];
    else if (id == 23)
        mssg = [2, "Vos informations ont été prises en compte !", ""];
    else if (id == 24)
        mssg = [0, "Erreur lors de l'envoi de vos informations personnelles:\n" + cnx, ""];
    else if (id == 25)
        mssg = [1, "Impossible d'envoyer vos informations personnelles :\n" + bug, ""];
    else if (id == 26)
        mssg = [2, "Votre nouveau mot de passe a été pris en compte !", ""];
    else if (id == 27)
        mssg = [1, "Un problème est survenu lors du changement du mot de passe :\n" + bug, ""];
    else if (id == 28)
        mssg = [1, "Une erreur est survenue lors du changement du mot de passe :\n" + cnx, ""];
    else if (id == 29)
        mssg = [1, "Les factures de ce mois n'ont pas encore été générées pour les produits sélectionnés\n", ""];
    else if (id == 30)
        mssg = [2, "L'exclusion du chargeur a été pris en compte\n", ""];
    else if (id == 31)
        mssg = [2, "Le chargeur a été retirer de la liste des exclus\n", ""];
    else if (id == 32)
        mssg = [2, "Le chargeur a été ajouter a la liste des exclus\n", ""];
    else if (id == 33)
        mssg = [1, "Veuillez sélectionner un chargeur dans la liste avant de valider\n", ""];
    else if (id == 34)
        mssg = [2, "Le numéro du compte client a été modifier avec succés\n", ""];
     else if (id == 35)
        mssg = [1, "La modfication n'a pas été validé \n", ""];


    var title = ["Attention !", "Désolé !", "Félicitations !"];
    var image = ["failure.jpg", "caution.png", "yes.png"];
    var color = ["red", "orange", "green"];
    $('#alert-message-title').html(title[mssg[0]]);
    $('#alert-message-title').css("color", color[mssg[0]]);
    $('#alert-image').prop('src', 'images/' + image[mssg[0]]);
    $('#alert-message').html(mssg[lang].replace("\n", "<br>"), "");
    $('#modal-message').modal("show", "");
}