import os
import ssl
import sys
import certifi
import urllib3
import requests

from hashlib import md5
from urllib.request import urlretrieve
from requests.exceptions import ConnectionError

urllib3.disable_warnings()

url_update = 'https://kcilk.company/update/update.php'
url_md5hash = 'https://kcilk.company/update/md5hash.php'
folder_update = 'https://kcilk.company/update/bot/'

#===============================================================================
#ГЕНЕРАТОР MD5 ХЕША
def get_md5(fname):
    m = md5()
    with open(fname, 'rb') as fp:
        for chunk in fp:
            m.update(chunk)
    return m.hexdigest()
#===============================================================================
ssl._create_default_https_context = ssl._create_unverified_context

#авторизация
print("\nАвторизация на сервере обновлений")
if os.path.exists('key.txt'):
    user_key = open('key.txt').read().split('=')[0]
    if len(user_key) > 0:
        #запрос авторизации
        print('Ключ авторизации:', user_key)
        try:
            chech_url = url_md5hash+'?key='+user_key
            auth_check = requests.get(chech_url, verify=False).text
            print('Ответ сервера:', auth_check)
        except Exception:
            print("\nERROR: Ошибка при запросе авторизации!\n")
            sys.exit(1)
        if auth_check != 'ok':
            print("\nERROR: Ошибка авторизации! Проверьте ключ в файле key.txt\n")
            sys.exit(1)
    else:
        print("\nERROR: Отсутствует ключ в файле key.txt\nОбновление невозможно!\n")
        sys.exit(1)
else:
    print("\nERROR: Отсутствует файл с ключем авторизации key.txt\nОбновление невозможно!\n")
    sys.exit(1)

#sys.exit(1)

print("\nПолучаем файл со списком актуальных файлов\n")
#удаляем старый файл update.txt
if os.path.exists('update.txt'):
    print(' - файл update.txt найден, удаляем')
    os.remove('update.txt')
#загружаем новый файл update.txt
try:
    print(' - загружаем актуальный файл update.txt')
    destination = 'update.txt'
    url_update = url_update+'?key='+user_key
    urlretrieve(url_update, destination)
except Exception:
    print("\nERROR: Ошибка получения файла update.txt\n")
    sys.exit(1)
#перебираем списко файлов
if os.path.exists('update.txt'):#проверяем наличие файла
    print("\nРабота с файлами из списка update.txt\n")
    file = open('update.txt').read().split('\n')#разбиваем на строки
    for line in file:#перебираем строки
        if len(line) > 0:#если длина строки больше нуля
            print(' - ', line)
            if os.path.exists(line):
                print('    файл найден')
            else:
                print('    файл отсутствует, загружаем')
                #загружаем файл с удаленного сервеа
                try:
                    url_load = folder_update+line
                    urlretrieve(url_load, line)
                    print('    файл успешно загружен')
                except Exception:
                    print("\nERROR: Ошибка получения файла", line, "\n")
                    sys.exit(1)
            try:
                chech_url = url_md5hash+'?md5file='+line+'&key='+user_key
                get_check = requests.get(chech_url, verify=False).text
            except Exception:
                print("\nERROR: Ошибка при запросе MD5 хеша для файла ", line, "\n")
                sys.exit(1)

            #проверяем хеш
            if get_check == 'ERROR':
                print("\nERROR: Ошибка авторизации при запросе хеш-данных!\n")
                sys.exit(1)
            if get_check != get_md5(line):
                print('    содержимое локального и удаленного файлов не идентично, обновляем', line)
                os.remove(line)#удаляем
                try:
                    print('    загружаем актуальный файл', line)
                    url_load = folder_update+line
                    urlretrieve(url_load, line)
                except Exception:
                    print("\nERROR: Ошибка получения файла update.txt\n")
                    sys.exit(1)
                print('    контрольная проерка после загрузки')
                try:
                    chech_url = url_md5hash+'?md5file='+line+'&key='+user_key
                    get_check = requests.get(chech_url, verify=False).text
                except Exception:
                    print("\nERROR: [2] Ошибка при запросе MD5 хеша для файла ", line, "\n")
                    sys.exit(1)
                if get_check != get_md5(line):
                    print("\nERROR: Ошибка MD5 хеша для файла ", line, "Требуется повторный запуск обновления!\n")
                    sys.exit(1)
                else:
                    print('    OK')
            else:
                print('    хеш совпадает')
                print('    OK')


        print("\n")
else:
    print("\nERROR: Ошибка открытия локального файла update.txt\n")
    sys.exit(1)
