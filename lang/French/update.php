<?php

// Language definitions used in db_update.php

$lang_update = array(

'Update'			     =>	'Mise à jour de FluxBB',
'Update message'		     =>	'Votre base de données FluxBB est dépassée et doit être mise à niveau afin de poursuivre. Si vous êtes l\'administrateur de ces forums, veuillez suivre les instructions ci-desssous afin d\'achever la mise à niveau.',
'Note'				     =>	'Remarque :',
'Members message'		     =>	'Cette procédure n\'est destinée qu\'aux administrateurs des forums. Si vous êtes un membre ce n\'est pas la peine de vous préoccuper de cela - les forums seront très rapidement fonctionnels !',
'Administrator only'		     =>	'Cette étape ne concerne que l\'administrateur des forums !',
'Database password info'	     =>	'Pour lancer la mise à jour de la base de données veuillez indiquer le mot de passe de base de données avec lequel FluxBB a été installé. Si vous ne vous en souvenez plus, il est stocké dans le fichier \'config.php\'.',
'Database password note'	     =>	'Si vous utilisez SQLite (et donc n\'avez défini aucun mot de passe), veuillez utiliser le nom du fichier de base de données à la place. Cela doit correspondre exactement au nom de base de données indiqué dans votre fichier de configuration.',
'Database password'		     =>	'Mot de passe de base de données',
'Next'				     =>	'Suivante',

'You are running error'		     =>	'Vous utilez la version %2$s de %1$s. FluxBB %3$s nécessite au moins %1$s %4$s pour fonctionner correctement. Vous devez mettre à niveau votre installation avant de poursuivre.',
'Version mismatch error'	     =>	'Version non correspondante. La base de données \'%s\' ne semble pas utiliser un schéma de base de données FluxBB pris en charge par ce script de mise à jour.',
'Invalid file error'		     =>	'Nom de base de données invalide. Lorsque vous utilisez SQLite le nom de la base de données indiqué doit être exactement identique à celui de votre \'%s\'',
'Invalid password error'	     =>	'Mot de passe de base de données invalide. Pour mettre à niveau FluxBB vous devez indiquer votre mot de passe de base de données, il doit être exactement identique à celui de votre \'%s\'',
'No password error'		     =>	'Aucun mot de passe de base de données fourni',
'Script runs error'		     =>	'Il semblerait que le script de mise à jour ait déjà été lancé par une autre personne. Si cela ne s\'averrait pas être vrai, veuillez supprimer manuellement le fichier \'%s\' et essayer à nouveau',
'No update error'		     =>	'Votre forum a déjà atteint le niveau de mis à jour le plus élevé pour ce script',

'Intro 1'			     =>	'Ce script va se charger de mettre votre base de données à jour. La procédure de mise à jour pourra prendre quelques secondes à plusieures heures, cette durée dépendant de la vitesse du serveur et de la taille de la base de données. N\'oubliez pas de faire une sauvegarde de la base de données avant de poursuivre.',
'Intro 2'			     =>	'Avez-vous lu les instructions de mise à jour dans la documentation ? Si non, allez voir.',
'No charset conversion'		     =>	'<strong>IMPORTANT !</strong> FluxBB a détecté que cet environnement PHP ne prend pas en charge les mécanismes d\'encodage nécessaires pour effectuer une conversion UTF-8 à partir de jeux de caractères autres que ISO-8859-1. Cela signifie que si le jeu de caractères actuel n\'est pas ISO-8859-1, FluxBB ne pourra pas convertir votre base de données du forum en UTF-8 et vous devrez le faire manuellement. Des informations concernant la conversion manuelle peuvent être trouvées dans les instructions de mise à jour.',
'Enable conversion'		     =>	'<strong>Activer la conversion :</strong> si activé, ce script de mise à jour procèdera, après avoir fait les modifications structurelles nécessaires à la base de données, à la conversion de tout le texte dans la base de données de l\'actuel jeu de caractères vers UTF-8. Cette conversion est nécessaire si vous mettez à niveau une version 1.2.',
'Current character set'		     =>	'<strong>Jeu de caractère actuel :</strong> Si la langue principale de votre forum est l\'anglais, vous pouvez laisser cela à la valeur par défaut. En revanche, si votre forum utilise une autre langue, vous devrez indiquer le jeu de caractères du paquetage de la langue principale utilisé par le forum. <em>Si cette donnée est fausse, cela pourra corrompre votre base de données, donc n\'essayez pas de deviner !</em> Remarque : ceci est nécessaire même si votre ancienne base de données est en UTF-8.',
'Charset conversion'		     =>	'Conversion de jeu de caractères',
'Enable conversion label'	     =>	'<strong>Activer la conversion</strong> (effectuer la conversion du jeu de caractères de la base de données).',
'Current character set label'	     =>	'Jeu de caractères actuel',
'Current character set info'	     =>	'Accepter la valeur par défaut pour des forums en anglais sinon, le jeu de caractères du paquetage de la langue principale.',
'Start update'			     =>	'Démarrer la mise à jour',
'Error converting users'	     =>	'Erreur lors de la conversion de noms d\'utilisateurs',
'Error info 1'			     =>	'Une erreur est survenue lors de la conversion de certains noms d\'utilisateurs. Cela peut arriver lors d\'une conversion à partir de FluxBB v1.2 si plusieurs utilisateurs se sont inscrits en indiquant des noms très similaires, par exemple « bob » et « böb ».',
'Error info 2'			     =>	'Ci-dessous une liste d\'utilisateurs dont la conversion du nom a échoué. Veuillez choisir un nouveau nom pour chaque utilisateur. Les utilisateurs dont le nom aura été modifié seront automatiquement avertis par l\'envoi d\'un e-mail.',
'New username'			     =>	'Nouvel utilisateur',
'Required'			     =>	'(Obligatoire)',
'Correct errors'		     =>	'Les erreurs suivantes doivent être corrigées :',
'Rename users'			     =>	'Renommer les utilisateurs',
'Successfully updated'		     =>	'Votre base de données a été mise à jour avec succès. Vous devrez à présent %s.',
'go to index'			     =>	'vous rendre à la page d\'accueil des forums',

'Unable to lock error'		     =>	'Impossible de déverrouiller pour mise à jour. Veuillez vérifier que PHP puisse modifier le répertoire \'%s\' et qu\'actuellement personne d\'autre n\'a lancé le script de mise à jour.',

'Converting'			     =>	'Conversion de %s …',
'Converting item'		     =>	'Conversion de %1$s %2$s …',
'Preparsing item'		     =>	'Analyse préliminaire de %1$s %2$s …',
'Rebuilding index item'		     =>	'Reconstruction de l\'index pour %1$s %2$s',

'ban'				     =>	'bannissement',
'categories'			     =>	'catégories',
'censor words'			     =>	'mots censurés',
'configuration'			     =>	'configuration',
'forums'			     =>	'forums',
'groups'			     =>	'groupes',
'post'				     =>	'message',
'ranks'				     =>	'rangs',
'report'			     =>	'signalement',
'topic'				     =>	'discussion',
'user'				     =>	'utilisateur',
'signature'			     =>	'signature',

'Username too short error'	     =>	'Les noms d\'utilisateurs doivent comporter au moins 2 caractères. Veuillez choisir un autre nom d\'utilisateur (plus long).',
'Username too long error'	     =>	'Les noms d\'utilisateurs ne doivent pas comporter plus de 25 caractères. Veuillez choisir un autre nom d\'utilisateur (plus court).',
'Username Guest reserved error'	     =>	'Le nom d\'utilisateur « guest » est réservé. Veuillez choisir un autre nom.',
'Username IP format error'	     =>	'Les noms d\'utilisateurs ne doivent pas ressembler à une adresse IP. Veuillez choisir un autre nom d\'utilisateur.',
'Username bad characters error'	     =>	'Les noms d\'utilisateurs ne doivent pas comporter tous les caractères \', " et [ ou ] en même temps. Veuillez choisir un autre nom d\'utilisateur.',
'Username BBCode error'		     =>	'Les noms d\'utilisateurs ne doivent pas comporter de balises de formatage de texte (BBCode) utilisés par le forum. Veuillez choisir un autre nom d\'utilisateur.',
'Username duplicate error'	     =>	'Quelqu\'un a déjà utilisé le nom d\'utilisateur « %s ». Le nom d\'utilisateur que vous avez indiqué est trop semblable. Le nom doit comporter au moins un caractère alphanumérique (a-z ou 0-9) différent. Veuillez choisir un autre nom d\'utilisateur.',

'JavaScript disabled'		     =>	'JavaScript semble être désactivé. %s.',
'Click here to continue'	     =>	'Cliquez ici pour continuer',
'Required field'                     => 'est un champ à remplir obligatoirement dans ce formulaire.'

);
