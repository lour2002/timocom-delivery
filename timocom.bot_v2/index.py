import os
import sys
import requests
import json
import time
import subprocess

import __auth as auth

# получаем ключ
user_key = open('key.txt').read().split('=')[0]
domain_key = 'https://kiri-company.pp.ua'

updater = 'python update.py' # команда запуска рабочего скрипта
cmd = 'python jobber.py' # команда запуска рабочего скрипта

jobStatus = 1
while jobStatus != 0:
    #Проверка авторизации
    print('Домен:', domain_key)
    print('Авторизация с ключем: ', user_key)
    auth_data = auth.check_auth(domain_key, user_key)
    if  auth_data['status'] == '1':#авторизация прошла
        #проверка обновлений
        # PIPE = subprocess.PIPE
        # p = subprocess.Popen(updater, shell=True, stdin=PIPE, stderr=subprocess.STDOUT, close_fds=True, bufsize=1, universal_newlines=True)
        # p.communicate()
        # rc = p.returncode
        # if rc != 0:
        #     print("\nОШИБКА ОБНОВЛЕНИЯ ПРОГРАММЫ!\nДальнейшая работа недопустима.\nПовторная попытка обновления через 60 секунд...")
        #     time.sleep(60)
        #     continue
        # else:
            response = os.system("taskkill /F /IM chrome.exe")
            print(auth_data['msg'])
            print('=> Запускаем скрипт')
            PIPE = subprocess.PIPE
            p = subprocess.Popen(cmd, shell=True, stdin=PIPE, stderr=subprocess.STDOUT, close_fds=True, bufsize=1, universal_newlines=True)
            p.communicate()
    else:
        print(auth_data['msg'])
        print('Пауза в работе срипта - 30 секунд')
        time.sleep(30)

    print('!!! ОСТАНОВКА: Рабочий скрипты был остановлен! Пауза 30 секунд до следующего запуска...')
    time.sleep(30)
