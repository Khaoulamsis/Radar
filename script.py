
# Sortie dans console
import os
import re

def transformer_et_afficher(input_folder, file_name):
    input_file_path = os.path.join(input_folder, file_name)

    with open(input_file_path, 'r') as file:
        data_lines = file.readlines()

    # Filtrer les lignes
    nouvelles_lignes = [ligne.strip() for ligne in data_lines if len(ligne.strip()) > 5]

    # Transformer et afficher le résultat
    pattern = re.compile(r'(T16\s+|T15\s+|M02\s+|M01\s+|M05\s+|M03\s+|M04\s+)')
    for ligne in nouvelles_lignes:
        result = pattern.split(ligne)
        for i in range(1, len(result), 2):
            print(result[i] + result[i + 1].strip())

# Path
input_folder = './'
file_name = 'data.txt'

transformer_et_afficher(input_folder, file_name)

