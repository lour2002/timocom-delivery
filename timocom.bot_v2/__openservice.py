import json
import base64
import time

from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.common.exceptions import NoSuchElementException
from selenium.common.exceptions import TimeoutException
from selenium.common.exceptions import InvalidArgumentException
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.chrome.options import Options

site_link = 'https://my.timocom.com/app/tco/freight/search/'
sign_open_service = 'uit-aph-notification' #ID элемента, который есть на странице, чтобы подтвердить, что мы в нужном месте

def open_page_service(browser, data_cookies_64):
    status_open = '0'
    msg_open = ' ... ERROR: Ошибка при открытии страницы сервиса'
    data_cookies = base64.b64decode(data_cookies_64).decode('utf-8') #декодируем кукисы в читабельный вид
    data_data_json = json.loads(data_cookies) # переводим строку с кукисами в json данные
    try:
        browser.get(site_link) #открываем страницу без куков
        #Проверяем, что открылась нужная страница
        try:
            login_form = browser.find_element_by_id(sign_open_service)#ищем подтверждение корректности открытой страницы
            msg_open = ' ... Страница сервиса открыта и доступна к работе!'
            status_open = '1'
        except NoSuchElementException:
            #не нашли признака, добавляем печеньки
            print(' ... Внедряем данные для авторизации в системе')
            for c in data_data_json:
                browser.add_cookie(c) #добавляем куки
                print(c)
            #открываем страницу после установки куков
            print('=> Open [2]')
            browser.get(site_link)
            time.sleep(5)
        except TimeoutException:
            msg_open = ' ... ERROR: [1] Не нашли подтверждения корректности страницы! | TimeoutException'
            status_open = '9'

        #Проверяем, что открылась нужная страница
        try:
            #browser.get(site_link)
            login_form = browser.find_element_by_id(id_open_service)#ищем подтверждение корректности открытой страницы
            msg_open = ' ... Страница сервиса открыта и доступна к работе!'
            status_open = '1'
        except NoSuchElementException:
            msg_open = ' ... ERROR: [2] Не нашли подтверждения корректности страницы! | NoSuchElementException'
            status_open = '9'
        except TimeoutException:
            msg_open = ' ... ERROR: Не нашли подтверждения корректности страницы! | TimeoutException'
            status_open = '9'
        #time.speep(15)
    except TimeoutException:
        msg_open = ' ... ERROR: Ошибка при открытии страницы! | TimeoutException'
        status_open = '9'

    #удаляем нафиг меню
    #/html/body/div[3]
    if status_open == '1':
        element = browser.find_element_by_xpath('/html/body/div[3]')
        browser.execute_script("""
        var element = arguments[0];
        element.parentNode.removeChild(element);
        """, element)

    return {'status_open': status_open, 'msg_open': msg_open}

def open_page_service_auth(browser):
    status_open = '0'
    msg_open = ' ... ERROR: Ошибка при открытии страницы сервиса'

    auth_link = 'https://my.timocom.com/app/weblogin/'
    auth_open_service = 'trust-web-login' #ID элемента, который есть на странице, чтобы подтвердить, что мы в нужном месте

    try:
        browser.get(site_link) #открываем страницу
        #Проверяем, что открылась нужная страница
        try:
            login_form = browser.find_element(By.ID, sign_open_service) # ищем подтверждение корректности открытой страницы
            msg_open = ' ... Страница сервиса открыта и доступна к работе!'
            status_open = '1'
        except NoSuchElementException:
            #не нашли признака, открываем страницу авторизации
            print(' ... Открываем страницу авторизации')
            browser.get(auth_link)

            time.sleep(2)

            try:
                print(' ... ... Заполняем email')
                inputElementEmail = browser.find_element(By.CSS_SELECTOR, '#trust-web-login form [data-testid="email"]')
                inputElementEmail.send_keys('dispo4.express.logistics@gmail.com')

                time.sleep(2)

                print(' ... ... Заполняем password')
                inputElementPassword = browser.find_element(By.CSS_SELECTOR, '#trust-web-login form [data-testid="password"]')
                inputElementPassword.send_keys('24/7Express')

                time.sleep(2)
                inputElementPassword.send_keys(Keys.ENTER)

                #открываем страницу после установки куков

                time.sleep(2)
            except NoSuchElementException:
                msg_open = ' ... ERROR: [1] Не нашли подтверждения корректности страницы! | TimeoutException'
                status_open = '9'

        except TimeoutException:
            msg_open = ' ... ERROR: [1] Не нашли подтверждения корректности страницы! | TimeoutException'
            status_open = '9'

        #Проверяем, что открылась нужная страница
        try:
            browser.get(site_link)
            time.sleep(2)
            login_form = browser.find_element(By.ID, sign_open_service) #ищем подтверждение корректности открытой страницы
            msg_open = ' ... Страница сервиса открыта и доступна к работе!'
            status_open = '1'
        except NoSuchElementException:
            msg_open = ' ... ERROR: [2] Не нашли подтверждения корректности страницы! | NoSuchElementException'
            status_open = '9'
        except TimeoutException:
            msg_open = ' ... ERROR: Не нашли подтверждения корректности страницы! | TimeoutException'
            status_open = '9'

    except TimeoutException:
        msg_open = ' ... ERROR: Ошибка при открытии страницы! | TimeoutException'
        status_open = '9'


    return {'status_open': status_open, 'msg_open': msg_open}
