
#Entrée et sortie dynamique
import os
import re
import shutil

def transform_store(input_folder, file_name, output_folder, archive_folder):
    input_file_path = os.path.join(input_folder, file_name)

    # Créer le chemin du fichier de sortie dans le dossier spécifié
    output_file_name = file_name
    output_file_path = os.path.join(output_folder, output_file_name)

    # Renommer le fichier d'entrée en ajoutant "traite-" au début
    old_file_name = 'traite-' + file_name
    old_file_path = os.path.join(input_folder, old_file_name)
    os.rename(input_file_path, old_file_path)

    with open(old_file_path, 'r') as file:
        data_lines = file.readlines()

    # Filtrer les lignes
    nouvelles_lignes = [ligne.strip() for ligne in data_lines if len(ligne.strip()) > 5]

    # Transformer et stocker le résultat dans un fichier
    pattern = re.compile(r'(T16\s+|T15\s+|M02\s+|M01\s+|M05\s+|M03\s+|M04\s+|OU01\s+|T99\s+)')
    with open(output_file_path, 'w') as output_file:
        for ligne in nouvelles_lignes:
            result = pattern.split(ligne)
            for i in range(1, len(result), 2):
                output_file.write(result[i] + result[i + 1].strip() + '\n')

    # Déplacer le fichier de sortie dans le dossier spécifié
    shutil.move(output_file_path, os.path.join(output_folder, output_file_name))

    # Déplacer le fichier d'entrée dans le dossier d'archivage
    shutil.move(old_file_path, os.path.join(archive_folder, old_file_name))

# Chemin d'entrée
input_folder = './'

# Chemin du dossier de sortie
output_folder = './output'

# Chemin du dossier d'archivage
archive_folder = './arch'

# Recherche du dernier fichier créé commençant par "FOM" (exemple)
latest_file = max((f for f in os.listdir(input_folder) if f.startswith('FOM')), key=os.path.getctime, default=None)

# Vérification si un fichier a été trouvé
if latest_file:
    print("Le dernier fichier créé commençant par FOM est :", latest_file)
    transform_store(input_folder, latest_file, output_folder, archive_folder)
else:
    print("Aucun fichier n'a été trouvé.")
