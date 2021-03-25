import os
import sys
import requests
import json
import time
import subprocess

import __auth as auth

# получаем ключ
user_key = open('key.txt').read().split('=')[0]
domain_key = 'http://92.118.150.87'

updater = 'python update.py' # команда запуска срабочего скрипта
cmd = 'python jobber.py' # команда запуска срабочего скрипта

#Проверка авторизации
print('Домен:', domain_key)
print('Авторизация с ключем: ', user_key)
auth_data = auth.check_auth(domain_key, user_key)
if  auth_data['status'] == '1':#авторизация прошла
    #проверка обновлений
    PIPE = subprocess.PIPE
    p = subprocess.Popen(updater, shell=True, stdin=PIPE, stderr=subprocess.STDOUT, close_fds=True, bufsize=1, universal_newlines=True)
    p.communicate()
    rc = p.returncode
    if rc != 0:
        print("\nОШИБКА ОБНОВЛЕНИЯ ПРОГРАММЫ!\nДальнейшая работа недопустима.\nПовторная попытка обновления через 60 секунд...\n")
        sys.exit(1)
    else:
        response = os.system("pip install -r requirements.txt")
else:
    print(auth_data['msg'])
    print("\nОшибка авторизации... Необходимо проверить ключ!\n")
    sys.exit(1)

print("\nКомплит...\n")
time.sleep(30)
