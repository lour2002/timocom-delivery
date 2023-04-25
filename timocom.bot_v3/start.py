import requests
import __auth as auth
import os

from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options


from structure import TestAuth
cur_dir = os.path.abspath(os.curdir + '\\timocom.bot_v3')

user_key = open(cur_dir + '\\key.txt').read().split('=')[0]
url = 'http://92.118.150.87'
auth_data = auth.check_auth(url, user_key)
print(auth_data)

#открываем браузер
print('=> Открываем браузер для работы с системой')

chrome_patch = cur_dir+'\\GoogleChromePortable\\GoogleChromePortable.exe'
chrome_driver_path = cur_dir+'\\chromedriver.exe'
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

service = Service(chrome_driver_path)
driver = webdriver.Chrome(service=service, options=options)
test_auth = TestAuth(driver)  # Создание объекта тестов для авторизации пользователя
test_auth.setup_method()

if auth_data['status'] == '1':  # авторизация прошла
    print(auth_data['msg'])

    # Бесконечный цикл
    while True:
        # Проходим по диапазону чисел от 1 до 6 (не включительно)
        for i in range(1, 6):
            # Собираем URL, подставляя номер задачи {i} и ключ пользователя
            full_url = f'{url}/api/get_task/?user_key={user_key}&num={i}'
            # Получаем ответ на запрос по URL
            response = requests.get(full_url)
            # Получаем JSON-данные из ответа
            data = response.json()
            # Проверяем статус задачи и выводим соответствующее сообщение
            if data['status_job'] == '2':
                print(f'... задача {i} в режиме IN TESTING'
                      f'... Начать выполнение теста')
                test_auth.test_run(data, url)
            elif data['status_job'] == '3':
                print(f'... задача {i} в режиме IS RUNNING'
                      f'... Начать выполнение теста')
                test_auth.test_run(data)
            else:
                print(f'... задача {i} в неопределенном состоянии')


else:
    print('Ошибка авторизации!', auth_data['msg'])

driver.quit()  # Закрытие окна браузера
