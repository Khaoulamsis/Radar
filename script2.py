
# Sortie dans fichier avec entrée statique
import os
import re

def transform_store(input_folder, file_name, output_file_name):
    input_file_path = os.path.join(input_folder, file_name)
    output_file_path = os.path.join(input_folder, output_file_name)

    with open(input_file_path, 'r') as file:
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

# Path
input_folder = './'
file_name = 'data.txt'
output_file_name = 'resultat.txt'

transform_store(input_folder, file_name, output_file_name)
