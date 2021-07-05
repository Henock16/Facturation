
function mssg(lang,id,param){

    var typdem=["d'absence réglementaire","d'absence non réglementaire","de congé","d'acompte sur salaire","d'avance sur salaire","de prêt","de mission"];
    var bug="\nVeuillez contacter l'administrateur.";
    var cnx="\nVeuillez verifier l'état de votre connexion internet.";
    var mssg="";
 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(id==0)
        mssg=[1,"Impossible de charger la liste des agents :\n" + bug,""];
    else if(id==1)
        mssg=[1,"Erreur lors du chargement de la liste des agents :\n" + cnx,""];
    else if(id==2)
        mssg=[0,"Erreur lors du chargement de la question :\n" + cnx,""];
    else if(id==3)
        mssg=[1,"Impossible de charger la question :\n" + bug,""];
    else if(id==4)
        mssg=[0,"Ce numéro matricule n'existe pas dans l'application.",""];
    else if(id==5)
        mssg=[0,"Erreur lors de l'envoi de vos informations personnelles:\n" + cnx,""];
    else if(id==6)
        mssg=[1,"Impossible d'envoyer vos informations personnelles :\n"+bug,""];
    else if(id==7)
        mssg=[0,"Au moins "+((param==0)?"un de vos numéros de téléphone":"une de vos adresses électroniques")+" n'est pas valide!",""];
    else if(id==8)
        mssg=[2,"Vos informations ont été prises en compte !",""];
    else if(id==9)
        mssg=[0,'Il n\'y a pas de '+((param==2)?"destinataire à qui soumettre une suggestion":((param==1)?"type de prêt":"motifs d'absence"))+"."+bug,""];
    else if(id==10)
        mssg=[1,"Erreur lors du chargement des "+((param==2)?"destinataires":((param==1)?"types de prêt":"motifs d'absence"))+" :\n" + cnx,""];
    else if(id==11)
        mssg=[1,"Le statut de la demande a été déjà modifié par un autre utilisateur.\nLa demande est \""+statusname(lang,-param).toLowerCase()+"\".\nL'opération ne peut donc pas être effectuée.\n Veuillez actualiser la page pour vous en assurer.",""];
    else if(id==12)
        mssg=[0,"Veuillez sélectionner "+((param==0)?"un motif":((param==1)?"un intérimaire":((param==2)?"un type de prêt":((param==3)?"un moyen de transport":((param==4)?"un destinataire":"")))))+".",""];
    else if(id==13)
        mssg=[0,"Veuillez s'il vous plaît sélectionner la date de "+((param==0)?"départ":((param==1)?"reprise":((param==2)?"début":((param==3)?"fin":"")+" de l'évènement")))+".",""];
    else if(id==14)
        mssg=[0,"Le document justificatif est obligatoire.",""];
    else if(id==15)
        mssg=[2,"Votre "+((param==0)?"suggestion":"demande "+typdem[param-1])+" a été prise en compte"+((param==0)?"":". Vous pouvez à tout moment suivre l'évolution de son traitement dans le menu \"SUIVI\".")+".",""];
    else if(id==16)
        mssg=[2,"Votre demande "+typdem[param-1]+" a été modifiiée avec succès !",""];
    else if(id==17)
        mssg=[1,"Vous avez déjà une demande "+typdem[param-1]+" en cours de traitement dont vous pouvez consulter l'état dans le menu \"SUIVI\"",""];
    else if(id==18)
        mssg=[0,"Vous n'êtes rattachés à aucun service:"+bug,""];
    else if(id==19)
        mssg=[1,"Votre demande ne peut être soumise pour l'une des raisons suivantes:\n 1.Aucun chéminement de validation de ce type de demande n'est associé à votre poste \n 2.Il n'y a pas d'agent affecté au service où la demande doit être transmise \n 3.Le service auquel la demande doit être transmise est inexistant \n "+bug,""];
    else if(id==20)
        mssg=[0,"Votre date"+((param==1)?" et heure":"")+" de départ est déjà dépassée.",""];
    else if(id==21)
        mssg=[0,"Votre date"+((param==1)?" et heure":"")+" de départ n'est pas avant votre date"+((param==1)?" et heure":"")+" de reprise.",""];
    else if(id==22)
        mssg=[1,"Impossible d'envoyer votre demande :\n"+bug,""];
    else if(id==23)
        mssg=[1,"Erreur lors de l'envoi de la demande :\n" + cnx,""];
    else if(id==24)
        mssg=[1,'La pièce jointe n\'a pas pu être envoyée :'+bug,""];
    else if(id==25)
        mssg=[1,"Erreur lors de l'envoi de la pièce jointe :\n" + cnx,""];
    else if(id==26)
        mssg=[0,"La date et heure de départ est obligatoire.",""];
    else if(id==27)
        mssg=[0,((param==0)?"La date et heure de retour est obligatoire.":"Veuiller saisir "+((param==1)?"l'objet":"le message")+" de votre suggestion."),""];
    else if(id==28)
        mssg=[0,"Veuillez s'il vous plaît saisir l"+((param==0)?"e motif":((param==1)?"'objet":((param==2)?"e pays":((param==3)?"a ville":""))+" de la mission"))+".",""];
    else if(id==29)
        mssg=[0,'Fichier trop volumineux (Pas plus de 4 Mo).',""];
    else if(id==30)
        mssg=[0,'Extension de fichier non supportée.\n Les extensions supportées sont : "jpg","jpeg","png","pdf","txt","rtf","doc","docx","xls","xlsx".',""];
    else if(id==31)
        mssg=[1,"Vous n'avez pas d'intérimaire car vous n'êtes rattachés a aucun service:\n"+bug,""];
    else if(id==32)
        mssg=[1,"Vous n'avez pas d'intérimaire:\n"+bug,""];
    else if(id==33)
        mssg=[1,"Erreur lors du chargement de la liste des intérimaires :\n" + cnx,""];
    else if(id==34)
        mssg=[0,"Votre période d'absence coïncide avec une absence de l'intérimaire qui va du "+param+".",""];
    else if(id==35)
        mssg=[0,"Veuillez s'il vous plaît saisir le montant"+((param==1)?" des perdiems":((param==2)?"du remboursement à destination":""))+".",""];
    else if(id==36)
        mssg=[0,"Le montant minimum est de 10.000 FCFA.",""];
    else if(id==37)
        mssg=[0,"Votre date de début est déjà dépassée.",""];
    else if(id==38)
        mssg=[0,"Votre date de début est après votre date de fin.",""];
    else if(id==39)
        mssg=[0,"Votre date de départ est après votre date de début.",""];
    else if(id==40)
        mssg=[0,"Votre date de fin est après votre date de retour.",""];
    else if(id==41)
        mssg=[0,"Veuillez s'il vous plaît saisir l"+((param==0)?"e type de chauffeur":((param==1)?"e type":((param==2)?"a puissance":""))+" du véhicule")+".",""];
    else if(id==42)
        mssg=[0,"Veuillez s'il vous plaît saisir le "+((param==0)?"nom":((param==1)?"contact":""))+" de l'organisme tiers.",""];
    else if(id==43)
        mssg=[1,"Impossible de charger la liste des agents car le statut de la dérogation de l'agent a été changé.",""];
    else if(id==44)
        mssg=[1,"Impossible de changer le statut de la dérogation de l'agent :\n" + bug,""];
    else if(id==45)
        mssg=[1,"Erreur lors du changement du statut de la dérogation de l'agent :\n" + cnx,""];
    else if(id==46)
        mssg=[1,"Erreur lors du chargement des détails de la demande:\n" + cnx,""];
    else if(id==47)
        mssg=[1,"Erreur lors du chargement de la liste des demandes :\n" + cnx,""];
    else if(id==48)
        mssg=[1,"Impossible de charger les informations sur le demandeur :\n"+bug,""];
    else if(id==49)
        mssg=[1,"Erreur lors du chargement des informations sur le demandeur :\n" + cnx,""];
    else if(id==50)
        mssg=[1,"Erreur lors du traitement de la requête :\n" + cnx,""];
    else if(id==51)
        mssg=[0,(param==0)?"Aucune demande ne correspond à cette recherche.":param,""];
    else if(id==52)
        mssg=[0,"Votre matricule et/ou votre mot de passe est erroné !",""];
    else if(id==53)
        mssg=[0,"Votre compte utilisateur est désactivé !",""];
    else if(id==54)
        mssg=[0,"Votre compte est en cours d'utilisation !\n Veuillez patienter 05 minutes puis réessayer.",""];
    else if(id==55)
        mssg=[1,"Un problème a rendu votre tentative de connexion impossible:" + bug,""];
    else if(id==56)
        mssg=[1,"Une erreur est survenue lors de la connexion à l'application: \n" + cnx,""];
    else if(id==57)
        mssg=[0,"Vos mots de passe ne sont pas identiques !",""];
    else if(id==58)
        mssg=[0,"Votre mot de passe doit "+((param==0)?"contenir au moins 5 caractères !":((param==1)?"être différent du mot de passe par défaut !":"être différent de votre numéro matricule")),""];
    else if(id==59)
        mssg=[2,"Votre nouveau mot de passe a été pris en compte !",""];
    else if(id==60)
        mssg=[1,"Un problème est survenu lors du changement du mot de passe :\n" + bug,""];
    else if(id==61)
        mssg=[1,"Une erreur est survenue lors du changement du mot de passe :\n" + cnx,""];
    else if(id==62)
        mssg=[0,"Votre période d'absence coïncide avec une de vos absences qui va du "+param+".",""];
    else if(id==63)
        mssg=[0,"Votre période d'absence coïncide avec un intérim que vous assurez qui va du "+param+".",""];
    else if(id==64)
        mssg=[0,"La période d'absence coïncide avec une absence de l'intérimaire qui va du "+param+".",""];
    else if(id==65)
        mssg=[0,"La période d'absence coïncide avec une absence du demandeur nqui va du "+param+".",""];
    else if(id==66)
        mssg=[0,"La période d'absence coïncide avec un intérim assuré par le demandeur qui va du "+param+".",""];
    else if(id==67)
        mssg=[1,"Impossible de traiter la requête sur la demande :\n"+bug,""];
    else if(id==68)
        mssg=[0,"Le montant maximum est de "+param+" FCFA.",""];
    else if(id==69)
        mssg=[1,"Erreur lors du chargement de la liste des suggestions :\n" + cnx,""];
    else if(id==70)
        mssg=[1,"Erreur lors de la soumission de la suggestion :\n" + cnx,""];
    else if(id==71)
        mssg=[1,"Erreur lors du chargement du contenu de la suggestion :\n" + cnx,""];
    else if(id==72)
        mssg=[1,"Le service auquel la demande doit etre transmise est inexistant :" +bug,""];
    else if(id==73)
        mssg=[1,"Il n'y a pas d'agent au service ou la demande doit etre transmise :\n" +bug,""];
    else if(id==74)
        mssg=[1,"Aucun chéminement de validation n'est associé à ce poste et ce type de demande :\n" +bug,""];
    else if(id==75)
        mssg=[0,"Veuillez s'il vous plaît saisir la durée minimum de remboursement.",""];
    else if(id==76)
        mssg=[0,"La durée minimum de remboursement est de 1 mois.",""];
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    if(id==0)
        mssg=[1,"Impossible de charger la liste des agents :\n" + bug,""];
    else if(id==1)
        mssg=[1,"Erreur lors du chargement de la liste des agents :\n" + cnx,""];
    else if(id==2)
        mssg=[0,"Votre nom d'utilisateur et/ou votre mot de passe sont/est erroné !",""];
    else if(id==3)
        mssg=[0,"Votre compte utilisateur est désactivé !",""];
    else if(id==4)
        mssg=[0,"Votre compte est en cours d'utilisation !\n Veuillez patienter au moins "+param+" minutes puis réessayer...",""];
    else if(id==5)
        mssg=[1,"Un problème a rendu votre tentative de connexion impossible:" + bug,""];
    else if(id==6)
        mssg=[1,"Une erreur est survenue lors de la connexion à l'application: \n" + cnx,""];
    else if(id==7)
        mssg=[1,"Erreur lors du chargement de la liste des réservations :\n" +param+"\n "+ cnx,""];
    else if(id==8)
        mssg=[1,"Il n'y a pas d'inspecteur disponible",""];
    else if(id==9)
        mssg=[1,"Erreur lors du chargement de la fenêtre :\n" + cnx,""];
    else if(id==10)
        mssg=[1,"Un problême est survenu lors de l'exécution de l'action : \n " +param+"\n "+ cnx,""];
    else if(id==11)
        mssg=[0,"Erreur détectée lors de l'exécution de l'action: \n " +param+"\n "+ bug,""];
    else if(id==12)
        mssg=[1,param,""];
    else if(id==13)
        mssg=[0,"Impossible de charger la liste des affectations :\n"+param+"\n "+ bug,""];
    else if(id==14)
        mssg=[1,"Impossible de charger la liste :\n"+param+"\n "+ cnx,""];
    else if(id==15)
        mssg=[0,"Impossible de charger la liste :\n"+param+"\n "+ bug,""];
    else if(id==16)
        mssg=[0,param,""];
    else if(id==17)
        mssg=[2,param,""];
    else if(id==18)
        mssg=[1,"Erreur lors du chargement de la liste des inspecteurs :\n" +param+"\n "+ bug,""];
    else if(id==19)
        mssg=[1,"Erreur lors du chargement de la liste des inspecteurs :\n" +param+"\n "+ cnx,""];
    else if(id==20)
        mssg=[0,"Vos mots de passe ne sont pas identiques !",""];
    else if(id==21)
        mssg=[0,"Votre mot de passe doit "+((param==0)?"contenir au moins 5 caractères !":((param==1)?"être différent du mot de passe par défaut !":"être différent de votre nom d'utilisateur")),""];
    else if(id==22)
        mssg=[0,"Au moins "+((param==0)?"un de vos numéros de téléphone":"une de vos adresses électroniques")+" n'est pas valide!",""];
    else if(id==23)
        mssg=[2,"Vos informations ont été prises en compte !",""];
    else if(id==24)
        mssg=[0,"Erreur lors de l'envoi de vos informations personnelles:\n" + cnx,""];
    else if(id==25)
        mssg=[1,"Impossible d'envoyer vos informations personnelles :\n"+bug,""];
    else if(id==26)
        mssg=[2,"Votre nouveau mot de passe a été pris en compte !",""];
    else if(id==27)
        mssg=[1,"Un problème est survenu lors du changement du mot de passe :\n" + bug,""];
    else if(id==28)
        mssg=[1,"Une erreur est survenue lors du changement du mot de passe :\n" + cnx,""];


    var title=["Attention !","Désolé !","Félicitations !"];
    var image=["failure.jpg","caution.png","yes.png"];
    var color=["red","orange","green"];
    $('#alert-message-title').html(title[mssg[0]]);
    $('#alert-message-title').css("color",color[mssg[0]]);
    $('#alert-image').prop('src','images/'+image[mssg[0]]);
    $('#alert-message').html(mssg[lang].replace("\n","<br>"),"");
    $('#modal-message').modal("show","");
}
