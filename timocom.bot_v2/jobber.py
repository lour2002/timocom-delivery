import base64
import json
import time
import sys
import os

from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import TimeoutException
from selenium.common.exceptions import InvalidArgumentException
from selenium.common.exceptions import ElementNotInteractableException
from selenium.common.exceptions import StaleElementReferenceException
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support import expected_conditions as EC
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

import __auth as auth
import __openservice as openservice
import __interface as interface
import __getsetting as getsetting
import __setting_from as setting_from
import __setting_to as setting_to
import __setting_freight as setting_freight
import __setting_date as setting_date
import __orders as orders

# получаем ключ
user_key = open('key.txt').read().split('=')[0]
domain_key = 'http://92.118.150.87'


#счетчик ревизий окон для проверки необходимости обновления
version_task_array = dict()
version_task_array[0] = 0
version_task_array[1] = 0
version_task_array[2] = 0
version_task_array[3] = 0
version_task_array[4] = 0

auth_data = auth.check_auth(domain_key, user_key)


if  auth_data['status'] == '1':#авторизация прошла
    print(auth_data['msg'])

    #проверка наличия директории
    if not os.path.isdir(user_key):
        print("Создаем директорию ", user_key, "для Chrome")
        os.makedirs(user_key)
    #открываем браузер
    print('=> Открываем браузер для работы с системой')
    cur_dir = os.path.abspath(os.curdir)

    print('=> Авторизация в системе сервиса')

    chrome_patch = cur_dir+'\\GoogleChromePortable\\GoogleChromePortable.exe'
    chromedriver_patch = cur_dir+'\\chromedriver.exe'
    user_data_dir = cur_dir+'\\'+user_key

    options = Options()
    options.binary_location = chrome_patch
    options.add_argument("--user-data-dir="+user_data_dir)
    options.add_argument("--no-sandbox")
    options.add_argument("--dns-prefetch-disable")
    options.add_argument("start-maximized")
    options.add_argument("--ignore-certificate-errors")
    options.add_argument("--disable-session-crashed-bubble")
    options.add_argument("--disable-popup-blocking")
    options.add_argument("--disable-setuid-sandbox")
    options.add_argument("--disable-gpu")
    options.add_argument("--remote-debugging-port=9222")

    try:
        #browser = webdriver.Chrome("chromedriver.exe", options=browser_options)
        browser = webdriver.Chrome(executable_path=chromedriver_patch, options=options)


        if auth_data['auth_mode'] == 'form':
            open_service = openservice.open_page_service_auth(browser)
        else:
            #проверка печенек
            get_cookies = auth_data['data_cookies']
            if len(get_cookies) < 10:
                print("\nВНИМАНИЕ! \nОтсутствуют данные COOKIES... \nВозможно это первый запуск?! \nУстановите плагин для получения данных в chrome и авторизайтесь на сервере Timocom.\n")
                time.sleep(10)
                sys.exit(1)

            #берем куки из запроса авторизации
            token_app = auth_data['token_app']
            data_cookies_64 = auth_data['data_cookies'] #кукисы в json завернутые в base64
            open_service = openservice.open_page_service(browser, data_cookies_64)

        #окрываем страницу сервиса
        if open_service['status_open'] == '1':
            print(open_service['msg_open'])
            #time.sleep(5)
            #interface.close_chat(browser)#закроем чат

            #Поиске старых настроек (табов) и закрытие
            #close_tab_search = interface.close_old_search_tab(browser)
            #time.sleep(60000)
            #Открываем необходимое число вкладок поискаs
            count_tabs = 5
            current_count_tabs = interface.add_new_search_tab(browser, count_tabs)
            if current_count_tabs == count_tabs:#если все вкладки открыты
                print(' ... Все вкладки открыты')
                time.sleep(2)
                interface.close_chat(browser)#закроем чат
                time.sleep(3)

                #понеслась
                number_tab = 0 #какую вкладку открываем
                status_run = 'go'
                while status_run != 'stop':

                    setting_tab = getsetting.get_setting(number_tab, domain_key, user_key)
                    status_get = setting_tab['status_get']
                    id_task = setting_tab['id_task']
                    if status_get == '1':
                        try:
                            #vihod - esli zastryali v kartochke
                            return_btn = browser.find_element_by_id('app:cnt:searchDetail:navBar:backToSearchBtn')
                            if return_btn.is_displayed():
                                return_btn.click()
                                print('Check open cart - OPEN -> return')
                                time.sleep(3)
                        except NoSuchElementException:
                            print('Check open cart - NO OPEN')
                        if setting_tab['status_all_task'] == '1':#общий статус - работаем
                            # Проверяем статус задачи - если 2 или 3, то работаем / иначе не выполняем ничего
                            if setting_tab['status_job'] == '2' or setting_tab['status_job'] == '3':
                                if setting_tab['status_job'] == '2':
                                    print(' ... задача в режиме IN TESTING')
                                if setting_tab['status_job'] == '3':
                                    print(' ... задача в режиме IS RUNNING')
                                open_job_tab_status = interface.open_job_tab(browser, number_tab)

                                #time.sleep(2)
                                interface.close_chat(browser)#закроем чат
                                time.sleep(2)
                                if open_job_tab_status == 1:
                                    # Проверяем, надо ли обновить настройки - первый раз всегда надо, а дальше от ревизии
                                    if version_task_array[number_tab] != setting_tab['version_task']:
                                        print(' => Необходимо обновление настроек вкладки')
                                        print(' ... обновляем')
                                        #reset
                                        browser.find_element_by_id('app:cnt:searchForm:resetFilterBtn').click()
                                        time.sleep(2)
                                        interface.new_offers_on(browser)
                                        #открыть настройки
                                        status_open_setting = interface.check_open_setting(browser, number_tab)
                                        set_set_from = setting_from.set_setting(browser, setting_tab['json_data'])
                                        print('Настройки FROM ->', set_set_from)
                                        set_set_to = setting_to.set_setting(browser, setting_tab['json_data'])
                                        print('Настройки TO ->', set_set_to)
                                        set_set_freight = setting_freight.set_setting(browser, setting_tab['json_data'])
                                        print('Настройки Selection of freight ->', set_set_freight)
                                        set_set_date = setting_date.set_setting(browser, setting_tab['json_data'])
                                        print('Настройки Date ->', set_set_date)


                                        #Применяем фильтр - app:cnt:searchForm:applySearchBtn
                                        browser.find_element_by_id('app:cnt:searchForm:applySearchBtn').click()

                                        #настройка завершена
                                        version_task_array[number_tab] = setting_tab['version_task'] # устанавливаем текущую, после настроек
                                        print(' => Настройки внесены и сохранены')
                                        time.sleep(5)
                                    else:
                                        print(' => Настройки без изменений, просто обновляем список')
                                        # Обновляем спискок
                                        browser.find_element_by_id('app:cnt:searchForm:searchBtn').click()
                                        time.sleep(5)

                                    print(' ... работаем по вкладке')

                                    get_order = orders.get_new_orders(browser, id_task, domain_key, number_tab, version_task_array[number_tab], user_key)

                                    time.sleep(3)
                                else:
                                    print('ERROR! Что-то пошло не так с переходом на нужную вкладку!')
                                    print('... останавливаем работу и запускаем все с самого начала!')
                                    status_run = 'stop'

                            else:
                                if setting_tab['status_job'] == '0':
                                    print(' ... задача в режиме NOT CONFIGURED')
                                if setting_tab['status_job'] == '1':
                                    print(' ... задача в режиме STOP')

                        if setting_tab['status_all_task'] == '0':#общий статус - СТОП
                            print('!!! Поступила команда остановки процесса. СТОП РАБОТА - общая пауза...')
                            #status_run = 'stop'
                            time.sleep(60)
                    else:
                        print(' ... ERROR: Проблема с получением настроек!')

                    print(' >>> NEXT TABS')
                    time.sleep(3)
                    number_tab = number_tab+1
                    if number_tab == 5:
                        number_tab = 0


            else:
                print(' ... ERROR: Проблема с созданием дополнительных вкладок поиска')
        else:
            print(open_service['msg_open'])

    except InvalidArgumentException:
        print(' ... ERROR: Уже открыто окно браузера, в котором работает скрипт! Закройте и повторите снова! | InvalidArgumentException')
        browser.close()
        browser.quit()


else:
    print('Ошибка авторизации!', auth_data['msg'])

browser.close()
browser.quit()
