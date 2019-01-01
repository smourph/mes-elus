#!/bin/bash

SCRIPTDIR=$(dirname "$0")
FOLDER=$(dirname "$SCRIPTDIR")'/var/ApiData'
EXTENSION='json'

URLS[0]='http://data.assemblee-nationale.fr/static/openData/repository/15/amo/deputes_actifs_mandats_actifs_organes/AMO10_deputes_actifs_mandats_actifs_organes_XV.'$EXTENSION'.zip'
DATANAME[0]='deputes_actifs'

for (( i=0; i<=$((${#URLS[*]}-1)); i++ ))
do
	# Si l'URL existe
	if curl --output /dev/null --silent --fail -r 0-0 "${URLS[$i]}"; then
		DATA_FOLDERS=$FOLDER/${DATANAME[$i]}
		# Création du dossier si il n'existe pas
		mkdir -p $DATA_FOLDERS

		# Si un fichier existe déjà, on le backup
		count=`ls -1 $DATA_FOLDERS/*.$EXTENSION 2>/dev/null | wc -l`
		if [ $count != 0 ]; then
			FILENAME=`ls -1 $DATA_FOLDERS/*.$EXTENSION 2>/dev/null`
			# Ajout de la date du fichier en extension
			DATE_BACKUP=$(date +%Y%m%d --date=@`stat -c %Y $FILENAME`)
			tar cvfz $FILENAME.$DATE_BACKUP.tar.gz $FILENAME

			# Déplacement du backup vers le dossier archives/
			mkdir -p $FOLDER/archives/
			mv $DATA_FOLDERS/*.tar.gz $FOLDER/archives/
		fi

		# Récupération du fichier
		wget ${URLS[$i]} -O $DATA_FOLDERS/tmp.zip ; unzip -od $DATA_FOLDERS $DATA_FOLDERS/tmp.zip ; rm $DATA_FOLDERS/tmp.zip
		echo "[ok] Data imported"
	else
		echo "[error] Wrong URL : ${URLS[$i]}"
	fi
done

if [[ -e $FOLDER/archives ]]; then
	# Ne conserver que les 60 dernières archives
	ls -t $FOLDER/archives/ | sed -e '1,20d' | xargs -d '\n' rm -f
fi