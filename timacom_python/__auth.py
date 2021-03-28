import requests
import urllib3
import json

from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import TimeoutException
from requests.exceptions import ConnectionError

urllib3.disable_warnings()

def check_auth(domain_key, user_key):
    status = '0'
    msg = ' ... ERROR: Неизвестная ошибка'
    token_app = '0'
    data_cookies_base64 = ''
    print('=> Авторизация на управляющем сервере...')
    try:
        chech_url = domain_key+'/api/check_auth/?user_key='+user_key
        print('AUTH:', chech_url)
        get_data = requests.get(chech_url, verify=False)
        #print('ОТВЕТ:', get_data.text)
        try:
            get_data.encoding = get_data.apparent_encoding # исправляем кодировку
            json_data = get_data.text # результат в переменную
            #print(json_data)
            data_data = json.loads(json_data) # в json данные
            status = data_data["status"]
            msg = data_data["msg"]
            token_app = data_data["token_app"]
            data_cookies_base64 = data_data["cookies"]
            #print('Статус:', status, 'Ответ сервера:', msg)
            #print('cookies_base_64:', data_cookies_base64)
        except NoSuchElementException:
            status = '9'
            msg = ' ... ERROR: Управляющий сервер вернул некорректный ответ | NoSuchElementException'
        except TimeoutException:
            status = '9'
            msg = ' ... ERROR: Управляющий сервер вернул некорректный ответ | NoSuchElementException'
    except ConnectionError as e:
        status = '9'
        msg = ' ... ERROR: Ошибка соединения с сервером | ConnectionError'
    except NoSuchElementException:
        status = '9'
        msg = ' ... ERROR: Управляющий сервер не отвечает | NoSuchElementException'
    except TimeoutException:
        status = '9'
        msg = ' ... ERROR: Управляющий сервер не отвечает | TimeoutException'
    return {'status': status, 'msg': msg, 'token_app': token_app, 'data_cookies': data_cookies_base64}
