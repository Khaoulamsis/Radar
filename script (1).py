import os
import re
import shutil
import logging
from zipfile import ZipFile
from datetime import datetime

log_file_name = "log.txt"
logging.basicConfig(filename=log_file_name, level=logging.INFO, format='%(asctime)s - %(message)s')

def transform_store(input_folder, file_name, output_folder, archive_folder):
    input_file_path = os.path.join(input_folder, file_name)

    middle_number = re.search(r'_(\d+)_', file_name)
    if middle_number:
        middle_number = middle_number.group(1)
        new_middle_number = 'D'
        current_datetime = datetime.now().strftime("%Y%m%d%H%M%S")
        output_file_name = re.sub(rf"_{middle_number}_MTP\d+", f"_{new_middle_number}_MTP{current_datetime}", file_name)
    else:
        output_file_name = file_name

    output_file_path = os.path.join(output_folder, output_file_name)
    old_file_name =  file_name
    old_file_path = os.path.join(input_folder, old_file_name)
    os.rename(input_file_path, old_file_path)

    with open(old_file_path, 'r') as file:
        data_lines = file.readlines()

    nouvelles_lignes = [ligne for ligne in data_lines]

    pattern_str = '(' + '|'.join(delimiter + r'\s+[a-zA-Z0-9]{1}' for delimiter in map(re.escape, delimiters)) + ')'
    pattern = re.compile(pattern_str)

    with open(output_file_path, 'w') as output_file:
        for ligne in nouvelles_lignes:
            result = pattern.split(ligne)
            for i in range(1, len(result), 2):
                # Ajouter la vérification et le retour à la ligne avant le motif WARNING
                warning_pattern = re.compile(r'WARNING\s+[a-zA-Z0-9]+\s+\d+\s+\d+')
                if warning_pattern.search(result[i] + result[i + 1].strip()):
                    result[i+1] = result[i+1].replace("WARNING", '\nWARNING')
                    output_file.write(result[i] + result[i + 1].strip() + '\n')
                else:
                    output_file.write(result[i] + result[i + 1].strip() + '\n')

    zip_file_name = output_file_name + '.zip'
    zip_file_path = os.path.join(output_folder, zip_file_name)
    with ZipFile(zip_file_path, 'w') as zip_file:
        zip_file.write(output_file_path, os.path.basename(output_file_path))

    shutil.move(old_file_path, os.path.join(archive_folder, old_file_name))
    logging.info(f"Traitement réussi pour {file_name}. Résultats écrits dans {output_folder}/{zip_file_name}.")


# Chemin du dossier d'entrée
input_folder = './'

# Chemin du dossier de sortie
output_folder = './output'

# Chemin du dossier d'archivage
archive_folder = './arch'

delimiters = [
    'A01', 'A02', 'A03', 'A05', 'A06', 'A07', 'A08',
    'C01', 'C02', 'CC01', 'EC01', 'ERROR', 'EUDO01', 'EUDO02',
    'EUDO03', 'FE01', 'FE02', 'FE03', 'FE04', 'FE06', 'FE07',
    'FE08', 'FE09', 'FE10', 'FE11', 'FE12', 'FE13', 'FE14',
    'FE15', 'FE16', 'FE17', 'FE18', 'KB01', 'LP1', 'LP2',
    'LPM1', 'LPS01', 'LPS02', 'M01', 'M02', 'M03', 'M04',
    'M05', 'OU01', 'OU02', 'OU03', 'OU04', 'OU05', 'OU06',
    'OU07', 'OU08', 'OU09', 'OU10', 'SYS', 'T01', 'T02',
    'T03', 'T04', 'T05', 'T06', 'T07', 'T08', 'T09', 'T10',
    'T11', 'T12', 'T13', 'T14', 'T15', 'T16', 'T17', 'T18',
    'T19', 'T20', 'T21', 'T22', 'T23', 'T24', 'T25', 'T26',
    'T98', 'T99', 'TAR01', 'TC1', 'TC2', 'X01',
    'XS01', 'XS02', 'ZBS001', 'ZBS002', 'ZBS003', 'ZBS004',
    'ZBS005', 'ZCBABO', 'ZCBFID', 'ZCBOFF', 'ZCLI1', 'ZCLI10',
    'ZCLI12', 'ZCLI2', 'ZCLI3', 'ZCLI4', 'ZCLI5', 'ZCLI6',
    'ZCLI7', 'ZCLI8', 'ZCLI9', 'ZDEC1', 'ZFID001', 'ZFID002',
    'ZFID003', 'ZFID004', 'ZFID005', 'ZFID006', 'ZFID007',
    'ZFID008', 'ZFID009', 'ZFID999', 'ZKPI_21', 'ZKPI_22',
    'ZKPI_31', 'ZKPI_32', 'ZKPI_33', 'ZKPI_34', 'ZTC1', 'ZTL1',
    'ZTL10', 'ZTL2', 'ZTL3', 'ZTL4', 'ZTL5', 'ZTL6', 'ZTL7',
    'ZTL8', 'ZTR1'
]

# Recherche du dernier fichier créé commençant par "PER_RY2_ELK_YRFR" (exemple)
latest_file = max((f for f in os.listdir(input_folder) if f.startswith('PER_RY2_ELK_YR')), key=os.path.getctime, default=None)

# Vérification si un fichier a été trouvé
if latest_file:
    transform_store(input_folder, latest_file, output_folder, archive_folder)
else:
    logging.info("Aucun fichier n'a été trouvé.")
