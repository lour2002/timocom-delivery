import requests
import json

from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import TimeoutException

def get_setting(number_tab, domain_key, user_key):
    try:
        check_url = str(domain_key)+'/get_task/?num='+str(number_tab)
        print('get data:', check_url)
        check_json_data = requests.get(check_url, verify=False)
        check_json_data.encoding = check_json_data.apparent_encoding # исправляем кодировку
        json_data = check_json_data.text # результат в переменную
        try:
            data_data = json.loads(json_data) # в json данные
            id_task = data_data["id_task"]
            status_all_task = data_data["status_all_task"]
            version_task = data_data["version_task"]
            status_job = data_data["status_job"]
            status_get = '1'
        except Exception as e:
            print('... ERROR: Сервер не отдал данных.', json_data)
            status_get = '2'
    except NoSuchElementException:
        print('... ERROR: Не получили настройки! | NoSuchElementException')
        status_get = '0'
    except TimeoutException:
        print('... ERROR: Не получили настройки! | TimeoutException')
        status_get = '0'
    # возвращаем
    data = dict();
    if status_get == '1':
        data['id_task']=id_task
        data['status_get']=status_get
        data['status_all_task']=status_all_task
        data['version_task']=version_task
        data['status_job']=status_job

        data['json_data']=json_data
        return(data)
    else:
        data['status_get']=status_get
        return(data)
